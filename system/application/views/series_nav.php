<?php

	echo heading($series['title']." - ".$series['nsix'], 2);

 	$a_series = anchor("series/details/".$series['id'], "Encoding Settings");
 	$a_dvds = anchor("series/dvds/".$series['id'], "DVDs");
 	$a_episodes = anchor("dvds/episodes/$dvd_id", "Episodes");
 	$a_tracks = anchor("dvds/tracks/$dvd_id", "Tracks");
 	$a_details = anchor("dvds/details/$dvd_id", "Season");
	$a_preset = anchor("presets/index/".$preset['id'], "Current Preset");

 	if(array_key_exists('longest_track', $dvds)) {
		if(is_null($dvds['longest_track']))
			$img = img("images/icons/dvd_error.png");
		else
			$img = img("images/icons/dvd.png");
	} else
		$img = "";

 	# echo "$a_dvds | $a_tracks | $a_episodes | $a_details | $a_series | $a_preset &nbsp; $img";
 	echo "$a_dvds | $a_tracks | $a_episodes | $a_details | $a_series &nbsp; $img";

