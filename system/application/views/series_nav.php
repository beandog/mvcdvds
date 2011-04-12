<?

	echo heading($series['title']);

	$a_home = anchor("/", "Home");
	$a_collection = anchor("collections/index/".$collection['id'], $collection['title']);
	$a_series = anchor("series/dvds/".$series['id'], $series['title']);
	echo heading("$a_home :: $a_collection :: $a_series", 4);

 	$a_series = anchor("series/details/".$series['id'], "Series");
 	$a_dvds = anchor("series/dvds/".$series['id'], "DVDs");
 	$a_episodes = anchor("dvds/episodes/$dvd_id", "Episodes");
 	$a_tracks = anchor("dvds/tracks/$dvd_id", "Tracks");
 	$a_details = anchor("dvds/details/$dvd_id", "Details");
 	
 	if(array_key_exists('longest_track', $dvds)) {
		if(is_null($dvds['longest_track']))
			$img = img("images/icons/dvd_error.png");
		else
			$img = img("images/icons/dvd.png");
	} else
		$img = "";

 	echo heading("$a_series | $a_dvds | $a_tracks | $a_episodes | $a_details &nbsp; $img", 4);

