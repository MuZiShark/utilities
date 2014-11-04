/*
	[Discuz!] (C)2001-2009 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: forum_post.js 21022 2011-03-10 07:08:23Z congyushuai $
*/

var postSubmited = false;
var AID = 1;
var UPLOADSTATUS = -1;
var UPLOADFAILED = UPLOADCOMPLETE = AUTOPOST =  0;
var CURRENTATTACH = '0';
var FAILEDATTACHS = '';
var UPLOADWINRECALL = null;
var STATUSMSG = {
	'-1' : '内部服务器错误',
	'0' : '上传成功',
	'1' : '不支持此类扩展名',
	'2' : '服务器限制无法上传那么大的附件',
	'3' : '用户组限制无法上传那么大的附件',
	'4' : '不支持此类扩展名',
	'5' : '文件类型限制无法上传那么大的附件',
	'6' : '本日已无法上传更多的附件',
	'7' : '图片附件不合法',
	'8' : '附件文件无法保存',
	'9' : '没有合法的文件被上传',
	'10' : '非法操作'
};

function ctlent(event) {
	if(postSubmited == false && (event.ctrlKey && event.keyCode == 13) || (event.altKey && event.keyCode == 83) && $('postsubmit')) {
		if(in_array($('postsubmit').name, ['topicsubmit', 'replysubmit', 'editsubmit']) && !validate($('postform'))) {
			doane(event);
			return;
		}
		postSubmited = true;
		$('postsubmit').disabled = true;
		$('postform').submit();
	}
	if(event.keyCode == 9) {
		doane(event);
	}
}

function checklength(theform) {
	var message = wysiwyg ? html2bbcode(getEditorContents()) : (!theform.parseurloff.checked ? parseurl(theform.message.value) : theform.message.value);
	MMQW.showDialog('当前长度: ' + mb_strlen(message) + ' 字节，' + (postmaxchars != 0 ? '系统限制: ' + postminchars + ' 到 ' + postmaxchars + ' 字节。' : ''), 'notice', '字数检查');
}

if(!tradepost) {
	var tradepost = 0;
}

function validate(theform) {
	var message = wysiwyg ? html2bbcode(getEditorContents()) :  theform.message.value;
	if(trim(theform.subject.value) == "") {
		MMQW.showDialog('提示信息','请完成帖子标题栏','error',function(){
			theform.subject.focus();
		});
		
		return false;
	} else if(mb_strlen(theform.subject.value) > 90) {
		MMQW.showDialog('提示信息','您的标题超过 90 个字符的限制','error',function(){
			theform.subject.focus();
		});
		return false;
	}
	if(trim(message) == ""){
		MMQW.showDialog('提示信息','请完成帖子内容','error');
		return false;
	}
	
	if(typeof validateextra == 'function') {
		var v = validateextra();
		if(!v) {
			return false;
		}
	}
	if((postminchars != 0 && mb_strlen(message) < postminchars) || (postmaxchars != 0 && mb_strlen(message) > postmaxchars)) {
        MMQW.showDialog('提示信息','您的帖子长度不符合要求。');
		return false;
	}
	if(theform.fid.value=="-1"){
		MMQW.showDialog('提示信息','请选择要发贴的圈子','error',function(){
			var oc = $('quan_select').className;
			$('quan_select').className = oc + ' send_err_select';
			theform.fid.focus();
		});
		return false;
	}
	if(UPLOADSTATUS == 0) {
		if(!confirm('您有等待上传的附件，确认不上传这些附件吗？')) {
			return false;
		}
	} else if(UPLOADSTATUS == 1) {
		MMQW.showDialog('提示信息','您有正在上传的附件，请稍候，上传完成后帖子将会自动发表...', 'notice');
		AUTOPOST = 1;
		return false;
	}
	hideMenu();
	theform.message.value = message;

	return true;

}
function validate_reply(theform) {
	var message = wysiwyg ? html2bbcode(getEditorContents()) :  theform.message.value;
	if(trim(message) == ""){
		MMQW.showDialog('提示信息','输入要回复的内容','error');
		return false;
	}
	
	if(typeof validateextra == 'function') {
		var v = validateextra();
		if(!v) {
			return false;
		}
	}
	if((postminchars != 0 && mb_strlen(message) < postminchars) || (postmaxchars != 0 && mb_strlen(message) > postmaxchars)) {
        MMQW.showDialog('提示信息','您的帖子长度不符合要求。');
//		MMQW.showDialog('提示信息','您的帖子长度不符合要求。\n\n当前长度: ' + mb_strlen(message) + ' 字节\n系统限制: ' + postminchars + ' 到 ' + postmaxchars + ' 字节','error');
		return false;
	}
	hideMenu();
	theform.message.value = message;
	return true;
}
function postsubmit(theform) {
	theform.replysubmit ? theform.replysubmit.disabled = true : (theform.editsubmit ? theform.editsubmit.disabled = true : theform.topicsubmit.disabled = true);
	theform.submit();
}

