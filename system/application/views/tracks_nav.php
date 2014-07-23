<?

	$array_keys = array_keys($tracks);
	$index = array_search($track_id, $array_keys);
	$current_track_number = $index + 1;
	$num_tracks = count($tracks);

	$current_track_number = str_pad($current_track_number, strlen($num_tracks), 0, STR_PAD_LEFT);

	$nav = array();

 	if($index > 0)
 		$nav[] = anchor("tracks/index/".$array_keys[($index - 1)], img("images/icons/control_rewind_blue.png"));
 	else
 		$nav[] = img("images/icons/control_rewind.png");
 	if($index < ($num_tracks - 1))
 		$nav[] = anchor("tracks/index/".$array_keys[($index + 1)], img("images/icons/control_fastforward_blue.png"));
 	else
 		$nav[] = img("images/icons/control_fastforward.png");

 	echo "[Track $current_track_number/$num_tracks] ".implode(nbs(2), $nav);
