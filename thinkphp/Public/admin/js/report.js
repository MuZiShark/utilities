/**
 * @filename report.js
 * @create 2013-09-18
 * @author yaohaiqi
 * @version 1.0 | 2013-09-18
 */

var host = location.protocol+'//'+location.host;
function dealscore(score){
    var s = $(score).val();
    var f = $(score).attr("ref");
    var l = $(score).attr("rel");
    if(-4 < s < 4){
        $.post(host+"/Mmqadmin/Report/dealReport",{id:l,uid:f,s:s},
            function(data){ 
            if(data==1){
                $("#"+l).remove();
                jSuccess("操作成功!",{
                    VerticalPosition : 'center',
                    HorizontalPosition : 'center'
                });
            }else{ 
                jError(data+"，请重试!");
            }
        });
    }
}

$(".delete").live("click",function(){
    if (confirm('删除操作一旦执行，数据将不能恢复，请慎重操作。\n\n您确定要进行删除操作吗？')) {
        var id = $(this).attr("rel");
        $.post(host+"/Mmqadmin/Report/delReport",{id:id},
        function(data){ 
            if(data==1){
                $("#"+id).remove();
                jSuccess("操作成功!",{
                    VerticalPosition : 'center',
                    HorizontalPosition : 'center'
                });
            }else{ 
                jError(data+"，请重试!");
            } 
        }); 
    }
});

$(".multidelete").live("click",function(){
    var s =[]; 
    $('input[name="CB_ID"]:checked').each(function(){  
        s.push($(this).val());
    });
    if(s.length==0){
        jNotify('请勾选操作项！');
    }else{
        if (confirm('删除操作一旦执行，数据将不能恢复，请慎重操作。\n\n您确定要进行删除操作吗？')) {
            $.post(host+"/Mmqadmin/Report/delReport",{id:s},
                function(data){ 
                if(data==1){
                    for(var i=0;i<s.length;i++){
                        $("#"+s[i]).remove();
                    }
                    jSuccess("操作成功!",{
			VerticalPosition : 'center',
			HorizontalPosition : 'center'
                    });
                }else{ 
                    jError(data+"，请重试!");
                }
            }); 
        }
    }
});

function dealmultiscore(score){
    var p =[];
    var s =[];
    var score = $(score).val();
    $('input[name="CB_ID"]:checked').each(function(){
        p.push($(this).attr("rel"));
        s.push($(this).val());
    });
    if(p.length==0){
        $("#multiscore").val('+4');
        jNotify('请勾选操作项！');
    }else{
        $.post(host+"/Mmqadmin/Report/dealMultiReport",{p:p,score:score},
            function(data){ 
            if(data==1){
                $("#multiscore").val('+4');
                for(var i=0;i<s.length;i++){
                    $("#"+s[i]).remove();
                }
                jSuccess("操作成功!",{
                    VerticalPosition : 'center',
                    HorizontalPosition : 'center'
                });
            }else{
                $("#multiscore").val('+4');
                jError(data+"，请重试!");
            }
        }); 
    }
}