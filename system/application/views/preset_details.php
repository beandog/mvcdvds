<?php

	echo form_open("presets/update/$id", array('autocomplete' => 'off'));

	echo heading("Edit Details", 4);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	$inputs = array();

	$o_acodec = array('copy' => 'copy', 'fdk_aac' => 'fdk_aac');
	$o_x264_preset = array('medium' => 'medium', 'slow' => 'slow', 'slower' => 'slower', 'veryslow' => 'veryslow', 'placebo' => 'placebo');
	$o_x264_tune = array('' => 'none', 'film' => 'film', 'animation' => 'animation', 'grain' => 'grain');

	$i_name = form_input('name', $name, 'size=45');
	$i_crf = form_input('crf', $crf, 'size=2');
	$i_x264opts = form_input('x264opts', $x264opts);
	$i_x264_preset = form_dropdown('x264_preset', $o_x264_preset, $x264_preset);
	$i_x264_tune = form_dropdown('x264_tune', $o_x264_tune, $x264_tune);
	$i_video_bitrate = form_input('video_bitrate', $video_bitrate, 'size=6');
	$i_acodec = form_dropdown('acodec', $o_acodec, $acodec);
	$i_acodec_bitrate = form_input('acodec_bitrate', $acodec_bitrate, 'size=5');
	$i_two_pass = form_checkbox('two_pass', 't', $two_pass == 't');

	$this->table->add_row(array("Name:", $i_name));
	$this->table->add_row(array("x264 tuning:", $i_x264_tune));
	$this->table->add_row(array("x264 preset:", $i_x264_preset));
	$this->table->add_row(array("Quality:", "Two Pass: $i_two_pass / CRF: $i_crf"));
	$this->table->add_row(array("x264 options:", $i_x264opts));
	$this->table->add_row(array("Video Bitrate:", $i_video_bitrate));
	$this->table->add_row(array("Audio:", "$i_acodec $i_acodec_bitrate"));

	$submit = form_submit('submit', 'Update');

	$this->table->add_row(array("", $submit));

	echo $this->table->generate();
	$this->table->clear();

	echo form_close();

	echo "</blockquote>";
