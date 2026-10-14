<?php

	echo heading('Encodes', 2);

	$arr_app_anchors = array(
		anchor('encodes/app/handbrake', 'HandBrake'),
		anchor('encodes/app/ffmpeg', 'ffmpeg'),
	);
	$d_app_anchors = implode(' | ', $arr_app_anchors);

	$arr_vcodec_anchors = array(
		anchor('encodes/vcodec/avc', 'avc'),
		anchor('encodes/vcodec/hevc', 'hevc'),
	);
	$d_vcodec_anchors = implode(' | ', $arr_vcodec_anchors);

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

	echo "Apps: $d_app_anchors &nbsp; Video: $d_vcodec_anchors &nbsp; Audio: $d_audio_anchors &nbsp; Subtitles: $d_subs_anchors";

	echo "<p>";

