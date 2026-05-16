<?php

	echo heading($title, 2);

	$header = array(
		'',
		'NSIX',
		'Title',
		'# DVDs',
		'# Eps.',
		'Media',
		'Prod. Year',
		'Filesize',
		'Episodes',
		'Missing Metadata',
	);

	$this->table->set_heading($header);

	$total_filesize = 0;
	$total_isos_filesize = 0;
	$total_episodes_filesize = 0;
	$total_series_episodes_filesize = 0;
	$total_preset_filesize = 0;
	$total_num_dvds = 0;
	$total_num_episodes = 0;
	$total_num_media = 0;

	$media_pattern= "/^$id\..+\.m(p4|kv)$/";
	$media_collection_files = media_episode_patterns($media_pattern, $media_episode_dirs);

	foreach($collections as $series_id => $row) {

		extract($row);

		$media_episodes = preg_grep("/^$id\.0*{$series_id}\..+\.m(p4|kv)$/", $media_collection_files);
		$num_media = count($media_episodes);

		$total_series_episodes_filesize = 0;
		foreach($media_episodes as $media_episode) {
			$episode_filesize = media_episode_filesize($media_episode, $media_episode_dirs);
			$total_series_episodes_filesize += $episode_filesize;

		}

		$total_episodes_filesize += $total_series_episodes_filesize;

		$class = 'imported';
		if(count($metadata[$series_id])) {
			$img_dvd = img(array('src' => "images/icons/dvd_error.png"));
		} else {
			$img_dvd = img(array('src' => "images/icons/dvd.png"));
		}

		$a_dvd2 = anchor("dvds/details/$id", $img_dvd);

		$d_nsix = $nsix;
		if($num_media == $num_episodes[$series_id])
			$d_nsix = "<b>$d_nsix</b>";

		$a_title = anchor("series/dvds/$series_id", $title, array('class' => $class));

		$d_num_dvds = $num_dvds[$series_id];

		$d_num_episodes = number_format($num_episodes[$series_id]);

		if($num_media)
			$d_num_media = number_format($num_media);
		else
			$d_num_media = '';

		if($num_episodes[$series_id] != $num_media) {
			$d_num_episodes = "<b>$d_num_episodes</b>";
			$d_num_media = "<b>$d_num_media</b>";
			$num_missing = $num_episodes[$series_id] - $num_media;
			$metadata[$series_id][] = "Missing $num_missing Rips";
		}

		if($sum_filesize[$series_id]) {
			$d_filesize = number_format($sum_filesize[$series_id])." MB";
			$total_filesize += $sum_filesize[$series_id];
		} else
			$d_filesize = '';

		$d_total_series_episodes_filesize = '';
		if($total_series_episodes_filesize)
			$d_total_series_episodes_filesize = "&nbsp; ". number_format($total_series_episodes_filesize / (1024 * 1024))." MB";

		$d_qa = '';
		if($qa_notes)
			$d_qa = 'Yes';

		$d_missing_metadata = implode(", ", $metadata[$series_id]);

		$d_production_year = $production_year;

		$total_num_dvds += $num_dvds[$series_id];
		$total_num_episodes += $num_episodes[$series_id];
		$total_num_media += $num_media;

		$table_row = array(
			$a_dvd2,
			$d_nsix,
			$a_title,
			$d_num_dvds,
			$d_num_episodes,
			$d_num_media,
			$d_production_year,
			$d_filesize,
			$d_total_series_episodes_filesize,
			$d_missing_metadata,
		);

		$this->table->add_row($table_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	$display_total_dvds = number_format($total_num_dvds);
	$display_total_episodes = number_format($total_num_episodes);
	$display_total_media = number_format($total_num_media);
	$display_total_filesize = number_format($total_filesize). " MB";
	$display_total_episodes_filesize = number_format($total_episodes_filesize / (1024 * 1024)). " MB";
	$display_total_preset_filesize = number_format($total_preset_filesize). " MB";

	// Display totals
	$this->table->add_row(array(
		'',
		'',
		'',
		$display_total_dvds,
		$display_total_episodes,
		$display_total_media,
		'',
		$display_total_filesize,
		$display_total_episodes_filesize,
		'',
	));

	echo $this->table->generate();
	$this->table->clear();

	$total = count($collections);

	echo "<p><b>Total Series:</b> $total</p>";

	$a_new_series = anchor("collections/new_series/$id", "Create New Series");
	if($collection['active'] == 1) {
		$a_active_series = "Active Series";
		$a_inactive_series = anchor("collections/index/$id/2", "Inactive Series");
		$a_archived_series = anchor("collections/index/$id/3", "Archived Series");
	} elseif($collection['active'] == 2) {
		$a_active_series = anchor("collections/index/$id/1", "Active Series");
		$a_inactive_series = "Inactive Series";
		$a_archived_series = anchor("collections/index/$id/3", "Archived Series");
	} elseif($collection['active'] == 3) {
		$a_active_series = anchor("collections/index/$id/1", "Active Series");
		$a_inactive_series = anchor("collections/index/$id/2", "Inactive Series");
		$a_archived_series = "Archived Series";
	}

	echo "<p>$a_new_series | $a_active_series | $a_inactive_series | $a_archived_series</p>";
