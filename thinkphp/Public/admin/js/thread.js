$(function(){
	$("table[class=msgtable]").each(function () {
        var _this = $(this);
        //设置偶数行和奇数行颜色
        _this.find("tr:even").css("background-color", "#f8f8f8");
        _this.find("tr:odd").css("background-color", "#f0f0f0");
 
        //鼠标移动隔行变色hover用法关键
        _this.find("tr:not(:first)").hover(function () {
            $(this).attr("bColor", $(this).css("background-color")).css("background-color", "#E0E0E0").css("cursor", "pointer");
        }, function () {
            $(this).css("background-color", $(this).attr("bColor"));
        });
 
    });
	
});


//下面两个函数一起使用，限制输入字数eg::::onKeyDown="textdown(event,this,20)" onKeyUp="textup(this,20)"
function textdown(e,txt,num)
{
	textevent = e ;
	if(textevent.keyCode == num)
	{
		return;
	}
	if(txt.value.length >= num) 
	{
		keycode=e.which||e.keyCode
		if(keycode!=8){
			alert("注意右边提示的字数限制，字数不能超过"+num+"个！");
			//txt.value='';
			if(!document.all)
			{
				textevent.preventDefault();
			}
			else
			{
				textevent.returnValue = false;
			}
		}
	}
}
function textup(txt,num)
{
	var s = txt.value;
	//判断ID为text的文本区域字数是否超过num个
	if(s.length > num) 
	{
		txt.value=s.substring(0,num);
	}
}