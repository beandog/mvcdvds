<p><?php

	$plex_pattern = "/\.".str_pad($series['id'], 3, 0, STR_PAD_LEFT)."\.\d*".$dvds['id']."\..*\.m(p4|kv)/";
	$plex_files = plex_episode_patterns($plex_pattern, $plex_episode_dirs);

	$img_dvd = img(array('src' => "images/icons/dvd.png", 'class' => 'handle'));

	$tbl_heading = array(
		'',
		'Track',
		'Title',
		'Part',
		'Ch.',
		'',
		'Ssn.',
		'#',
		'No',
		'NSIX',
		'Plex',
		'Created',
		'Encoder',
		'Codecs',
		'Media',
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

		$mkv_file = $display_id.".".$series['nsix'].".mkv";
		$d_plex = '';
		$d_filesize = '';
		$filesize = 0;
		$d_ctime = '';
		if(in_array($mkv_file, $plex_files)) {
			if(file_exists("/opt/plex/sd/$mkv_file"))
				$video_filename = "/plex/sd/$mkv_file";
			elseif(file_exists("/opt/plex/tv/$mkv_file"))
				$video_filename = "/plex/tv/$mkv_file";
			else
				$video_filename = '';
			$episode_filename = basename($mkv_file);
			$d_plex = "<img src='/images/icons/control_play_blue.png' onclick=\"play_episode('$video_filename', '$episode_filename');\">";
			$filesize = plex_episode_filesize($mkv_file, $plex_episode_dirs);
			$filesize = $filesize / (1024 * 1024);
			$d_ctime = date("Y-m-d", filectime("/opt/$video_filename"));
			$d_filesize = number_format($filesize)." MB";
		}

		// Encoder details
		$d_app = '';
		$d_codecs = '';
		$d_encode = '';
		if($filesize && array_key_exists($episode_id, $encodes)) {

			$arr_encode_info = $encodes[$episode_id];
			if($arr_encode_info['vcodec'] == 'avc')
				$arr_encode_info['vcodec'] = 'h264';

			$app = $arr_encode_info['application'];
			$d_app = $app;
			// pre($arr_encode_info);
			if(strstr($app, 'HandBrake') || strstr($app, 'mkvmerge')) {
				$arr = explode(' ', $app);
				$d_app = implode(' ', array($arr[0], $arr[1]));
			} elseif(strstr($app, 'Lavf')) {
				$version = str_replace('Lavf', '', $app);
				if($version == '61.7.100')
					$d_app = 'ffmpeg 7.1.1';
				elseif($version == '62.3.100')
					$d_app = 'ffmpeg 8.0.1';
				else
					$d_app = "ffmpeg lavf $version";
			}

			$arr = array($arr_encode_info['vcodec'], $arr_encode_info['acodec']);
			if($arr_encode_info['scodec'])
				$arr[] = $arr_encode_info['scodec'];
			$d_codecs = implode(' - ', $arr);

			if(!strstr($d_codecs, 'aac'))
				$d_codecs = "<b>$d_codecs</b>";

			$d_encode = $d_codecs;

		}

		$d_plex = "<center>$d_plex</center>";

		// Link to track
		$a_track = anchor("tracks/index/$track_id", $img_dvd);

		// Track
		$i_track_ix = form_input("episode[$episode_id][track_ix]", $track_ix, "size='2' track_id='$track_id' episode_id='$episode_id'");

		// Episode Title
		$tabindex = $track_ix + 1;
		$i_title = form_input("episode[$episode_id][title]", $title, "size='45' track_id='$track_id' episode_id='$episode_id' tabindex='$tabindex'");

		// Episode Part
		$i_part = form_input("episode[$episode_id][part]", $part, "size='2' track_id='$track_id' episode_id='$episode_id'");

		// Track chapters
		$i_starting_chapter = form_input("episode[$episode_id][starting_chapter]", $starting_chapter, "size='2' track_id='$track_id' episode_id='$episode_id'");
		$i_ending_chapter = form_input("episode[$episode_id][ending_chapter]", $ending_chapter, "size='2' track_id='$track_id' episode_id='$episode_id'");

		// Episode season (override disc)
		$display_season = ($season ? $season : "");
		$tabindex = $episode_id + 1;
		$i_season = form_input("episode[$episode_id][season]", $display_season, "size='2' track_id='$track_id' episode_id='$episode_id' tabindex='$tabindex'");

		// Episode number (override all)
		$display_episode_number = ($episode_number ? $episode_number : "");
		$tabindex = $episode_id + 1;
		$i_episode_number = form_input("episode[$episode_id][episode_number]", $display_episode_number, "size='2' track_id='$track_id' episode_id='$episode_id' tabindex='$tabindex'");

		// Skip episode
		$i_skip_episode = form_checkbox("episode[$episode_id][skip]", '1', $skip ? true : false);

		$d_frames = '-';

		// Episode info
		$d_episode_info = '';
		if($filesize) {
			$img_episode = img(array('src' => "images/icons/application_view_gallery.png", 'class' => 'handle'));
			$d_episode_info = "<center>".anchor("episodes/index/$episode_id", $img_episode)."</center>";
		}

		$tbl_row = array(

			$a_track,
			$i_track_ix,
			$i_title,
			$i_part,
			$i_starting_chapter,
			$i_ending_chapter,
			$i_season,
			$i_episode_number,
			$i_skip_episode,
			$display_id,
			$d_plex,
			$d_ctime,
			$d_app,
			$d_encode,
			$d_episode_info,
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
