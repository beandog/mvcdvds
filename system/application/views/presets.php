<?

	echo heading("Presets");
	
	$a = anchor("presets/create_new", "Create New Preset");
	
	echo "<p>$a</p>";
	
	
	foreach($presets as $id => $name) {
		
		$a = anchor("presets/index/$id", $name);
	
		$arr[] = $a;
	
	}
	
	echo ul($arr);