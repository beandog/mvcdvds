<p><?php

	echo heading("Series", 4);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	extract($series);

	$qa_files = scandir("/root/qa");

	$qa_images = preg_grep("/^.*\.$nsix\..*/", $qa_files);

	foreach($qa_images as $filename) {

		echo heading("$filename", 3);
		echo "<a href='/qa/$filename'><img src='/qa/$filename'></a>\n";

	}

	echo "</blockquote>";