function loadData(quiet) {
	var data = '';
	data = loadUserdata('forum');

	if(in_array((data = trim(data)), ['', 'null', 'false', null, false])) {
		if(!quiet) {
			MMQW.showDialog('提示信息','没有可以恢复的数据！');
		}
		return;
	}

	if(!quiet && !confirm('此操作将覆盖当前帖子内容，确定要恢复数据吗？')) {
		return;
	}

	var data = data.split(/\x09\x09/);
	for(var i = 0; i < $('postform').elements.length; i++) {
		var el = $('postform').elements[i];
		if(el.name != '' && (el.tagName == 'TEXTAREA' || el.tagName == 'INPUT' && (el.type == 'text' || el.type == 'checkbox' || el.type == 'radio'))) {
			for(var j = 0; j < data.length; j++) {
				var ele = data[j].split(/\x09/);
				if(ele[0] == el.name) {
					elvalue = !isUndefined(ele[3]) ? ele[3] : '';
					if(ele[1] == 'INPUT') {
						if(ele[2] == 'text') {
							el.value = elvalue;
						} else if((ele[2] == 'checkbox' || ele[2] == 'radio') && ele[3] == el.value) {
							el.checked = true;
							evalevent(el);
						}
					} else if(ele[1] == 'TEXTAREA') {
						if(ele[0] == 'message') {
							if(!wysiwyg) {
								textobj.value = elvalue;
							} else {
								editdoc.body.innerHTML = bbcode2html(elvalue);
							}
						} else {
							el.value = elvalue;
						}
					}
					break
				}
			}
		}
	}
}

function evalevent(obj) {
	var script = obj.parentNode.innerHTML;
	var re = /onclick="(.+?)["|>]/ig;
	var matches = re.exec(script);
	if(matches != null) {
		matches[1] = matches[1].replace(/this\./ig, 'obj.');
		eval(matches[1]);
	}
}

function relatekw(subject, message, recall) {
	if(isUndefined(recall)) recall = '';
	if(isUndefined(subject) || subject == -1) subject = $('subject').value;
	if(isUndefined(message) || message == -1) message = getEditorContents();
	subject = (BROWSER.ie && document.charset == 'utf-8' ? encodeURIComponent(subject) : subject);
	message = (BROWSER.ie && document.charset == 'utf-8' ? encodeURIComponent(message) : message);
	message = message.replace(/&/ig, '', message).substr(0, 500);
	ajaxget('forum.php?mod=relatekw&subjectenc=' + subject + '&messageenc=' + message, 'tagselect', '', '', '', recall);
}

function switchicon(iconid, obj) {
	$('iconid').value = iconid;
	$('icon_img').src = obj.src;
	hideMenu();
}

function clearContent() {
	if(wysiwyg) {
		editdoc.body.innerHTML = BROWSER.firefox ? '<br />' : '';
	} else {
		textobj.value = '';
	}
}

function uploadNextAttach() {
	var str = $('attachframe').contentWindow.document.body.innerHTML;
	if(str == '') return;
	var arr = str.split('|');
	var att = CURRENTATTACH.split('|');
	uploadAttach(parseInt(att[0]), arr[0] == 'DISCUZUPLOAD' ? parseInt(arr[1]) : -1, att[1]);
}

