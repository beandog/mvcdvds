<?php

	echo heading("Presets", 2);

	$tbl_heading = array(
		'Preset',
		'x264 preset',
		'x264 profile',
		'x264 tune',
		'video quality',
		'',
		'audio codec',
		'audio bitrate',
	);

	echo p();

	$this->table->set_heading($tbl_heading);

	foreach($presets as $id => $arr) {

		extract($arr);

		$a_preset = anchor("presets/index/$id", $name);

		if($crf) {
			$d_video = "crf";
			$d_video_quality = $crf;
		}

		if($acodec == 'copy') {
			$d_audio = "copy";
			$d_audio_quality = '';
		} else {
			$d_audio = $acodec;
			$d_audio_quality = '';
			if($acodec_bitrate)
				$d_audio_quality = "${acodec_bitrate}k";
		}

		$tbl_row = array(
			$a_preset,
			$x264_preset,
			$x264_profile,
			$x264_tune,
			$d_video,
			$d_video_quality,
			$d_audio,
			$d_audio_quality,
		);

		$this->table->add_row($tbl_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();

	echo p();

	echo anchor("presets/create_new", "Create New Preset");


