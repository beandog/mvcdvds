<?php

	echo heading($title, 2);

	$header = array(
		'',
		'Title',
		'# DVDs',
		'Total Filesize',
		'Preset',
		'Preset Filesize',
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

	foreach($collections as $series_id => $row) {

		extract($row);

		$num_discs = 0;

		if(count($metadata[$series_id])) {
			$class = 'update';
			$img_dvd = img(array('src' => "images/icons/dvd_error.png"));
		} else {
			$class = 'imported';
			$img_dvd = img(array('src' => "images/icons/dvd.png"));
		}

		$a_dvd2 = anchor("dvds/details/$id", $img_dvd);
		$a_title = anchor("series/dvds/$series_id", $title, array('class' => $class));

		if($sum_filesize[$series_id]) {
			$display_filesize = number_format($sum_filesize[$series_id])." MB";
			$total_filesize += $sum_filesize[$series_id];
		} else
			$display_filesize = '';

		$d_preset = anchor("series/details/$series_id", $presets[$series_presets[$series_id]]['name']);

		$d_preset_filesize = "&nbsp; ".number_format($series_numbers[$series_id]['megabytes'])." MB";

		$total_preset_filesize += $series_numbers[$series_id]['megabytes'];

		$d_missing_metadata = implode(", ", $metadata[$series_id]);

		$table_row = array(
			$a_dvd2,
			$a_title,
			$num_dvds[$series_id],
			$display_filesize,
			$d_preset,
			$d_preset_filesize,
			$d_missing_metadata,
		);

		$total_num_dvds += $num_dvds[$series_id];

		$this->table->add_row($table_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	$display_total_filesize = number_format($total_filesize). " MB";
	$display_total_preset_filesize = number_format($total_preset_filesize). " MB";

	// Display totals
	$this->table->add_row(array(
		'',
		'',
		number_format($total_num_dvds),
		$display_total_filesize,
		'',
		$display_total_preset_filesize,
		'',
	));

	echo $this->table->generate();
	$this->table->clear();

	$total = count($collections);

	echo "<p><b>Total Series:</b> $total</p>";

	if($type == "collections") {

		$a_new_series = anchor("collections/new_series/$id", "Create New Series");

		echo "<p>$a_new_series</p>";

	}
