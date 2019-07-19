<?php

	echo heading($series['title']." - ".$series['nsix'], 2);

	if(isset($series_dvds)) {
		$display_season = array();
		if(strlen($series_dvds[$dvd_id]['title']))
			$display_season[] = $series_dvds[$dvd_id]['title'];
		$display_season[] = "Season: ".str_pad($series_dvds[$dvd_id]['season'], 2);
		if($series_dvds[$dvd_id]['volume'])
			$display_season[] = "Volume: ".str_pad($series_dvds[$dvd_id]['volume'], 2);
		$display_season[] = "Disc: ".str_pad($series_dvds[$dvd_id]['ix'], 2);
		if(strlen(trim($series_dvds[$dvd_id]['side'])))
			$display_season[] = "Side: ".str_pad($series_dvds[$dvd_id]['side'], 2);
		$display_season_str = implode(' | ', $display_season);
	}

 	$a_dvds = anchor("series/dvds/".$series['id'], "DVDs");
 	$a_tracks = anchor("dvds/tracks/$dvd_id", "Tracks");
 	$a_episodes = anchor("dvds/episodes/$dvd_id", "Episodes");
	$a_details = anchor("dvds/details/$dvd_id", "Disc");
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
	if(isset($series_dvds))
		echo " | $display_season_str";
	 if(strlen($preset_name))
		echo " | $preset_name";
	echo "&nbsp; $img";

