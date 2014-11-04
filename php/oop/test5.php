<?php

/**
 * PHP面向对象：final、self、static
 *
 *
 */

	final class MyPC {
		
		static $name='我的电脑';
		
		final function power() {
			return self::$name.'打开电源，正在开机……';
		}
		
	}
	
	$p = new MyPC();
	echo $p->power().'<br />';
	
	MyPC::$name = '你的电脑';
	echo MyPC::power().'<br />';



?>
