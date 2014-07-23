<?

	foreach($presets as $id => $name) {

		$a = anchor("presets/index/$id", $name);

		$arr[] = $a;

	}

	echo ul($arr);
