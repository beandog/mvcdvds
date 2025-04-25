<?php

	$play_filename = str_replace('/opt', '', $filename);
	$episode_filename = basename($filename);
	$episode_mtime = filectime($filename);
	$d_mtime = date("Y-m-d", filectime($filename));

	$d_play = "<img src='/images/icons/control_play_blue.png' onclick=\"play_episode('$play_filename', '$episode_filename');\">";

	echo heading($episode['title']." ".$d_play, 3);
	echo heading($episode_filename, 4);
	echo "<video controls height='480' id='video' hidden><source src='' type='video/mp4' id='episode_player'></video>";
	echo "<blockquote>\n";
	echo "<pre style='font-size: 16px;'>Last modified: $d_mtime</pre>";
	echo "<pre style='font-size: 16px;'>$mediainfo</pre>";
	echo "</blockquote>\n";
