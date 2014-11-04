/**
 * MMQ全局变量
 */
var MMQ = {

	'setting' : {

    },

    'toMemberHome' : function (uid) {
        var id = parseInt(uid);
        var url = this.setting.URL + '/member/home';
        if (id > 0) {
            url += '/uid/' + id;
        }
        location.href = url;
        return false;
    },
    'showPopup' : function (conf){
		if(conf.msg!=''){
			document.getElementById('creditpromptdiv').innerHTML = conf.msg;
			document.getElementById('ntcwin').style.display = '';
			var objWidth = jQuery('#ntcwin').width();
			var docWidth = jQuery(document).width();
			var leftPos = (docWidth - objWidth) / 2 ;
			jQuery('#ntcwin').css({'left':leftPos+'px'});	
			
			setTimeout(function(){
				document.getElementById('ntcwin').style.display = 'none';
			},conf.timeout);
		}else{
			document.getElementById('ntcwin').style.display = 'none';
		}
    },
    'showDialog' : function (title, msg, icon,ck,cck){
	    	fusion2.canvas.getClientRect({
	    		onSuccess : function (rect) {
	    			art.dialog({
	    	            top:  (rect.bottom  + rect.top)/2 - 180,
	    	            width : 370,
	    	            icon: icon?icon:'error',
	    	            title : title,
	    	            content: msg,
	    	            fixed: false,
	    	            ok : ck,
	    	            close : cck
	    	        }); 
	    		}	
	    });
	},    
    'search' : function () {

        var option = jQuery("#search_box select[name='option']").val();
        var keywords = jQuery("#search_box input[name='keywords']").val();
        if (keywords.length == 0 || typeof keywords == 'undefined') {

            alert("关键字不能为空");
            return false;

        } else {

            if (option == 'username') {
                jQuery("#search_box").attr('action', MMQ.setting.URL + '/home/searchuser');
            } else if (option == 'forum') {
                jQuery("#search_box").attr('action', MMQ.setting.URL + '/Qzone/search');
            }
            return true;
        }
    },
    'resetHeight' : function() {
	    	window.setInterval(function() {
	    		// 定时调整应用高度
	    	    fusion2.canvas.setHeight({ height : fusion.LIB.getScrollHeight() });
	    	    if((this.setting.MODULE_NAME + '_' + this.setting.ACTION_NAME).toLowerCase() != 'group_imagethreads') {
	        		// 定时设置弹窗 top
	        		if(jQuery('.aui_state_focus').length > 0) {
	        	        fusion2.canvas.getClientRect({
	        	            onSuccess : function (rect) {
								//console.log(rect);
	        	            	jQuery('.aui_state_focus').css('top', (rect.clientTop || window.scrollY)+250);
	        	            }
	        	        });
	        		}
	    	    }
	    	}, 500);
    },
    'setScroll': function(){
    	if(MMQ.setting.IgnoreScroll!=1){
    		if(MMQ.setting.ScrollToPost>0){
    			setTimeout(function(){
	    			var offset = jQuery('#post_'+MMQ.setting.ScrollToPost).offset();
	        		fusion2.canvas.setScroll({top:offset.top,left:offset.left});
    			},501);
    		}else{
    			if((MMQ.setting.MODULE_NAME + '/' + MMQ.setting.ACTION_NAME).toLowerCase() == 'group/thread' && MMQ.setting.PageNum>0) {
    				setTimeout(function(){
    	    			var offset = jQuery('#__reply__').offset();
    	        		fusion2.canvas.setScroll({top:offset.top,left:offset.left});
        			},501);
    			} else {
		    		setTimeout(function(){
		    			fusion2.canvas.setScroll({top:0,left:0});
		    		},501);
    			}
    		}
    	}
    }
}

jQuery(document).ready(function(){
    jQuery(".searchbtn a").click(function() {
        jQuery(".nav_searchDiv").toggle();
        jQuery(".nav_searchDiv").is(":hidden ")?jQuery(".searchbtn").removeClass("on"):jQuery(".searchbtn").addClass("on");
    });
    
    MMQ.resetHeight();
    MMQ.setScroll();
});