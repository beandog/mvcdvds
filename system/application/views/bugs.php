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
			continue;
		}

		$a_disc = anchor("dvds/details/$dvd_id", $dvd_nsix_iso);
		$a_series = anchor("series/dvds/$series_id", $series_title);
		$a_bugs_dvd = anchor("bugs/dvd/$dvd_id", $dvd_title);

		$table_row = array(
			$img_dvd,
			$a_disc,
			$nsix,
			$a_bugs_dvd,
			$a_series,
			$description,
		);

		$this->table->add_row($table_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();

