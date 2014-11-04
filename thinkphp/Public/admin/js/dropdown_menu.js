// JavaScript Document 列表页下拉框
function showSelect(hld,id){
    var ele = document.getElementById(id);
    ele.style.display = 'block';
    var timer = null;
    ele.onmouseover = function(){
        if(timer){
            clearTimeout(timer);
        }
        ele.style.display = 'block';
    }
    ele.onmouseout = function(){
        timer = setTimeout(function(){ele.style.display = 'none'},500);
    }
    
    hld.onmouseover = function(){
        if(timer){
            clearTimeout(timer);
        }
    }
    hld.onmouseout = function(){
        timer = setTimeout(function(){ele.style.display = 'none'},500);
    }
}