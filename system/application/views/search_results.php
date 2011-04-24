<?

	echo heading($title, 2);

	$header = array(
		'',
		'Title',
	);

	$this->table->set_heading($header);
	
	foreach($collections as $series_id => $row) {
	
// 		pre($row);
		
		extract($row);
		
		$num_discs = 0;
		
		if($missing_index)
			$img_dvd = img(array('src' => "images/icons/dvd_error.png"));
		else
			$img_dvd = img(array('src' => "images/icons/dvd.png"));
		
		$a_title = anchor("series/dvds/$series_id", $title, array('class' => 'black'));
		
		$table_row = array(
			$img_dvd,
			$a_title,
		);
		
		$this->table->add_row($table_row);
	
	}
	
	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();
	
	$total = count($collections);
	
	echo "<p><b>Total Series:</b> $total</p>";
	
	$a_new_series = anchor("collections/new_series/$id", "Create New Series");
	
	echo "<p>$a_new_series</p>";