<?php

	echo heading('Encodes', 2);

	$arr_app_anchors = array(
		anchor('encodes/app/handbrake', 'HandBrake'),
		anchor('encodes/app/ffmpeg', 'ffmpeg'),
	);
	$d_app_anchors = implode(' | ', $arr_app_anchors);

	$arr_preset_anchors = array(
		anchor('encodes/preset/medium', 'medium'),
		anchor('encodes/preset/slow', 'slow'),
		anchor('encodes/preset/none', 'none'),
	);
	$d_preset_anchors = implode(' | ', $arr_preset_anchors);

	$arr_audio_anchors = array(
		anchor('encodes/audio/ac3', 'ac3'),
		anchor('encodes/audio/dts', 'dts'),
		anchor('encodes/audio/aac', 'aac'),
	);
	$d_audio_anchors = implode(' | ', $arr_audio_anchors);

	$arr_subs_anchors = array(
		anchor('encodes/subs/vobsub', 'vobsub'),
		anchor('encodes/subs/cc', 'cc'),
	);
	$d_subs_anchors = implode(' | ', $arr_subs_anchors);

	echo "Apps: $d_app_anchors &nbsp; Presets: $d_preset_anchors &nbsp; Audio: $d_audio_anchors &nbsp; Subtitles: $d_subs_anchors";

	echo "<p>";

