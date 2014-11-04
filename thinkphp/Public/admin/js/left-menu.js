/* 
   Simple JQuery Accordion menu.
   HTML structure to use:

   <ul id="menu">
     <li><a href="javascript:void('Sub menu heading');">Sub menu heading</a>
     <ul>
       <li><a href="http://site.com/">Link</a></li>
       <li><a href="http://site.com/">Link</a></li>
       <li><a href="http://site.com/">Link</a></li>
       ...
       ...
     </ul>
     <li><a href="javascript:void('sm-gis');">Sub menu heading</a>
     <ul>
       <li><a href="http://site.com/">Link</a></li>
       <li><a href="http://site.com/">Link</a></li>
       <li><a href="http://site.com/">Link</a></li>
       ...
       ...
     </ul>
     ...
     ...
   </ul>

Copyright 2007 by Marco van Hylckama Vlieg

web: http://www.i-marco.nl/weblog/
email: marco@i-marco.nl
Download by http://sc.xueit.com
Free for non-commercial use
*/

function initMenu() {
	//$("#menu ul").hide();
	//$("#menu .first ul").show();
	
	$("#menu li a").click(
		function() {
			var checkElement = $(this).next();

			$(this).blur();	// 去除点击后的虚线
			
			$("#menu li a").removeClass("current");
			
			if((checkElement.is("ul")) && (checkElement.is(":visible"))) {
				checkElement.slideUp("normal");
				return false;
			}
			
			if((checkElement.is("ul")) && (!checkElement.is(":visible"))) {
				$("#menu ul:visible").slideUp("normal");
				checkElement.slideDown("normal");
				$(this).addClass("current");
				return false;
			}
		}
	);
	
	$(".content li a").click(
		function() {
			var checkElement = $(this).next();

			$(this).blur();	// 去除点击后的虚线
			
			$(".content li a").removeClass("active");
			
			$(this).addClass("active");
		}
	);
}

$(document).ready(function() {initMenu();});