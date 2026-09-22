<?php

	echo form_open("presets/update/$id", array('autocomplete' => 'off'));

	echo heading("Presets - $name", 2);

	echo heading("Edit Details", 3);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	$inputs = array();

	$i_name = form_input('name', $name, 'size=45');
	$i_digital = form_checkbox('digital', 'accept', boolval($digital));
	$i_ivtc = form_checkbox('ivtc', 'accept', boolval($ivtc));
	$i_crop_video = form_checkbox('crop_video', 'accept', boolval($crop_video));

	$this->table->add_row(array("Name:", $i_name));
	$this->table->add_row(array("Digital:", "$i_digital"));
	$this->table->add_row(array("IVTC:", "$i_ivtc"));
	$this->table->add_row(array("Crop video:", "$i_crop_video"));

	$arr_status = array('', '', 'Inactive', 'Archived');

	$submit = form_submit('submit', 'Update');

	$this->table->add_row(array("", $submit));

	echo $this->table->generate();
	$this->table->clear();

	echo form_close();

	echo "</blockquote>";

	echo heading("Preset Series", 3);

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_heading(array('NSIX', 'Series Title', 'Active Status'));
	$this->table->set_template($tmpl);

	foreach($series_titles as $series_id => $arr_series) {
		$d_nsix = $arr_series['nsix'];
		$d_status = "<center>".$arr_status[$arr_series['active']]."</center>";
		$a_series_title = anchor("series/details/$series_id", $arr_series['title']);
		$this->table->add_row(array($d_nsix, $a_series_title, $d_status));
	}
	echo $this->table->generate();
	$this->table->clear();
