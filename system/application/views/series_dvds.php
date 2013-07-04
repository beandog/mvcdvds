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
		'Filesize',
	
	);
	
	$this->table->set_heading($heading);

	$arr_seasons = array();
	$arr_volumes = array();
	$total_seasons = null;
	$total_volumes = null;
	$total_discs = 0;
	$total_episodes = 0;
	$total_filesize = 0;
	
	foreach($dvds as $id => $row) {

		extract($row);

		$total_discs++;
		if($filesize)
			$total_filesize += $filesize;
		
		$num_episodes = count($episodes[$id]);

		if(intval($season)) {
			$arr_seasons[] = $season;
			$arr_seasons = array_unique($arr_seasons);
			$total_seasons = count($arr_seasons);
		}

		if(intval($volume)) {
			$arr_volumes[] = $volume;
			$arr_volumes = array_unique($arr_volumes);
			$total_volumes = count($arr_volumes);
		}

		if(intval($num_episodes))
			$total_episodes += $num_episodes;
		
		if(!$num_episodes)
			$num_episodes = "";
		
		if(is_null($longest_track) || is_null($filesize)) {
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
		
		// If there are no episodes, go straight to the
		// tracks page to add some.
		if($num_episodes)
			$a_dvd = anchor("dvds/episodes/$id", $title, "class='$class'");
		else
			$a_dvd = anchor("dvds/tracks/$id", $title, "class='$class'");
		
		$display_season = ($season ? $season : "");
		$display_volume = ($volume ? $volume : "");
		$display_ix = ($ix ? $ix : "");
		$display_filesize = number_format($filesize / 1024)." MB";
		
		$a_dvd2 = anchor("dvds/details/$id", $img_dvd);
		$display_season = "<span>$display_season</span>";
		$display_volume = "<span>$display_volume</span>";
		$display_ix = "<span>$display_ix</span>";
		$display_side = "<span>$side</span>";
		$display_num_episodes = "<span>$num_episodes</span>";
		$display_filesize = "<span>$display_filesize</span>";
		
		$tbl_row = array(
			$a_dvd2,
			$a_dvd,
			$display_season,
			$display_volume,
			$display_ix,
			$display_side,
			$display_num_episodes,
			$display_filesize,
		);
		
		$this->table->add_row($tbl_row);
	
	}

	// Add totals
	$totals_row = array(
		'',
		"<b>Totals</b>",
		"<b>$total_seasons</b>",
		"<b>$total_volumes</b>",
		"<b>$total_discs</b>",
		'',
		"<b>$total_episodes</b>",
		"<b>".number_format($total_filesize / 1024). " MB</b>",
	);

	$this->table->add_row($totals_row);
	
	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);
	
	$this->table->set_template($tmpl);
	
	echo $this->table->generate();
	$this->table->clear();
