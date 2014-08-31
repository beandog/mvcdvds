<?

	echo p();

	$tbl_heading = array(
		'Series Title',
		'Episodes',
		'',
	);

	echo p();

	$this->table->set_heading($tbl_heading);

	$img_delete = img("images/icons/delete.png");

	foreach($series as $arr) {

		extract($arr);

		$a_series = anchor("series/dvds/$series_id", $series_title);
		$a_delete = anchor("queue/delete_series/$series_id", $img_delete);

		$tbl_row = array(
			$a_series,
			$num_episodes,
			$a_delete,
		);

		$this->table->add_row($tbl_row);

	}

	$this->table->add_row('', $total_episodes, '');

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();
