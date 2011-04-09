<?
	
	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	/** Series Data **/
	echo heading("Series + DVD Details", 4);
	
	echo "<blockquote>";

	echo form_open("dvds/update_series/".$series_dvd['id'], $attr);
	
	extract($series_dvd);
	$this->table->clear();
	
	$i_ix = form_input('ix', $ix, "size='3' id='ix'");
	$i_season = form_input('season', $season, "size='3' id='season'");
	$i_side_none = form_radio('side', '', $side === ' ');
	$i_side_a = form_radio('side', 'A', $side === 'A');
	$i_side_b = form_radio('side', 'B', $side === 'B');
	
	$edit_season = "<input type='button' value='+' onclick=\"plus_one($('#season'));\">";
	$edit_season .= "<input type='button' value='-' onclick=\"minus_one($('#season'));\">";
	
	$edit_ix = "<input type='button' value='+' onclick=\"plus_one($('#ix'));\">";
	$edit_ix .= "<input type='button' value='-' onclick=\"minus_one($('#ix'));\">";
	
	$this->table->add_row(array("Season:", "$i_season $edit_season"));
	$this->table->add_row(array("Disc:", "$i_ix $edit_ix"));
	$this->table->add_row(array("Side:", "$i_side_none None &nbsp; $i_side_a A &nbsp; $i_side_b B"));
	
	$submit = form_submit('submit', 'Update');
	
	echo $this->table->generate();
	
	echo "<p>$submit</p>";
	
	echo form_close();
	
	echo "</blockquote>";