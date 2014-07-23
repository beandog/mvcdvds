<p><?

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	$select_audio_preference = array(
		'Default',
		'First English Track',
		'Best Audio Quality',
	);

	/** DVD Deta **/
	echo heading("DVD Series", 4);

	echo "<blockquote>";

	extract($dvds);

	if(!isset($series_dvd)) {
		$series_dvd['series_id'] = null;
		$series_dvd['audio_preference'] = null;
		$series_dvd['no_dvdnav'] = null;
	}

	echo form_open("dvds/update_series_dvd/".$dvds['id'], $attr);

	$i_series_id = form_dropdown('series_id', $select_series, $series_dvd['series_id']);
	$i_audio_preference = form_dropdown('audio_preference', $select_audio_preference, $series_dvd['audio_preference']);
	$i_no_dvdnav = form_checkbox('no_dvdnav', 't', $series_dvd['no_dvdnav'] == 't');

	if(!empty($title))
		$this->table->add_row(array("Title:", $title));
	if(!empty($provider_id))
		$this->table->add_row(array("Provider ID:", $provider_id));
	if(!empty($vmg_id))
		$this->table->add_row(array("VMG ID:", $vmg_id));
	$this->table->add_row(array("Uniq ID:", $uniq_id));
	if($longest_track)
		$this->table->add_row(array("Longest Track:", $longest_track));
	$this->table->add_row(array("Series:", $i_series_id));
	$this->table->add_row(array("Audio:", $i_audio_preference));
	$this->table->add_row(array("No dvdnav:", $i_no_dvdnav));

	$submit = form_submit('submit', 'Update');

	echo $this->table->generate();
	$this->table->clear();

	echo "<p>$submit</p>";

	echo form_close();

	echo "</blockquote>";
