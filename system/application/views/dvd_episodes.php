<p><?php

	$plex_pattern = "/\.".str_pad($series['id'], 3, 0, STR_PAD_LEFT)."\.\d*".$dvds['id']."\..*\.m(p4|kv)/";
	$plex_files = preg_grep($plex_pattern, scandir("/opt/plex/episodes"));

	$img_dvd = img(array('src' => "images/icons/dvd.png", 'class' => 'handle'));

	$tbl_heading = array(
		'',
		'Track',
		// 'ix',
		'Title',
		'Part',
		'Ch.',
		'',
		'Ssn.',
		'#',
		'No',
		'NSIX',
		'Plex',
		'Filesize',
		''
	);

	$series_dvds_nav = $this->load->view('series_dvds_nav', array('series_dvds' => $series_dvds), true);

	echo heading("Episodes $series_dvds_nav", 4);

	echo form_open("dvds/update_episodes/".$dvds['id'], "autocomplete='off' method='post'");

	$this->table->set_heading($tbl_heading);

	foreach($episodes as $episode_id => $row) {

		$img_delete = img(array('src' => "images/icons/delete.png", 'class' => 'pointer', 'onclick' => 'delete_episode('.$episode_id.', this); return false;'));

		extract($row);
	
		$display_id = $collection['id'].".".str_pad($series['id'], 3, 0, STR_PAD_LEFT).".".str_pad($dvd_id, 4, 0, STR_PAD_LEFT).".".str_pad($episode_id, 5, 0, STR_PAD_LEFT);

		$mp4_file = $display_id.".".$series['nsix'].".mp4";
		$mkv_file = $display_id.".".$series['nsix'].".mkv";
		$d_plex = '';
		$d_filesize = '';
		if(in_array($mp4_file, $plex_files)) {
			$d_plex = '++';
			$filesize = filesize("/opt/plex/episodes/$mp4_file") / (1024 * 1024);
			$d_filesize = number_format($filesize)." MB";
		}
		if(in_array($mkv_file, $plex_files)) {
			$d_plex = '++';
			$filesize = filesize("/opt/plex/episodes/$mkv_file") / (1024 * 1024);
			$d_filesize = number_format($filesize)." MB";
		}

		// Link to track
		$a_track = anchor("tracks/index/$track_id", $img_dvd);

		// Track
		$i_track_ix = form_input("episode[$episode_id][track_ix]", $track_ix, "size='2' track_id='$track_id' episode_id='$episode_id'");

		// Episode #
		// Override episode index if series is unindexed.
		/*
		if($series['indexed'] == 'f')
			$ix = null;
		$display_ix = ($ix ? $ix : "");
		$i_ix = "<input type='text' size='2' name='episode[$episode_id][ix]' value='$display_ix' ix='$ix' track_id='$track_id' episode_id='$episode_id'>\n";
		*/

		// Episode Title
		$i_title = form_input("episode[$episode_id][title]", $title, "size='30' track_id='$track_id' episode_id='$episode_id' tabindex='$track_ix'");

		// Episode Part
		$i_part = form_input("episode[$episode_id][part]", $part, "size='2' track_id='$track_id' episode_id='$episode_id'");

		// Track chapters
		$i_starting_chapter = form_input("episode[$episode_id][starting_chapter]", $starting_chapter, "size='2' track_id='$track_id' episode_id='$episode_id'");
		$i_ending_chapter = form_input("episode[$episode_id][ending_chapter]", $ending_chapter, "size='2' track_id='$track_id' episode_id='$episode_id'");

		// Episode season (override disc)
		$display_season = ($season ? $season : "");
		$i_season = form_input("episode[$episode_id][season]", $display_season, "size='2' track_id='$track_id' episode_id='$episode_id'");

		// Episode number (override all)
		$display_episode_number = ($episode_number ? $episode_number : "");
		$i_episode_number = form_input("episode[$episode_id][episode_number]", $display_episode_number, "size='2' track_id='$track_id' episode_id='$episode_id'");

		// Skip episode
		$i_skip_episode = form_checkbox("episode[$episode_id][skip]", '1', $skip ? true : false);

		$tbl_row = array(

			$a_track,
			$i_track_ix,
			//  $i_ix,
			$i_title,
			$i_part,
			$i_starting_chapter,
			$i_ending_chapter,
			$i_season,
			$i_episode_number,
			$i_skip_episode,
			$display_id,
			$d_plex,
			$d_filesize,
			$img_delete,

		);

 		$this->table->add_row($tbl_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra" id="sort"><tbody>',
		'table_close' => '</tbody></table>',
		'row_end' => "</tr>\n",
		'cell_end' => "</td>\n",
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();

	echo p().form_submit('submit', 'Update Episodes');

	/*
	if($series['indexed'] == 't') {

		echo nbs(5);
		echo form_button("reindex", "Reindex Episodes", "onclick='window.reindex(); return false;'");
		echo nbs();
		echo form_button("reindex", "Remove Indexes", "onclick='window.remove_indexes(); return false;'");

	}
	*/

	echo form_close();
