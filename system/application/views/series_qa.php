<p><?php

	echo heading("Series", 4);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	extract($series);

	$qa_files = preg_grep("/^$collection_id\.0+?$id\..*$nsix/", scandir("/root/qa"));

	foreach($qa_files as $filename) {

		echo heading("$filename", 3);
		echo "<img src='/qa/$filename'>\n";

	}

	echo "</blockquote>";