function uploadAttach(curId, statusid, prefix) {
	prefix = isUndefined(prefix) ? '' : prefix;
	var nextId = 0;
	for(var i = 0; i < AID - 1; i++) {
		if($(prefix + 'attachform_' + i)) {
			nextId = i;
			if(curId == 0) {
				break;
			} else {
				if(i > curId) {
					break;
				}
			}
		}
	}
	if(nextId == 0) {
		return;
	}
	CURRENTATTACH = nextId + '|' + prefix;
	if(curId > 0) {
		if(statusid == 0) {
			UPLOADCOMPLETE++;
		} else {
			FAILEDATTACHS += '<br />' + mb_cutstr($(prefix + 'attachnew_' + curId).value.substr($(prefix + 'attachnew_' + curId).value.replace(/\\/g, '/').lastIndexOf('/') + 1), 25) + ': ' + STATUSMSG[statusid];
			UPLOADFAILED++;
		}
		$(prefix + 'cpdel_' + curId).innerHTML = '<img src="' + IMGDIR + '/check_' + (statusid == 0 ? 'right' : 'error') + '.gif" alt="' + STATUSMSG[statusid] + '" />';
		if(nextId == curId || in_array(statusid, [6, 8])) {
			if(prefix == 'img') updateImageList();
			else updateAttachList();
			if(UPLOADFAILED > 0) {
				MMQW.showDialog('提示信息','附件上传完成！成功 ' + UPLOADCOMPLETE + ' 个，失败 ' + UPLOADFAILED + ' 个:' + FAILEDATTACHS);
				FAILEDATTACHS = '';
			}
			UPLOADSTATUS = 2;
			for(var i = 0; i < AID - 1; i++) {
				if($(prefix + 'attachform_' + i)) {
					reAddAttach(prefix, i)
				}
			}
			$(prefix + 'uploadbtn').style.display = '';
			$(prefix + 'uploading').style.display = 'none';
			if(AUTOPOST) {
				hideMenu();
				validate($('postform'));
			} else if(UPLOADFAILED == 0 && (prefix == 'img' || prefix == '')) {
				MMQW.showDialog('提示信息','附件上传完成！');
			}
			UPLOADFAILED = UPLOADCOMPLETE = 0;
			CURRENTATTACH = '0';
			FAILEDATTACHS = '';
			return;
		}
	} else {
		$(prefix + 'uploadbtn').style.display = 'none';
		$(prefix + 'uploading').style.display = '';
	}
	$(prefix + 'cpdel_' + nextId).innerHTML = '<img src="' + IMGDIR + '/loading.gif" alt="上传中..." />';
	UPLOADSTATUS = 1;
	$(prefix + 'attachform_' + nextId).submit();
}

function addAttach(prefix) {
	var id = AID;
	var tags, newnode, i;
	prefix = isUndefined(prefix) ? '' : prefix;
	newnode = $(prefix + 'attachbtnhidden').firstChild.cloneNode(true);
	tags = newnode.getElementsByTagName('input');
	for(i in tags) {
		if(tags[i].name == 'Filedata') {
			tags[i].id = prefix + 'attachnew_' + id;
			tags[i].onchange = function() {insertAttach(prefix, id)};
			tags[i].unselectable = 'on';
		} else if(tags[i].name == 'attachid') {
			tags[i].value = id;
		}
	}
	tags = newnode.getElementsByTagName('form');
	tags[0].name = tags[0].id = prefix + 'attachform_' + id;
	$(prefix + 'attachbtn').appendChild(newnode);
	newnode = $(prefix + 'attachbodyhidden').firstChild.cloneNode(true);
	tags = newnode.getElementsByTagName('input');
	for(i in tags) {
		if(tags[i].name == prefix + 'localid[]') {
			tags[i].value = id;
		}
	}
	tags = newnode.getElementsByTagName('span');
	for(i in tags) {
		if(tags[i].id == prefix + 'localfile[]') {
			tags[i].id = prefix + 'localfile_' + id;
		} else if(tags[i].id == prefix + 'cpdel[]') {
			tags[i].id = prefix + 'cpdel_' + id;
		} else if(tags[i].id == prefix + 'localno[]') {
			tags[i].id = prefix + 'localno_' + id;
		} else if(tags[i].id == prefix + 'deschidden[]') {
			tags[i].id = prefix + 'deschidden_' + id;
		}
	}
	AID++;
	newnode.style.display = 'none';
	$(prefix + 'attachbody').appendChild(newnode);
}

