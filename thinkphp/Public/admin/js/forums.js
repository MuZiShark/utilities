/**
 * ClQ全局变量
 */
var CLQW = {

	getForumTypes: function(forum,show,type) {
		
		var fid = $('#'+forum).val();
		if(fid == ''){
			alert('请选择版块');
			return ;
		}
			
		$.getJSON("/Mmqadmin/ajax/getforumtypes?fid="+fid+"&type="+type,function(result){																			
																								
			if(typeof result != 'undefined') {
				if(result['errmsg']['errno'] <0 ){
					alert(result['errmsg']['errmsg']);
					return;
				}
				
 				var data = result['data'];
				$('#'+show).html(data);
				
			}else{
				alert('操作异常');
			}
		});
		 
	},

	
}

$(document).ready(function(){
	
});