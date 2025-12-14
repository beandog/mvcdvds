<?php

	echo form_open("presets/update/$id", array('autocomplete' => 'off'));

	echo heading("Presets - $name", 2);

	echo heading("Edit Details", 3);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	$inputs = array();

	$o_vcodec = array('h264_hwenc' => 'avc hwenc', 'x264' => 'avc');
	$o_denoise = array('' => '', 'ultralight' => 'ultralight', 'light' => 'light', 'medium' => 'medium', 'strong' => 'strong');
	$o_sharpen = array('' => '', 'light' => 'light', 'medium' => 'medium', 'strong' => 'strong', 'stronger' => 'stronger', 'verystrong' => 'verystrong');
	$o_sharpen_tune = array('' => '', 'animation' => 'animation', 'film' => 'film');
	$o_acodec = array('copy' => 'copy', 'aac' => 'aac');
	$o_x264_tune = array('' => '', 'film' => 'film', 'animation' => 'animation');
	$o_fps = array('' => '', '29.97' => '29.97', '59.94' => '59.94');

	$i_name = form_input('name', $name, 'size=45');
	$i_x264_tune = form_dropdown('x264_tune', $o_x264_tune, $x264_tune);
	$i_crf = form_input('crf', $crf, 'size=2');
	$i_cq = form_input('cq', $cq, 'size=2');
	$i_qmin = form_input('qmin', $qmin, 'size=2');
	$i_qmax = form_input('qmax', $qmax, 'size=2');
	$i_fps = form_dropdown('fps', $o_fps, $fps);
	$i_vcodec = form_dropdown('vcodec', $o_vcodec, $vcodec);
	$i_denoise = form_dropdown('denoise', $o_denoise, $denoise);
	$i_sharpen = form_dropdown('sharpen', $o_sharpen, $sharpen);
	$i_sharpen_tune = form_dropdown('sharpen_tune', $o_sharpen_tune, $sharpen_tune);
	$i_acodec = form_dropdown('acodec', $o_acodec, $acodec);

	$this->table->add_row(array("Name:", $i_name));
	$this->table->add_row(array("Encoder:", "$i_x264_tune $i_crf $i_fps"));
	$this->table->add_row(array("Quality:", "cq $i_cq | qmin $i_qmin | qmax $i_qmax"));
	$this->table->add_row(array("Video:", $i_vcodec));
	$this->table->add_row(array("Denoise:", $i_denoise));
	$this->table->add_row(array("Sharpen:", "$i_sharpen $i_sharpen_tune"));
	$this->table->add_row(array("Audio:", "$i_acodec"));

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

	$this->table->set_heading(array('NSIX', 'Series Title', 'Series CRF', 'Active Status'));
	$this->table->set_template($tmpl);

	foreach($series_titles as $series_id => $arr_series) {
		$d_nsix = $arr_series['nsix'];
		$d_crf = "<center>".$arr_series['crf']."</center>";
		$d_status = "<center>".$arr_status[$arr_series['active']]."</center>";
		$a_series_title = anchor("series/details/$series_id", $arr_series['title']);
		$this->table->add_row(array($d_nsix, $a_series_title, $d_crf, $d_status));
	}
	echo $this->table->generate();
	$this->table->clear();
