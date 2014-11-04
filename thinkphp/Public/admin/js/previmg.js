//图片预览
function prevImg(fileObj,img){
	var pojb = fileObj.parentNode.parentNode.parentNode;
	var rePic = /.(png|jpg|gif)$/i;  //图片格式
	var oImg;
	if(img){
		oImg = document.getElementById(img);
	}else{
		oImg = pojb.getElementsByTagName('img')[0];
	}
	var browserVersion= window.navigator.userAgent.toUpperCase();
	if(rePic.test(fileObj.value)){
		if(fileObj.files){
			if(window.FileReader){
				var reader = new FileReader();
				reader.onload = function(e){
					oImg.src = "";
					oImg.setAttribute("src",e.target.result);
				};
				reader.readAsDataURL(fileObj.files[0]);
			}else if(browserVersion.indexOf("SAFARI")>-1){
                alert("不支持Safari6.0以下浏览器的图片预览!");
            }
		}else if (browserVersion.indexOf("MSIE")>-1){
			 oImg.src=""; 
	         oImg.setAttribute("src",fileObj.value);
		}
	}else{
        alert("不支持此格式！");
        fileObj.value="";//清空选中文件
        if(browserVersion.indexOf("MSIE")>-1){                        
            fileObj.select();
            document.selection.clear();
        }
    }
}