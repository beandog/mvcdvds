<?php

	echo heading($series['title']." - ".$series['nsix'], 2);

 	$a_series = anchor("series/details/".$series['id'], "Encoding Settings");
 	$a_dvds = anchor("series/dvds/".$series['id'], "DVDs");
 	$a_episodes = anchor("dvds/episodes/$dvd_id", "Episodes");
 	$a_tracks = anchor("dvds/tracks/$dvd_id", "Tracks");
 	$a_details = anchor("dvds/details/$dvd_id", "Season");
	$preset_name = $preset['name'];
	//  $a_preset = anchor("presets/index/".$preset['id'], $preset_name);

 	if(array_key_exists('longest_track', $dvds)) {
		if(is_null($dvds['longest_track']))
			$img = img("images/icons/dvd_error.png");
		else
			$img = img("images/icons/dvd.png");
	} else
		$img = "";

 	echo "$a_dvds | $a_tracks | $a_episodes | $a_details | $a_series - $preset_name&nbsp; $img";

