<?php

	echo form_open("presets/update/$id", array('autocomplete' => 'off'));

	echo heading("Edit Details", 4);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	$inputs = array();

	$o_format = array('mp4' => 'mp4', 'mkv' => 'mkv');
	$o_acodec = array('copy' => 'copy', 'fdk_aac' => 'fdk_aac');
	$o_x264_preset = array('medium' => 'medium', 'slow' => 'slow', 'slower' => 'slower', 'veryslow' => 'veryslow', 'placebo' => 'placebo');
	$o_x264_profile = array('high' => 'high', 'baseline' => 'baseline');
	$o_x264_tune = array('' => 'none', 'film' => 'film', 'animation' => 'animation', 'grain' => 'grain');

	$i_name = form_input('name', $name, 'size=45');
	$i_format = form_dropdown('format', $o_format, $format);
	$i_x264_profile = form_dropdown('x264_profile', $o_x264_profile, $x264_profile);
	$i_x264_tune = form_dropdown('x264_tune', $o_x264_tune, $x264_tune);
	$i_x264_preset = form_dropdown('x264_preset', $o_x264_preset, $x264_preset);
	$i_crf = form_input('crf', $crf, 'size=2');
	$i_x264opts = form_input('x264opts', $x264opts);
	$i_acodec = form_dropdown('acodec', $o_acodec, $acodec);
	$i_acodec_bitrate = form_input('acodec_bitrate', $acodec_bitrate, 'size=5');
	$i_deinterlace = form_checkbox('deinterlace', 1, $deinterlace);
	$i_decomb = form_checkbox('decomb', 1, $decomb);
	$i_detelecine = form_checkbox('detelecine', 1, $detelecine);

	$this->table->add_row(array("Name:", $i_name));
	$this->table->add_row(array("Container:", $i_format));
	$this->table->add_row(array("H.264 profile:", $i_x264_profile));
	$this->table->add_row(array("Tuning:", $i_x264_tune));
	$this->table->add_row(array("Preset:", $i_x264_preset));
	$this->table->add_row(array("CRF:", $i_crf));
	$this->table->add_row(array("x264 options:", $i_x264opts));
	$this->table->add_row(array("Audio:", "$i_acodec $i_acodec_bitrate"));
	$this->table->add_row(array("Deinterlace:", $i_deinterlace));
	$this->table->add_row(array("Decomb:", $i_decomb));
	$this->table->add_row(array("Detelecine:", $i_detelecine));

	$submit = form_submit('submit', 'Update');

	$this->table->add_row(array("", $submit));

	echo $this->table->generate();
	$this->table->clear();

	echo form_close();

	echo "</blockquote>";
