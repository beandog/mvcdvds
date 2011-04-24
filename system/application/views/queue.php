<p><?

	echo heading("Encoding Queue");

	$tbl_heading = array(
		'Series',
		'Episode',
	);
	
	echo p();
	
	$this->table->set_heading($tbl_heading);
	
	$img_delete = img("images/icons/delete.png");
	
	foreach($queue as $arr) {
	
		extract($arr);
		
		$a_series = anchor("series/dvds/$series_id", $series_title);
		$a_episode = anchor("dvds/episodes/$dvd_id", $episode_title);
		$a_delete = anchor("queue/delete/$episode_id", $img_delete, "onclick='return confirm(\"Delete from queue?\");'");
		
		$tbl_row = array(
			$a_series,
			$a_episode,
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
