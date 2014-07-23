<p><?

	$series_dvds_nav = $this->load->view('series_dvds_nav', array('series_dvds' => $series_dvds), true);

	echo heading("Tracks $series_dvds_nav", 4);

	extract($tracks);

	$tbl_heading = array(
		'ix',
		'Aspect',
		'Length',
		'Chapters',
		'Episodes',
		'',
	);

	echo form_button("add_valid", "Valid Tracks to Episodes", "onclick='window.make_episodes();'");
	echo p();

	$this->table->set_heading($tbl_heading);

	$num_episodes = 0;

	$img_add = img(array('src' => "images/icons/add.png", 'border' => 0));
	$img_delete = img("images/icons/delete.png");

	foreach($tracks as $track_id => $track_row) {

		extract($track_row);

		$color = 'black';

		$length_too_small = length_too_small($length);
		$length_close_to_average = length_close_to_average($length, $series['average_length'], 10);
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

		$a_track = anchor("tracks/index/$track_id", "Track $ix");
		$time = format_seconds($length, "m:s");
		$display_time = "<span style='color: $color'>$time</span>";
		$display_length = "<span style='color: $color' track_id='$track_id' valid='$valid_length' >".format_seconds($length)."</span>";
		$num_chapters = count($chapters[$track_id]);

		$a_new_episode = anchor("dvds/tracks/$dvd_id", $img_add, "onclick='new_episode($track_id); plus_one_html($(\"span[name=num_episodes][track_id=$track_id]\")); return false;'");

		$display_num_episodes = "<span name='num_episodes' track_id='$track_id'>";
		if($num_episodes)
			$display_num_episodes .= $num_episodes;
		$display_num_episodes .= "</span>";

		$display_add_episodes = '';

		if($length_close_to_average || $length_larger) {
			$display_add_episodes = "$a_new_episode";
			$display_add_episodes .= " &nbsp; ";
		}

		$tbl_row = array(

			$a_track,
			$aspect,
			$display_length,
			$num_chapters,
			$display_num_episodes,
			$display_add_episodes,

		);

		$this->table->add_row($tbl_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();
