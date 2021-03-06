<?php

	/** Series Data **/
	$series_dvds_nav = $this->load->view('series_dvds_nav', array('series_dvds' => $series_dvds), true);

	echo heading("Details $series_dvds_nav", 4);

	$series_dvds_id = $series_dvd['id'];

	$a_dvd_delete = anchor("dvds/delete/$dvd_id", "Remove DVD", "onclick='return confirm(\"Remove disc?\");'");

	echo $a_dvd_delete;

	echo p();

	echo "<blockquote>";

	extract($series_dvd);

	$display_season = ($season ? $season : "");
	$display_volume = ($volume ? $volume : "");
	$display_ix = ($ix ? $ix : "");

	$i_season = form_input('season', $display_season, "size='3' id='season' onkeyup=\"set_season($series_dvds_id, $('#season').val());\"");
	$i_volume = form_input('volume', $display_volume, "size='3' id='volume' onkeyup=\"set_volume($series_dvds_id, $('#volume').val());\"");
	$i_ix = form_input('ix', $display_ix, "size='3' id='ix' onkeyup=\"set_ix($series_dvds_id, $('#ix').val());\"");

	$i_side_none = form_radio(array('name' => 'side', 'value' => '', 'checked' => ($side === ' '), 'onclick' => "set_side($series_dvds_id, ' ');"));
	$i_side_a = form_radio(array('name' => 'side', 'value' => 'A', 'checked' => ($side === 'A'), 'onclick' => "set_side($series_dvds_id, 'A');"));
	$i_side_b = form_radio(array('name' => 'side', 'value' => 'B', 'checked' => ($side === 'B'), 'onclick' => "set_side($series_dvds_id, 'B');"));

	$edit_season = "<input type='button' value='+' onclick=\"plus_one($('#season')); set_season($series_dvds_id, $('#season').val());\">";
	$edit_season .= "<input type='button' value='-' onclick=\"minus_one($('#season')); set_season($series_dvds_id, $('#season').val());\">";

	$edit_volume = "<input type='button' value='+' onclick=\"plus_one($('#volume')); set_volume($series_dvds_id, $('#volume').val());\">";
	$edit_volume .= "<input type='button' value='-' onclick=\"minus_one($('#volume')); set_volume($series_dvds_id, $('#volume').val());\">";

	$edit_ix = "<input type='button' value='+' onclick=\"plus_one($('#ix')); set_ix($series_dvds_id, $('#ix').val());\">";
	$edit_ix .= "<input type='button' value='-' onclick=\"minus_one($('#ix')); set_ix($series_dvds_id, $('#ix').val());\">";

	$this->table->add_row(array("Season:", "$i_season $edit_season"));
	$this->table->add_row(array("Volume:", "$i_volume $edit_volume"));
	$this->table->add_row(array("Disc:", "$i_ix $edit_ix"));
	$this->table->add_row(array("Side:", "$i_side_none None &nbsp; $i_side_a A &nbsp; $i_side_b B"));

	echo $this->table->generate();
	$this->table->clear();

	echo "</blockquote>";
