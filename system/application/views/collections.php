<?php

	echo heading($title, 2);

	$header = array(
		'',
		'NSIX',
		'Title',
		'# DVDs',
		'# Eps.',
		'Plex',
//		'Total Filesize',
		'Preset',
		'Prod. Year',
//		'Preset Filesize',
		'QA',
		'Missing Metadata',
// 		'# Discs',
// 		'# Seasons',
// 		'# Volumes',
// 		'# Episodes',
// 		'Complete Series',
// 		'Archive',
// 		'# Ripped',
// 		'Avg. Size',
// 		'Est. Total'
	);

	$this->table->set_heading($header);

	$total_filesize = 0;
	$total_preset_filesize = 0;
	$total_num_dvds = 0;
	$total_num_episodes = 0;
	$total_num_plex = 0;

	$plex_collection_files = preg_grep("/^$id\..+\.mp4$/", scandir("/opt/plex/episodes"));

	foreach($collections as $series_id => $row) {

		extract($row);

		$num_plex = count(preg_grep("/^$id\.0*${series_id}\..+\.mp4$/", $plex_collection_files));

		if(count($metadata[$series_id])) {
			$class = 'update';
			$img_dvd = img(array('src' => "images/icons/dvd_error.png"));
		} else {
			$class = 'imported';
			$img_dvd = img(array('src' => "images/icons/dvd.png"));
		}

		$a_dvd2 = anchor("dvds/details/$id", $img_dvd);

		$d_nsix = $nsix;
		if($num_plex == $num_episodes[$series_id])
			$d_nsix = "<b>$d_nsix</b>";

		$a_title = anchor("series/dvds/$series_id", $title, array('class' => $class));

		$d_num_dvds = $num_dvds[$series_id];

		$d_num_episodes = $num_episodes[$series_id];

		$d_num_plex = number_format($num_plex);

		if($sum_filesize[$series_id]) {
			$d_filesize = number_format($sum_filesize[$series_id])." MB";
			$total_filesize += $sum_filesize[$series_id];
		} else
			$d_filesize = '';

		$d_preset = anchor("series/details/$series_id", $presets[$series_presets[$series_id]]['name']);

		$d_preset_filesize = "&nbsp; ".number_format($series_numbers[$series_id]['megabytes'])." MB";

		$d_qa = '';
		if($qa_notes)
			$d_qa = 'Yes';

		$d_missing_metadata = implode(", ", $metadata[$series_id]);

		$d_production_year = $production_year;

		$total_num_dvds += $num_dvds[$series_id];
		$total_num_episodes += $num_episodes[$series_id];
		$total_num_plex += $num_plex;
		$total_preset_filesize += $series_numbers[$series_id]['megabytes'];

		$table_row = array(
			$a_dvd2,
			$d_nsix,
			$a_title,
			$d_num_dvds,
			$d_num_episodes,
			$d_num_plex,
			// $d_filesize,
			$d_preset,
			$d_production_year,
			$d_qa,
			// $d_preset_filesize,
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
	$display_total_plex = number_format($total_num_plex);
	$display_total_filesize = number_format($total_filesize). " MB";
	$display_total_preset_filesize = number_format($total_preset_filesize). " MB";

	// Display totals
	$this->table->add_row(array(
		'',
		'',
		'',
		$display_total_dvds,
		$display_total_episodes,
		$display_total_plex,
		// $display_total_filesize,
		'',
		'',
		'',
		// $display_total_preset_filesize,
		'',
	));

	echo $this->table->generate();
	$this->table->clear();

	$total = count($collections);

	echo "<p><b>Total Series:</b> $total</p>";

	$a_new_series = anchor("collections/new_series/$id", "Create New Series");

	echo "<p>$a_new_series</p>";
