<?

	function length_too_small($length) {
	
		if($length < 60)
			return true;
		else
			return false;
	
	}
	
	function length_close_to_average($length, $average, $slide = 10) {
	
 		$average = $average * 60;
		
		$max = $average + ($average * ($slide / 100));
		$min = $average - ($average * ($slide / 100));
		
		if(($length < $max) && ($length > $min))
			return true;
		else
			return false;
	
	}