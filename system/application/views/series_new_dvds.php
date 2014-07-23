<p><?

	echo heading("Add New DVDs to Series", 4);

	foreach($new_dvds as $id => $row) {

		extract($row);

		$a_dvd = anchor("series/new_dvd/series_id/$series_id/dvd_id/$id", $title);

		$tbl_row = array(
			$a_dvd,
		);

		$this->table->add_row($tbl_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();
