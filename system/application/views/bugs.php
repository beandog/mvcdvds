<?php

	$img_dvd = img(array('src' => "images/icons/dvd.png", 'class' => 'handle'));

	$header = array(
		'',
		'Disc',
		'NSIX',
		'DVD Title',
		'Series',
		'Bugs'
	);

	$this->table->set_heading($header);

	foreach($bugs as $row) {

		extract($row);

		if(!$active) {
			$d_nsix = $nsix;
		} else {
			$d_nsix = "<b>$nsix</b>";
		}

		$arr_dvd_bug_names = array();
		foreach($dvd_bugs[$dvd_id] as $arr)
			$arr_dvd_bug_names[] = $arr['name'];

		$a_disc = anchor("dvds/details/$dvd_id", $dvd_nsix_iso);
		$a_series = anchor("series/dvds/$series_id", $series_title);
		$a_bugs_dvd = anchor("bugs/dvd/$dvd_id", $dvd_title);
		$d_bug_names = implode(', ', $arr_dvd_bug_names);

		$table_row = array(
			$img_dvd,
			$d_nsix,
			$dvd_nsix_iso,
			$a_bugs_dvd,
			$a_series,
			$d_bug_names,
		);

		$this->table->add_row($table_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();

