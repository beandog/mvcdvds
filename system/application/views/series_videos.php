<p><?php

	echo heading("Series", 4);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	extract($series);

	$qa_files = scandir("/opt/plex/sd");
	$qa_files = array_merge($qa_files, scandir("/opt/plex/hd"));

	$series_id = str_pad($id, 3, 0, STR_PAD_LEFT);

	$qa_videos = preg_grep("/^$collection_id\.$series_id\..*\.(mp4|webm|mkv)/", $qa_files);

	foreach($qa_videos as $filename) {

		$video_type = pathinfo($filename, PATHINFO_EXTENSION);

		if($video_type == 'mkv')
			$video_type = 'mp4';

		echo "<b>$filename</b><p>";
		echo "<p><video src='/plex/sd/$filename' type='video/$video_type' controls></video></p>";

	}

	$qa_files = scandir("/root/qa");

	$qa_images = preg_grep("/^.*\.$nsix\..*/", $qa_files);

	foreach($qa_images as $filename) {

		echo heading("$filename", 3);
		echo "<a href='/qa/$filename'><img src='/qa/$filename'></a>\n";

	}

	echo "</blockquote>";
