<?

	echo p();

	echo heading("Episodes", 3);

	$tbl_heading = array(
		'Series',
		'Episode',
		'Handbrake',
		'XML',
		'Matroska',
	);

	echo p();

	$this->table->set_heading($tbl_heading);

	$img_delete = img("images/icons/delete.png");

	$arr_x264_status = array(
		'',
		'Encoding',
		'Finished',
		'Failed',
	);

	$arr_xml_status = array(
		'',
		'In Progress',
		'Finished',
		'Failed',
	);

	$arr_mkv_status = array(
		'',
		'In Progress',
		'Finished',
		'Failed',
	);

	foreach($queue as $arr) {

		extract($arr);

		$a_series = anchor("series/dvds/$series_id", $series_title);
		$a_episode = anchor("dvds/episodes/$dvd_id", $episode_title);
		$d_x264_status = $arr_x264_status[$x264];
		$d_xml_status = $arr_xml_status[$xml];
		$d_mkv_status = $arr_mkv_status[$mkv];
		$a_delete = anchor("queue/delete/$queue_id", $img_delete);

		$tbl_row = array(
			$a_series,
			$a_episode,
			$d_x264_status,
			$d_xml_status,
			$d_mkv_status,
			$a_delete
		);

		$this->table->add_row($tbl_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();
