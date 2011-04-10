<?
	
	$series_dvds_id = $series_dvd['id'];

	/** Series Data **/
	echo heading("Series + DVD Details", 4);
	
	echo "<blockquote>";

	extract($series_dvd);
	$this->table->clear();
	
	$i_season = form_input('season', $season, "size='3' id='season' onkeyup=\"set_season($series_dvds_id, $('#season').val());\"");
	$i_ix = form_input('ix', $ix, "size='3' id='ix' onkeyup=\"set_ix($series_dvds_id, $('#ix').val());\"");
	
	$i_side_none = form_radio(array('name' => 'side', 'value' => '', 'checked' => ($side === ' '), 'onclick' => "set_side($series_dvds_id, ' ');"));
	$i_side_a = form_radio(array('name' => 'side', 'value' => 'A', 'checked' => ($side === 'A'), 'onclick' => "set_side($series_dvds_id, 'A');"));
	$i_side_b = form_radio(array('name' => 'side', 'value' => 'B', 'checked' => ($side === 'B'), 'onclick' => "set_side($series_dvds_id, 'B');"));
	
	$edit_season = "<input type='button' value='+' onclick=\"plus_one($('#season')); set_season($series_dvds_id, $('#season').val());\">";
	$edit_season .= "<input type='button' value='-' onclick=\"minus_one($('#season')); set_season($series_dvds_id, $('#season').val());\">";
	
	$edit_ix = "<input type='button' value='+' onclick=\"plus_one($('#ix')); set_ix($series_dvds_id, $('#ix').val());\">";
	$edit_ix .= "<input type='button' value='-' onclick=\"minus_one($('#ix')); set_ix($series_dvds_id, $('#ix').val());\">";
	
	$this->table->add_row(array("Season:", "$i_season $edit_season"));
	$this->table->add_row(array("Disc:", "$i_ix $edit_ix"));
	$this->table->add_row(array("Side:", "$i_side_none None &nbsp; $i_side_a A &nbsp; $i_side_b B"));
	
	echo $this->table->generate();
	
	echo "</blockquote>";