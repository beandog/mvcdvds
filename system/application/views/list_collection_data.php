<?

	$header = array(
		'Title',
// 		'# Discs',
// 		'# Seasons',
// 		'# Volumes',
// 		'# Episodes',
// 		'Complete Series',
// 		'Archive',
// 		'# Ripped',
// 		'Avg. Size',
// 		'Est. Total'
	);

	$this->table->set_heading($header);
	
	foreach($collections as $series_id => $row) {
	
// 		pre($row);
		
		extract($row);
		
		$num_discs = 0;
		
		$a_title = anchor("series/index/$series_id", $title, array('class' => 'black'));
		
		$table_row = array(
			$a_title,
		);
		
		$this->table->add_row($table_row);
	
	}
	
	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	
	$total = count($collections);
	
	echo "<p><b>Total Series:</b> $total</p>";