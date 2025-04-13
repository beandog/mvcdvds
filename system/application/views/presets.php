<?php

	echo heading("Presets", 2);

	$tbl_heading = array(
		'Preset',
		'Series',
		// 'x264 tune',
		'CRF',
		'Video filters',
		'Audio codec',
		// 'Container',
		// 'Upscale',
	);

	echo p();

	$this->table->set_heading($tbl_heading);

	foreach($presets as $id => $arr) {

		extract($arr);

		$a_preset = anchor("presets/index/$id", $name);
		$d_preset = $a_preset;

		$d_num_series = '';
		if(array_key_exists($id, $num_series))
			$d_num_series = $num_series[$id];

		$d_video_quality = $crf;

		$d_video_filters = '';
		$arr_filters = array();

		$d_video_filters = implode(',', $arr_filters);

		if($acodec == 'copy') {
			$d_audio = "copy";
			$d_audio_quality = '';
		} else {
			$d_audio = $acodec;
			$d_audio_quality = '';
		}

		// $d_upscale = '';

		// if($fps)
		//	$d_upscale = "${fps} fps";

		$tbl_row = array(
			$d_preset,
			$d_num_series,
			// $x264_tune,
			$d_video_quality,
			$d_video_filters,
			$d_audio,
			// $d_upscale,
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


