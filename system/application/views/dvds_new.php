<p><?

	echo heading("New DVDs", 1);

	
	foreach($dvds as $id => $row) {
	
		extract($row);
		
		$a_dvd = anchor("dvds/new_dvd/$id", $title);
		
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