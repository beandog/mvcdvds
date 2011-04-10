<p><?

	echo heading("DVDs", 4);

	extract($series);
	
	$heading = array(
	
		'Title',
		'Ssn.',
		'Disc',
		'Side',
		'Eps.',
		'Links',
	
	);
	
	$this->table->set_heading($heading);
	
	foreach($dvds as $id => $row) {
	
		extract($row);
		
		if(is_null($longest_track))
			$needs_import = true;
		else
			$needs_import = false;
			
		if($needs_import)
			$class = 'update';
		else
			$class = 'imported';
		
		$a_dvd = anchor("dvds/episodes/$id", $title, "class='$class'");
		
		$a_tracks = anchor("dvds/tracks/$id", "Tracks");
		$a_dvd_details = anchor("dvds/details/$id", "Details");
		
		$links = "$a_tracks | $a_dvd_details";
		
		$num_episodes = count($episodes[$id]);
		
		if(!$num_episodes)
			$num_episodes = "";
		
		$display_season = "<span>$season</span>";
		$display_ix = "<span>$ix</span>";
		$display_side = "<span>$side</span>";
		
		$tbl_row = array(
			$a_dvd,
			$display_season,
			$display_ix,
			$display_side,
			$num_episodes,
			$links,
		);
		
		$this->table->add_row($tbl_row);
	
	}
	
	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);
	
	$this->table->set_template($tmpl);
	
	echo $this->table->generate();