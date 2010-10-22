<p><?

	echo heading("Discs", 4);

	extract($series);
	
	$heading = array(
	
		'D#',
		'Title',
		'Tracks',
		'Episodes',
	
	);
	
	$this->table->set_heading($heading);
	
	foreach($discs as $disc_id => $disc_row) {
	
		extract($disc_row);
		
		$a_disc = anchor("discs/index/$disc_id", $disc_title);
		
		$tbl_row = array(
			$disc,
			$a_disc,
		);
		
		$this->table->add_row($tbl_row);
	
	}
	
	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);
	
	$this->table->set_template($tmpl);
	
	echo $this->table->generate();