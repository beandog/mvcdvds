<p><?

	echo heading("Audio Tracks", 4);

	$tbl_heading = array(
		'ix',
		'Language',
		'Format',
		'Ch.',
		'Stream',
	);
	
	$this->table->set_heading($tbl_heading);
	
	$num_episodes = 0;
	
	$img_add = img(array('src' => "images/icons/add.png", 'border' => 0));
	$img_delete = img("images/icons/delete.png");
	
	foreach($audio as $audio_id => $audio_row) {
	
		extract($audio_row);
		
		$color = 'black';
		
		$display_ix = "Track $ix";
		$display_language = "$language ($langcode)";
		
		$tbl_row = array(
		
			$display_ix,
			$display_language,
			$format,
			$channels,
			$streamid,
		
		);
		
		$this->table->add_row($tbl_row);
		
	}
	
	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);
	
	$this->table->set_template($tmpl);
	
	echo $this->table->generate();
	$this->table->clear();