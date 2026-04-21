<p><?php

	echo heading($series['title']);

	$a_home = anchor("/", "Home");
	$a_collection = anchor("collections/index/".$collection['id'], $collection['title']);
	$a_series = anchor("series/dvds/".$series['id'], $series['title']);
	echo heading("$a_home :: $a_collection :: $a_series", 4);

 	$a_details = anchor("dvds/details/".$dvds['id'], "DVD Details");
 	$a_tracks = anchor("dvds/tracks/".$dvds['id'], "Disc Tracks");
 	$a_episodes = anchor("dvds/episodes/".$dvds['id'], "Disc Episodes");

 	echo heading("$a_episodes | $a_tracks | $a_details", 4);
