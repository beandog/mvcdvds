<?

	function length_too_small($length) {
	
		if($length < 60)
			return true;
		else
			return false;
	
	}
	
	function length_close_to_average($length, $average, $slide = 10) {
	
 		$average = $average * 60;
		
		// The +/- 60 is to pad the average by one minute,
		// so if something is within 120 seconds of it, it's probably valid.
		// Fex: if average is 7 mins, then 6 and 8 mins will
		// immediately fall in the range
		$max = $average + 60 + ($average * ($slide / 100));
		$min = $average - 60 - ($average * ($slide / 100));

		if(($length < $max) && ($length > $min))
			return true;
		else
			return false;
	
	}
