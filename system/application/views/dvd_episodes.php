<script type='text/javascript'>

	function play_episode(episode_url, episode_filename) {

		console.log("Play video " + episode_url);
		$('#episode_filename').text(episode_filename);
		vid = document.getElementById('video');
		// vid.load();
		// vid.play();

		if($('#episode_player').attr('src') == episode_url) {

			if(vid.paused)
				vid.play();
			else
				vid.pause();

		} else {

			$('#episode_player').attr('src', episode_url);
			vid.load();
			vid.play();
			$('#video').removeAttr('hidden');

		}

	}

</script>
<p><?php

	$plex_pattern = "/\.".str_pad($series['id'], 3, 0, STR_PAD_LEFT)."\.\d*".$dvds['id']."\..*\.m(p4|kv)/";
	$plex_files = plex_episode_patterns($plex_pattern, $plex_episode_dirs);

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
		'Encode',
		// 'Frames',
		'Plex',
		'Video',
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
			$filesize = plex_episode_filesize($mp4_file, $plex_episode_dirs);
			$filesize = $filesize / (1024 * 1024);
			$d_filesize = number_format($filesize)." MB";
		}
		if(in_array($mkv_file, $plex_files)) {
			$episode_filename = basename($mkv_file);
			$d_plex = "<img src='/images/icons/control_play_blue.png' onclick=\"play_episode('/plex/sd/$episode_filename', '$episode_filename');\">";
			$filesize = plex_episode_filesize($mkv_file, $plex_episode_dirs);
			$filesize = $filesize / (1024 * 1024);
			$d_filesize = number_format($filesize)." MB";
		}

		$d_plex = "<center>$d_plex</center>";

		// Link to track
		$a_track = anchor("tracks/index/$track_id", $img_dvd);

		// Track
		$i_track_ix = form_input("episode[$episode_id][track_ix]", $track_ix, "size='2' track_id='$track_id' episode_id='$episode_id'");

		// Episode Title
		$i_title = form_input("episode[$episode_id][title]", $title, "size='45' track_id='$track_id' episode_id='$episode_id' tabindex='$track_ix'");

		// Episode Part
		$i_part = form_input("episode[$episode_id][part]", $part, "size='2' track_id='$track_id' episode_id='$episode_id'");

		// Track chapters
		$i_starting_chapter = form_input("episode[$episode_id][starting_chapter]", $starting_chapter, "size='2' track_id='$track_id' episode_id='$episode_id'");
		$i_ending_chapter = form_input("episode[$episode_id][ending_chapter]", $ending_chapter, "size='2' track_id='$track_id' episode_id='$episode_id'");

		// Episode season (override disc)
		$display_season = ($season ? $season : "");
		$i_season = form_input("episode[$episode_id][season]", $display_season, "size='2' track_id='$track_id' episode_id='$episode_id' tabindex='$episode_id'");

		// Episode number (override all)
		$display_episode_number = ($episode_number ? $episode_number : "");
		$i_episode_number = form_input("episode[$episode_id][episode_number]", $display_episode_number, "size='2' track_id='$track_id' episode_id='$episode_id' tabindex='$episode_id'");

		// Skip episode
		$i_skip_episode = form_checkbox("episode[$episode_id][skip]", '1', $skip ? true : false);

		$d_frames = '-';
		$d_encode = 'Preset';
		$frames = $progressive + $top_field + $bottom_field;
		if($frames) {
			$per_interlaced = (($top_field + $bottom_field) / $frames) * 100;
			if($per_interlaced >= 2)
				$d_encode = 'Decomb';
			else
				$d_encode = 'Progressive';
			$d_frames = "$progressive / $top_field / $bottom_field";
			$d_encode = "<span title='$d_frames'>$d_encode</span>";
		}

		$d_avcinfo = '';
		if($avcinfo && $d_plex) {
			$d_avcinfo = $avcinfo;
		}

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
			$d_encode,
			// $d_frames,
			$d_plex,
			$d_avcinfo,
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

	echo form_close();

	echo "<p><b><span id='episode_filename'></span></b></p><video controls height='480' id='video' hidden><source src='' type='video/mp4' id='episode_player'></video>";
