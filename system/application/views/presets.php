<?

	echo heading("Presets", 2);

	foreach($presets as $id => $name) {

		$a = anchor("presets/index/$id", $name);

		$arr[] = $a;

	}

	echo ul($arr);

	$a = anchor("presets/create_new", "Create New");

	echo $a;
