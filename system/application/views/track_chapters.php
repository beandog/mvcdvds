<p><?

	$tracks_nav = $this->load->view('tracks_nav', array('tracks' => $tracks, 'track_id' => $track_id), true);

	echo heading("Chapters $tracks_nav", 4);
	
	echo form_button("add_valid", "Valid Chapters to Episodes", "onclick='window.make_chapter_episodes();'");
	echo p();

	$tbl_heading = array(
		'ix',
		'Length',
		'Episodes',
	);
	
	
	$this->table->set_heading($tbl_heading);
	
	$num_episodes = 0;
	
	$img_add = img(array('src' => "images/icons/add.png", 'border' => 0));
	$img_delete = img("images/icons/delete.png");
	
	foreach($chapters as $chapter_id => $chapter_row) {
	
		extract($chapter_row);
		
		$color = 'black';
		
		$length_too_small = length_too_small($length);
		$length_close_to_average = length_close_to_average($length, $series['average_length'], 25);
		$length_larger = intval($length > ($series['average_length'] * 60));
		
		$valid_length = "0";
		
		if($length_too_small)
			$color = 'gray';
		elseif($length_close_to_average) {
			$color = 'green';
			$valid_length = "1";
		} elseif($length_larger)
			$color = '663300';
		else
			$color = '5171ff';
		
		$display_ix = "Chapter $ix";
		$time = format_seconds($length, "m:s");
		$display_time = "<span style='color: $color'>$time</span>";
		$display_length = "<span style='color: $color' track_id='$track_id' ix='$ix' valid='$valid_length'>".format_seconds($length)."</span>";
		
		$display_num_episodes = "<span></span>";
		
		$a_new_episode = anchor("dvds/tracks/$dvd_id", $img_add, "onclick='new_chapter_episode($track_id, $ix); plus_one_html($(\"span[name=num_episodes][track_id=$track_id][ix=$ix]\")); return false;'");
		
		if($length_close_to_average || $length_larger) {
			$display_num_episodes = "$a_new_episode";
			$display_num_episodes .= " &nbsp; ";
			$display_num_episodes .= "<span name='num_episodes' track_id='$track_id' ix='$ix'></span>";
		}
		
		$tbl_row = array(
		
			$display_ix,
			$display_length,
			$display_num_episodes
		
		);
		
		$this->table->add_row($tbl_row);
		
	}
	
	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);
	
	$this->table->set_template($tmpl);
	
	echo $this->table->generate();
	$this->table->clear();