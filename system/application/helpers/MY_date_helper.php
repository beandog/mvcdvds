<?

	function format_seconds($float, $format = 'm:s') {
	
		$mins = floor($float / 60);
		
		$mins = str_pad($mins, 2, 0, STR_PAD_LEFT);
		
		$secs = $float % 60;
		
		$decimal = round($float - floor($float), 3);
		
		if($format == "m s") {
			$secs = str_pad($secs, 2, 0, STR_PAD_LEFT);
			$str = "${mins}m ${secs}s";
 		} elseif($format == 'm:s') {
 			$secs = str_pad($secs, 2, 0, STR_PAD_LEFT);
 			$str = "$mins:$secs";
 		} elseif($format == "m:s:ms") {
			$secs = $secs + $decimal;
			$secs = number_format($secs, 3);
			$secs = str_pad($secs, 6, 0, STR_PAD_LEFT);
 		}
		
		return $str;
	
	}