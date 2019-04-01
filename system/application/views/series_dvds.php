<p><?php

	echo heading("DVDs", 4);

	$heading = array(

		'',
		'',
		'Title',
		'',
		'Ssn.',
		'Vol.',
		'Disc',
		'Side',
		'Tracks',
		'Eps.',
		'Plex',
		'Filesize',
		'Episodes',
		'Metadata',

	);

	$this->table->set_heading($heading);

	$arr_seasons = array();
	$arr_volumes = array();
	$total_seasons = null;
	$total_volumes = null;
	$total_discs = 0;
	$total_tracks = 0;
	$total_episodes = 0;
	$total_plex_episodes = 0;
	$total_plex_mkv_episodes = 0;
	$total_filesize = 0;
	$total_episode_filesize = 0;
	$total_dvds_episode_filesize = 0;

	$plex_pattern = "/\.".str_pad($series['id'], 3, 0, STR_PAD_LEFT)."\./";

	$plex_files = plex_episode_patterns($plex_pattern, $plex_episode_dirs);

	foreach($dvds as $id => $row) {

		extract($row);

		$total_discs++;
		if($filesize)
			$total_filesize += $filesize;

		$num_episodes = count($episodes[$id]);

		$plex_episodes = preg_grep("/\.".str_pad($id, 4, 0, STR_PAD_LEFT)."\./", $plex_files);
		$num_plex_episodes = count($plex_episodes);

		$plex_mp4_episodes = preg_grep("/\.".str_pad($id, 4, 0, STR_PAD_LEFT)."\..+\.mp4/", $plex_files);
		$num_plex_mp4_episodes = count($plex_mp4_episodes);

		$plex_mkv_episodes = preg_grep("/\.".str_pad($id, 4, 0, STR_PAD_LEFT)."\..+\.mkv/", $plex_files);
		$num_plex_mkv_episodes = count($plex_mkv_episodes);

		$episode_filesize = 0;
		$total_episode_filesize = 0;
		$d_total_episode_filesize = '';
		foreach($plex_episodes as $plex_episode) {
			$episode_filesize = plex_episode_filesize($plex_episode, $plex_episode_dirs);
			$episode_filesize = $episode_filesize / (1024 *1024);
			$total_episode_filesize += $episode_filesize;
			$total_dvds_episode_filesize += $episode_filesize;
		}
		if($total_episode_filesize)
			$d_total_episode_filesize = number_format($total_episode_filesize)." MB";

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

		if(intval($num_tracks))
			$total_tracks += $num_tracks;

		if(intval($num_episodes))
			$total_episodes += $num_episodes;

		if(!$num_episodes)
			$num_episodes = "";

		if(intval($num_plex_episodes))
			$total_plex_episodes += $num_plex_episodes;

		if(count($metadata[$id])) {
			$class = 'update';
			$img_dvd = img(array('src' => "images/icons/dvd_error.png"));
		} else {
			$class = 'imported';
			$img_dvd = img(array('src' => "images/icons/dvd.png"));
		}

		// If there are no episodes, go straight to the
		// tracks page to add some.
		if($num_episodes)
			$a_dvd = anchor("dvds/episodes/$id", $title, "class='$class'");
		else
			$a_dvd = anchor("dvds/tracks/$id", $title, "class='$class'");

		$display_id = $collection['id'].".".str_pad($series['id'], 3, 0, STR_PAD_LEFT).".".str_pad($id, 4, 0, STR_PAD_LEFT);
		$display_season = ($season ? $season : "");
		$display_volume = ($volume ? $volume : "");
		$display_ix = ($ix ? $ix : "");
		$display_filesize = number_format($filesize)." MB";
		$display_package_title = '';

		$a_dvd2 = anchor("dvds/details/$id", $img_dvd);
		$display_id = "<span>$display_id</span>";
		if(strlen($package_title))
			$display_package_title = anchor("dvds/details/$id", $package_title, "class='$class'");
		$display_season = "<span>$display_season</span>";
		$display_volume = "<span>$display_volume</span>";
		$display_ix = "<span>$display_ix</span>";
		$display_side = "<span>$side</span>";
		$display_num_tracks = "<span>$num_tracks</span>";
		$display_num_episodes = "<span>$num_episodes</span>";
		$display_num_plex_episodes = "<span>".($num_plex_episodes ? $num_plex_episodes : '')."</span>";
		$display_num_plex_mkv_episodes = "<span>".($num_plex_mkv_episodes ? $num_plex_mkv_episodes : '')."</span>";
		$display_filesize = "<span>$display_filesize</span>";
		$d_missing_metadata = "<span>".implode(", ", $metadata[$id])."</span>";

		$tbl_row = array(
			$a_dvd2,
			$display_id,
			$a_dvd,
			$display_package_title,
			$display_season,
			$display_volume,
			$display_ix,
			$display_side,
			$display_num_tracks,
			$display_num_episodes,
			$display_num_plex_episodes,
			$display_filesize,
			$d_total_episode_filesize,
			$d_missing_metadata,
		);

		$this->table->add_row($tbl_row);

	}

	// Add totals

	$d_total_dvds_episode_filesize = '';
	if($total_dvds_episode_filesize)
		$d_total_dvds_episode_filesize = number_format($total_dvds_episode_filesize)." MB";

	$totals_row = array(
		'',
		'',
		"<b>Totals</b>",
		'',
		"<b>$total_seasons</b>",
		"<b>$total_volumes</b>",
		"<b>$total_discs</b>",
		'',
		"<b>$total_tracks</b>",
		"<b>$total_episodes</b>",
		"<b>$total_plex_episodes</b>",
		"<b>".number_format($total_filesize). " MB</b>",
		"<b>$d_total_dvds_episode_filesize</b>",
		'',
	);

	$this->table->add_row($totals_row);

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();
