<?

	$header = array(
		'',
		'Title',
		'# DVDs',
		'Total Filesize',
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

	$total_filesize = 0;
	$total_num_dvds = 0;
	
	foreach($collections as $series_id => $row) {
	
		extract($row);
		
		$num_discs = 0;
		
		if($missing_metadata)
			$img_dvd = img(array('src' => "images/icons/dvd_error.png"));
		else
			$img_dvd = img(array('src' => "images/icons/dvd.png"));
		
		$a_title = anchor("series/dvds/$series_id", $title, array('class' => 'black'));

		if($sum_filesize[$series_id]) {
			$display_filesize = number_format($sum_filesize[$series_id] / 1024)." MB";
			$total_filesize += $sum_filesize[$series_id];
		} else
			$display_filesize = '';
		
		$table_row = array(
			$img_dvd,
			$a_title,
			$num_dvds[$series_id],
			$display_filesize,
		);

		$total_num_dvds += $num_dvds[$series_id];
		
		$this->table->add_row($table_row);
	
	}
	
	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	$display_total_filesize = number_format($total_filesize / 1024). " MB";

	// Display totals
	$this->table->add_row(array(
		'',
		'',
		number_format($total_num_dvds),
		$display_total_filesize,
	));

	echo $this->table->generate();
	$this->table->clear();
	
	$total = count($collections);
	
	echo "<p><b>Total Series:</b> $total</p>";
	
	$a_new_series = anchor("collections/new_series/$id", "Create New Series");
	
	echo "<p>$a_new_series</p>";
