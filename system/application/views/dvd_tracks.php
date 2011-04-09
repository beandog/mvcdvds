<p><?

	extract($tracks);
	
	$tbl_heading = array(
		'Aspect',
		'Track',
		'Length',
// 		'Seconds',
		'Chapters',
		'Episodes',
	);
	
	$this->table->set_heading($tbl_heading);
	
	$num_episodes = 0;
	
	$img_add = img(array('src' => "images/icons/add.png", 'border' => 0));
	$img_delete = img("images/icons/delete.png");
	
	foreach($tracks as $track_id => $track_row) {
	
		extract($track_row);
		
		$color = 'black';
		
		$length_too_small = length_too_small($length);
		$length_close_to_average = length_close_to_average($length, $series['average_length'], 10);
		
		if($length_too_small)
			$color = 'gray';
		elseif($length_close_to_average)
			$color = 'green';
		else
			$color = '5171ff';
		
		$a_track = anchor("tracks/index/$track_id", "Track $ix");
		$time = format_seconds($length, "m:s");
		$display_time = "<span style='color: $color'>$time</span>";
		$display_length = "<span style='color: $color'>".format_seconds($length, 'lsdvd')."</span>";
		$num_chapters = count($chapters[$track_id]);
		
		$display_num_episodes = "<span></span>";
		
		$a_new_episode = anchor("dvds/tracks/$dvd_id", $img_add, "onclick='new_episode($track_id); return false;'");
		
		if($length_close_to_average) {
			$display_num_episodes = "<span name='num_episodes' track_id='$track_id'>$num_episodes</span> &nbsp; $a_new_episode &nbsp; $img_delete";
		}
		
		$tbl_row = array(
		
			$aspect,
			$a_track,
// 			$display_time,
			$display_length,
			$num_chapters,
			$display_num_episodes
		
		);
		
		$this->table->add_row($tbl_row);
		
	}
	
	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);
	
	$this->table->set_template($tmpl);
	
	echo $this->table->generate();