function insertAttach(prefix, id) {
	var localimgpreview = '';
	var path = $(prefix + 'attachnew_' + id).value;
	var extpos = path.lastIndexOf('.');
	var ext = extpos == -1 ? '' : path.substr(extpos + 1, path.length).toLowerCase();
	var re = new RegExp("(^|\\s|,)" + ext + "($|\\s|,)", "ig");
	var localfile = $(prefix + 'attachnew_' + id).value.substr($(prefix + 'attachnew_' + id).value.replace(/\\/g, '/').lastIndexOf('/') + 1);
	var filename = mb_cutstr(localfile, 30);

	if(path == '') {
		return;
	}
	if(extensions != '' && (re.exec(extensions) == null || ext == '')) {
		reAddAttach(prefix, id);
		MMQW.showDialog('提示信息','对不起，不支持上传此类扩展名的附件。');
		return;
	}
	if(prefix == 'img' && imgexts.indexOf(ext) == -1) {
		reAddAttach(prefix, id);
		MMQW.showDialog('提示信息','请选择图片文件(' + imgexts + ')');
		return;
	}

	$(prefix + 'cpdel_' + id).innerHTML = '<a href="javascript:;" class="d" onclick="reAddAttach(\'' + prefix + '\', ' + id + ')">删除</a>';
	$(prefix + 'localfile_' + id).innerHTML = '<span>' + filename + '</span>';
	$(prefix + 'attachnew_' + id).style.display = 'none';
	$(prefix + 'deschidden_' + id).style.display = '';
	$(prefix + 'deschidden_' + id).title = localfile;
	$(prefix + 'localno_' + id).parentNode.parentNode.style.display = '';
	addAttach(prefix);
	UPLOADSTATUS = 0;
}

function reAddAttach(prefix, id) {
	$(prefix + 'attachbody').removeChild($(prefix + 'localno_' + id).parentNode.parentNode);
	$(prefix + 'attachbtn').removeChild($(prefix + 'attachnew_' + id).parentNode.parentNode);
	$(prefix + 'attachbody').innerHTML == '' && addAttach(prefix);
	$('localimgpreview_' + id) ? document.body.removeChild($('localimgpreview_' + id)) : null;
}

function delAttach(id, type) {
	appendAttachDel(id);
	$('attach_' + id).style.display = 'none';
	ATTACHNUM['attach' + (type ? 'un' : '') + 'used']--;
	updateattachnum('attach');
}

function delImgAttach(id, type) {
	appendAttachDel(id);
	$('image_li_' + id).innerHTML = '';
	if($('uu_image_li_' + id))
		$('uu_image_li_' + id).className = 'imgdeleted';
	//$('uu_image_' + id).onclick = null;

	ATTACHNUM['image' + (type ? 'un' : '') + 'used']--;
	updateattachnum('image');
}

function appendAttachDel(id) {
	var input = document.createElement('input');
	input.name = 'attachdel[]';
	input.value = id;
	input.type = 'hidden';
	$('postform').appendChild(input);
}

function updateAttach(aid) {
	objupdate = $('attachupdate'+aid);
	obj = $('attach' + aid);
	if(!objupdate.innerHTML) {
		obj.style.display = 'none';
		objupdate.innerHTML = '<input type="file" name="attachupdate[paid' + aid + ']"><a href="javascript:;" onclick="updateAttach(' + aid + ')">取消</a>';
	} else {
		obj.style.display = '';
		objupdate.innerHTML = '';
	}
}



