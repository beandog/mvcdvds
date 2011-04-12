<p><?

	echo heading("DVDs", 4);
	
	$heading = array(
	
		'',
		'Title',
		'Ssn.',
		'Vol.',
		'Disc',
		'Side',
		'Eps.',
	
	);
	
	$this->table->set_heading($heading);
	
	foreach($dvds as $id => $row) {
	
		extract($row);
		
		if(is_null($longest_track)) {
			$needs_import = true;
			$img_dvd = img(array('src' => "images/icons/dvd_error.png"));
		} else {
			$needs_import = false;
			$img_dvd = img(array('src' => "images/icons/dvd.png"));
		}
			
		if($needs_import)
			$class = 'update';
		else
			$class = 'imported';
		
		$a_dvd = anchor("dvds/episodes/$id", $title, "class='$class'");
		
		$num_episodes = count($episodes[$id]);
		
		if(!$num_episodes)
			$num_episodes = "";
		
		
		$a_dvd2 = anchor("dvds/details/$id", $img_dvd);
		$display_season = "<span>$season</span>";
		$display_volume = "<span>$volume</span>";
		$display_ix = "<span>$ix</span>";
		$display_side = "<span>$side</span>";
		$display_num_episodes = "<span>$num_episodes</span>";
		
		$tbl_row = array(
			$a_dvd2,
			$a_dvd,
			$display_season,
			$display_volume,
			$display_ix,
			$display_side,
			$display_num_episodes,
		);
		
		$this->table->add_row($tbl_row);
	
	}
	
	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);
	
	$this->table->set_template($tmpl);
	
	echo $this->table->generate();
	$this->table->clear();