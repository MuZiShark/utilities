/**

 * @filename main.js
 * @create 2011-07-02
 * @author Jacky
 * @version 1.0 | 2011-07-02
 */

//设置列表表格隔行变色
$(document).ready(function() {
	initTableList();
	initForm();
});

// 初始化表格列表效果
function initTableList() {

	// 鼠标悬停背景高亮
	$(".tablelist tbody tr").hover(
		function(){
			$(this).addClass("tr-hover");
		},
		function(){
			$(this).removeClass("tr-hover");
		}
	);

	// 隔行换色
	$(".tablelist tr:even").addClass("bg");
}

// 初始化表单效果
function initForm() {

	// 文本框，文本域鼠标悬停背景高亮
	$(".myform input,textarea").hover(
		function(){
			$(this).addClass("hover");
		},
		function(){
			$(this).removeClass("hover");
		}
	);

	// 文本框，文本域获得焦点
	$(".myform input,textarea").focus(
		function(){
			$(this).removeClass("error");
			$(this).addClass("focus");
		}
	);

	// 文本框，文本域失去焦点
	$(".myform input,textarea").blur(
		function(){
			$(this).removeClass("error");
			$(this).removeClass("focus");
		}
	);
}

// 获取元素，并返回该元素的单个对象
var _$ = function(elementId) {
	return document.getElementById(elementId);
}

// 获取同名元素集合，并返回该同名元素的集合对象
var _$$ = function(elementName) {
	return document.getElementsByName(elementName);
}

// 获取同名标签集合，并返回该同名标签的集合对象
var _$$$ = function(tagName) {
	return document.getElementsByTagName(tagName);
}

// 判空
var _null = function(para) {
	if(para == "" || para == null || para == undefined) {
		return true;
	};
}

// 判断元素集合对象中至少有一子集合对象被选中
function checkSelect(elementName) {
	var tempElements = _$$(elementName);
	var selectNum = 0;

	for (var i = 0; i < tempElements.length; i++) {
		if (tempElements[i].checked) {
			selectNum++;
		}
	}

	if (selectNum > 0) {
		return true;
	} else {
		return false;
	}
}

// 复选框控制复选框全选/全不选
function cbControl(controlObj, checkboxName) {
	var checkBoxs = _$$(checkboxName);

	for ( var i=0; i<checkBoxs.length; i++ ) {
		checkBoxs[i].checked = controlObj.checked;
	}
}

// JS表单提交，表单必须设置ID，button的name/id绝对不能命名为“submit”，form中所有的组件（按钮，文本框等）的name/id也不能命名为“submit"
function doSubmit(formId, actionUrl) {
	if(!_null(actionUrl)) {
		_$(formId).action = actionUrl;
	}

	_$(formId).submit();
}

// 验证批量删除操作的有效性
function doBatchDelete(formId, actionUrl, checkboxName) {
	if (checkSelect(checkboxName)) {
		if (confirm('删除操作一旦执行，数据将不能恢复，请慎重操作。\n\n您确定要进行删除操作吗？')) {
			doSubmit(formId, actionUrl);
		}
	} else {
		alert("请勾选删除项！");
	}
}

// 验证批量操作的有效性
function checkboxAction(formId, actionUrl, checkboxName) {
	if (checkSelect(checkboxName)) {
		doSubmit(formId, actionUrl);
	} else {
		alert( "请在复选框里至少选择一条信息再进行操作，也可选择多条信息进行批量操作！" );
	}
}

// 翻页
function pageGoto(pageNumber,maxNumber)
{
	if(validateInteger(pageNumber))
	{
		if(pageNumber > maxNumber)
		{
			pageNumber = maxNumber;
		}

		//$("#goPageNumber").value = pageNumber;
		_$("goPageNumber").value = pageNumber;
		//$("#SearchForm").submit();
		_$("SearchForm").submit();
	}
	else
	{
		showErrorCue("页数为正整数,请重新输入!");
	}
}