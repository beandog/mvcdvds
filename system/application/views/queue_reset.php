<?
	echo p();
	
	$a_queue_reset = anchor("queue/reset", "Reset Queue", "onclick='return confirm(\"Reset the queue?\");'");
	
	echo $a_queue_reset;