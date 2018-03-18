<?php

	echo form_open("presets/update/$id", array('autocomplete' => 'off'));

	echo heading("Presets - $name", 2);

	echo heading("Edit Details", 4);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	$inputs = array();

	$o_format = array('mkv' => 'Matroska', 'mp4' => 'MPEG4');
	$o_acodec = array('fdk_aac' => 'aac', 'ac3' => 'ac3', 'copy' => 'copy');
	$o_x264_preset = array('medium' => 'medium', 'slow' => 'slow', 'slower' => 'slower', 'veryslow' => 'veryslow', 'placebo' => 'placebo');
	$o_x264_tune = array('' => 'none', 'film' => 'film', 'animation' => 'animation', 'grain' => 'grain');
	$o_fps = array('' => '', '25' => '25', '30' => '30', '60' => '60');

	$i_name = form_input('name', $name, 'size=45');
	$i_format = form_dropdown('format', $o_format, $format);
	$i_x264_tune = form_dropdown('x264_tune', $o_x264_tune, $x264_tune);
	$i_x264_preset = form_dropdown('x264_preset', $o_x264_preset, $x264_preset);
	$i_crf = form_input('crf', $crf, 'size=2');
	$i_acodec = form_dropdown('acodec', $o_acodec, $acodec);
	$i_deinterlace = form_checkbox('deinterlace', 1, $deinterlace);
	$i_decomb = form_checkbox('decomb', 1, $decomb);
	$i_detelecine = form_checkbox('detelecine', 1, $detelecine);
	$i_fps = form_dropdown('fps', $o_fps, $fps);

	$this->table->add_row(array("Name:", $i_name));
	$this->table->add_row(array("Container:", $i_format." ".$i_fps));
	$this->table->add_row(array("x264 encode:", $i_x264_tune." ".$i_x264_preset." ".$i_crf));
	$this->table->add_row(array("Audio:", "$i_acodec"));
	$this->table->add_row(array("Deinterlace:", $i_deinterlace));
	$this->table->add_row(array("Decomb:", $i_decomb));
	$this->table->add_row(array("Detelecine:", $i_detelecine));

	$submit = form_submit('submit', 'Update');

	$this->table->add_row(array("", $submit));

	echo $this->table->generate();
	$this->table->clear();

	echo form_close();

	echo "</blockquote>";
