<?php

	extract($tracks);

	$tbl_heading = array(
		'Aspect',
		'Track',
		'Length',
		'Chapters',
		'Episodes',
	);

	$this->table->set_heading($tbl_heading);

	foreach($tracks as $track_id => $track_row) {

		extract($track_row);

		$a_track = anchor("tracks/index/$track_id", "Track $track");
		$time = format_seconds($len, "m:s");

		$tbl_row = array(

			$aspect,
			$a_track,
			$time,

		);

		$this->table->add_row($tbl_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();
