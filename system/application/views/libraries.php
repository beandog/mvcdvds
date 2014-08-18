<?

	echo heading("Libraries", 2);

	$tbl_heading = array(
		'Library',
	);

	echo p();

	$this->table->set_heading($tbl_heading);

	foreach($libraries as $id => $name) {

		$a_library = anchor("collections/index/$id/library", $name);

		$tbl_row = array(
			$a_library,
		);

		$this->table->add_row($tbl_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();



