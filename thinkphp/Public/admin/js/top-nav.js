/**

 * @filename top-nav.js
 * @create 2011-07-02
 * @author Jacky
 * @version 1.0 | 2011-07-02
 */

function initTopNav() {
	$(".top-nav li a").click(
		function() {
			
			$(this).blur();	// 去除点击后的虚线
			
			$(".top-nav li a").removeClass("active");
			
			$(this).addClass("active");
		}
	);
}

$(document).ready(function() {initTopNav();});