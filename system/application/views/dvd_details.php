<p><?

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	/** DVD Deta **/
	echo heading("DVD Details", 4);
	
	echo "<blockquote>";
	
	extract($dvds);
	
	if(!isset($series_dvd))
		$series_dvd['series_id'] = null;
	
	echo form_open("dvds/update_series_dvd/".$dvds['id'], $attr);
	
	$i_series_id = form_dropdown('series_id', $select_series, $series_dvd['series_id']);
	
	$this->table->add_row(array("Longest Track:", $longest_track));
	$this->table->add_row(array("Provider ID:", $provider_id));
	$this->table->add_row(array("Title:", $title));
	$this->table->add_row(array("Uniq ID:", $uniq_id));
	$this->table->add_row(array("VMG ID:", $vmg_id));
	$this->table->add_row(array("Series:", $i_series_id));
	
	$submit = form_submit('submit', 'Update');
	
	echo $this->table->generate();
	
	echo "<p>$submit</p>";
	
	echo form_close();
	
	echo "</blockquote>";
