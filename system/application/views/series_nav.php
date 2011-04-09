<p><?

	echo heading($series['title']);

	$a_home = anchor("/", "Home");
	$a_collection = anchor("collections/index/".$collection['id'], $collection['title']);
	$a_series = anchor("series/dvds/".$series['id'], $series['title']);
	echo heading("$a_home :: $a_collection :: $a_series", 4);

 	$a_details = anchor("series/details/".$series['id'], "Details");
 	$a_dvds = anchor("series/dvds/".$series['id'], "DVDs");

 	echo heading("$a_dvds | $a_details", 4);

