<?php

	echo heading($series['title']." - ".$series['nsix'], 2);

 	$a_dvds = anchor("series/dvds/".$series['id'], "DVDs");
 	$a_tracks = anchor("dvds/tracks/$dvd_id", "Tracks");
 	$a_episodes = anchor("dvds/episodes/$dvd_id", "Episodes");
 	$a_details = anchor("dvds/details/$dvd_id", "Season");
 	$a_series = anchor("series/details/".$series['id'], "Encoding Settings");
	$preset_name = '';
	if(isset($preset))
		$preset_name = $preset['name'];

 	if(array_key_exists('longest_track', $dvds)) {
		if(is_null($dvds['longest_track']))
			$img = img("images/icons/dvd_error.png");
		else
			$img = img("images/icons/dvd.png");
	} else
		$img = "";

 	echo "$a_dvds | $a_tracks | $a_episodes | $a_details | $a_series";
	if(strlen($preset_name))
		echo " - $preset_name";
	echo "&nbsp; $img";

