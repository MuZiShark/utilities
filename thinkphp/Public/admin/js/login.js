/**

 * @filename login.js
 * @create 2011-07-04
 * @author Jacky
 * @version 1.0 | 2011-07-04
 */

$(document).ready(function() {
        $("#username").focus();
        $("#username").addClass("focus");
	initForm();
	
	// 初始化表单效果
	function initForm() {
	
		// 文本框，文本域获得焦点
		$(".box-middle input").focus(
			function(){
				$(this).addClass("focus");
			}
		);
	
		// 文本框，文本域失去焦点
		$(".box-middle input").blur(
			function(){
				$(this).removeClass("focus");
				$(this).removeClass("error");
			}
		);
	}
	
	/*******************************************************************************************************************/

	// 提交时验证表单
	jQuery("#loginButton").click(function(){ 
		if(!validator.form()){ 
			validator.focusInvalid();
			return false; 
		}

		jQuery("#loginForm").submit();
	});

	// 定义登录表单验证
	var validator = jQuery("#loginForm").validate({

		// 定义验证规则
		rules: {
			username: {
				required: true
				//required: true,
				//minlength: 4,
			},
			password: {
				required: true
				//required: true,
				//minlength: 6
			}
			//code: {
			//	required:true
				//required:true,
				//minlength: 4
			//}
		},

		// 定义错误信息 
		messages: {
			username: {
				required: "请输入用户名"
				//required: "请输入用户名！",
				//minlength: "用户名长度至少为4位。"
			},
			password: {
				required: "请输入密码"
				//required: "请输入密码！",
				//minlength: "密码长度至少为6位。"
			}
            //            code: {
			//	required: "请输入4位验证码"
				//required: "请输入密码！",
				//minlength: "密码长度至少为6位。"
			//}
		},
		
		// 定义错误信息提示的位置和样式
		errorElement: "em",	// 定义错误标记标签，<em>error</em>

		errorPlacement: function(error,element){
			//element.next("i").addClass("error");
			element.next("i").append(error);
		},
		
		// 定义验证成功相关样式和事件
		success: function(label) {
		}
	});
});