function updateattachnum(type) {
	ATTACHNUM[type + 'used'] = ATTACHNUM[type + 'used'] >= 0 ? ATTACHNUM[type + 'used'] : 0;
	ATTACHNUM[type + 'unused'] = ATTACHNUM[type + 'unused'] >= 0 ? ATTACHNUM[type + 'unused'] : 0;
	var num = ATTACHNUM[type + 'used'] + ATTACHNUM[type + 'unused'];
	if(num) {
		if($(editorid + '_' + type)) {
			$(editorid + '_' + type).title = '包含 ' + num + (type == 'image' ? ' 个图片附件' : ' 个附件');
		}
		if($(editorid + '_' + type + 'n')) {
			$(editorid + '_' + type + 'n').style.display = '';
		}
		$('imgattach_notice').style.display = '';
	} else {
		if($(editorid + '_' + type)) {
			$(editorid + '_' + type).title = type == 'image' ? '图片' : '附件';
		}
		if($(editorid + '_' + type + 'n')) {
			$(editorid + '_' + type + 'n').style.display = 'none';
		}
		$('imgattach_notice').style.display = 'none';
	}
	
}

function unusedoption(op, aid) {
	if(!op) {
		if($('unusedimgattachlist')) {
			$('unusedimgattachlist').parentNode.removeChild($('unusedimgattachlist'));
		}
		
		ATTACHNUM['imageunused'] = 0;
	} else if(op == 1) {
		for(var i = 0; i < $('unusedform').elements.length; i++) {
			var e = $('unusedform').elements[i];
			if(e.name.match('unused')) {
				if(!e.checked) {
					if($('image_li_' + e.value)) {
						$('image_li_' + e.value).outerHTML = '';
						ATTACHNUM['imageunused']--;
					}
				}
			}
		}
	} else if(op == 2) {
		delAttach(aid, 1);
	} else if(op == 3) {
		delImgAttach(aid, 1);
	}
	if(op < 2) {
		hideMenu('fwin_dialog', 'dialog');
		updateattachnum('image');
	} else {
		$('image_li_' + aid).outerHTML = '';
		if(!ATTACHNUM['imageunused']) {
			hideMenu('fwin_dialog', 'dialog');
		}
	}
	if(!ATTACHNUM['imageunused']){
		if($('unusedimgattachlist')) {
			$('unusedimgattachlist').parentNode.removeChild($('unusedimgattachlist'));
		}
	}else{
		if($('imgattachlist')) {
			$('imgattachlist').style.display = 'none';
		}
		
	}
}

function swfHandler(action, type) {
	if(action == 2) {
		if(type == 'image') {
			updateImageList(action);
		} else {
			updateAttachList(action);
		}
	}
}


function updateImageList(action) {
	var type = !isUndefined(imagetype)?imagetype:'newthread';
	jQuery.get(MMQW.setting.URL + '/attachment/imagelist/pid/0/tid/0/imagetype/'+type+'/posttime/' + $('posttime').value,function(data){
		jQuery('#imgattachlist').html(data);
	});
	var obj = jQuery('#e_imgattachlist');
	if(obj.height()>505){
		obj.css({'height':'505px','overflow-x':'hidden','overflow-y':'auto'});
	}
	switchImagebutton('imgattachlist');
	$('imgattach_notice').style.display = '';
}

function switchButton(btn, btns) {
	if(!$(editorid + '_btn_' + btn) || !$(editorid + '_' + btn)) {
		return;
	}
	$(editorid + '_btn_' + btn).style.display = '';
	$(editorid + '_' + btn).style.display = '';
	$(editorid + '_btn_' + btn).className = 'current';
	for(i = 0;i < btns.length;i++) {
		if(btns[i] != btn) {
			if(!$(editorid + '_' + btns[i]) || !$(editorid + '_btn_' + btns[i])) {
				continue;
			}
			$(editorid + '_' + btns[i]).style.display = 'none';
			$(editorid + '_btn_' + btns[i]).className = '';
		}
	}
}

function uploadWindowstart() {
	$('uploadwindowing').style.visibility = 'visible';
	$('uploadsubmit').disabled = true;
}


function insertsave(pid) {
	var x = new Ajax();
	x.get('forum.php?mod=misc&action=loadsave&inajax=yes&pid=' + pid + '&type=' + wysiwyg, function(str, x) {
		insertText(str, str.length, 0);
	});
}