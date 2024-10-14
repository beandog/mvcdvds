<?php

	echo form_open("presets/update/$id", array('autocomplete' => 'off'));

	echo heading("Presets - $name", 2);

	echo heading("Edit Details", 3);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	$inputs = array();

	$o_vcodec = array('x264' => 'avc', 'x265' => 'hevc');
	$o_acodec = array('copy' => 'copy', 'flac' => 'flac');
	$o_x264_preset = array('fast' => 'fast', 'medium' => 'medium', 'slow' => 'slow');
	$o_x264_tune = array('' => 'none', 'film' => 'film', 'animation' => 'animation', 'grain' => 'grain');
	// $o_fps = array('' => '', '23.976' => '23.97', '24' => '24', '25' => '25', '29.97' => '29.97', '30' => '30', '60' => '60');

	$i_name = form_input('name', $name, 'size=45');
	$i_x264_tune = form_dropdown('x264_tune', $o_x264_tune, $x264_tune);
	$i_x264_preset = form_dropdown('x264_preset', $o_x264_preset, $x264_preset);
	$i_crf = form_input('crf', $crf, 'size=2');
	$i_vcodec = form_dropdown('vcodec', $o_vcodec, $vcodec);
	$i_acodec = form_dropdown('acodec', $o_acodec, $acodec);
	$i_deinterlace = form_checkbox('deinterlace', 1, $deinterlace);
	$i_decomb = form_checkbox('decomb', 1, $decomb);
	$i_detelecine = form_checkbox('detelecine', 1, $detelecine);
	// $i_fps = form_dropdown('fps', $o_fps, $fps);

	$this->table->add_row(array("Name:", $i_name));
	$this->table->add_row(array("Encoder:", $i_x264_tune." ".$i_x264_preset." ".$i_crf));
	$this->table->add_row(array("Video:", "$i_vcodec"));
	$this->table->add_row(array("Audio:", "$i_acodec"));
	// $this->table->add_row(array("Deinterlace:", $i_deinterlace));
	$this->table->add_row(array("Decomb:", $i_decomb));
	$this->table->add_row(array("Detelecine:", $i_detelecine));

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

	$this->table->set_heading(array('NSIX', 'Series Title'));
	$this->table->set_template($tmpl);

	foreach($series_titles as $series_id => $arr_series) {

		$d_nsix = $arr_series['nsix'];
		$a_series_title = anchor("series/details/$series_id", $arr_series['title']);
		$this->table->add_row(array($d_nsix, $a_series_title));
	}
	echo $this->table->generate();
	$this->table->clear();
