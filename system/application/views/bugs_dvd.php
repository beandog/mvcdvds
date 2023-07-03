<?php

	// $attr = array('id' => 'series_update', 'autocomplete' => 'off');

	$nsix = $series['collection_id'].".".str_pad($series['id'], 3, 0, STR_PAD_LEFT).".".str_pad($dvd['id'], 4, 0, STR_PAD_LEFT).".".$series['nsix'].".iso";

	echo heading("DVD Series", 4);

	echo "<blockquote>";

	$a_disc = anchor("dvds/details/".$dvd['id'], $nsix);
	$a_series = anchor("series/dvds/".$series['id'], $series['title']);

	$this->table->add_row(array('Title:', $dvd['title']));
	$this->table->add_row(array('NSIX:', $a_disc));
	$this->table->add_row(array('Series:', $a_series));

	echo $this->table->generate();
	$this->table->clear();

	echo "</blockquote>";

	$attr = array('id' => 'dvd_bugs', 'autocomplete' => 'off');

	echo form_open("bugs/update_dvd/".$dvd['id']."/", $attr);

	echo heading("Disc Bugs", 4);

	echo "<blockquote>";

	foreach($bugs_details as $bug_id => $arr_details) {

		$checked = false;

		if(array_key_exists($bug_id, $bugs))
			$checked = true;

		$input_bugs = form_checkbox("dvd_bug[$bug_id]", 'accept', $checked);

		$this->table->add_row(array($input_bugs, $arr_details['name'], $arr_details['description']));

	}

	echo $this->table->generate();
	$this->table->clear();

	echo "</blockquote>";

	echo heading("Notes / Encoding Notes", 4);

	$i_dvd_notes = form_textarea(array('name' => 'notes', 'rows' => 12, 'cols' => 100), $dvd['notes']);
	$i_series_notes = form_textarea(array('name' => 'encoding_notes', 'rows' => 12, 'cols' => 100), $series['notes']);

	$this->table->add_row(array($i_dvd_notes, $i_series_notes));

	echo "<blockquote>";

	echo $this->table->generate();
	$this->table->clear();

	$submit = form_submit('submit', 'Update');

	echo "<p>$submit</p>";

	echo form_close();

	echo "</blockquote>";

