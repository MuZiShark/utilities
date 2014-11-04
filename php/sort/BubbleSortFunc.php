<?php

	$arr = array(250, 75, 99, 67, 100, 87, 69, 90, 99, 89, 50);
	
	$result = BubbleSort($arr);
	
	var_dump($result);
	
	function BubbleSort($arr = array())
	{
		$length = count($arr);
		$exchange = FALSE;
		
		for($i=0; $i<$length;$i++)
		{
			for($j=$length-1; $j>$i; $j--)
			{
				if($arr[$j] < $arr[$j-1])
				{
					Swap($arr[$j],$arr[$j-1]);
					$exchange = TRUE;
				}
				if(!$exchange)	break;
			}
			//var_dump($arr);
		}
		//var_dump($arr);
		return $arr;
	}
	
	function Swap(&$x,&$y)
	{
		$tmp = $x;
		$x = $y;
		$y = $tmp;
	}

?>