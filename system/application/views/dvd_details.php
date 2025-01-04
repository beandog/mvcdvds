<p><?php

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	$select_audio_preference = array(
		'Default',
		'First English Track',
		'Best Audio Quality',
	);

	/** DVD Series **/
	echo heading("DVD Series", 4);

	echo "<blockquote>";

	extract($dvds);

	if(!isset($series_dvd)) {
		$series_dvd['series_id'] = null;
		$series_dvd['audio_preference'] = null;
	// 	$series_dvd['no_dvdnav'] = null;
	}

	echo form_open("dvds/update_series_dvd/".$dvds['id'], $attr);

	if($bluray) {
		$i_bluray_id = form_input('bluray_id', '', "size='34'");
		// Strictly speaking, this should already be imported regardless of whether it's an ISO or not, so ignoring udpating it
		// $i_bluray_disc_title = form_input('bluray_disc_title', '', "size='34'");
	}
	$i_series_id = form_dropdown('series_id', $select_series, $series_dvd['series_id']);
	$i_audio_preference = form_dropdown('audio_preference', $select_audio_preference, $series_dvd['audio_preference']);
	$i_package_title = form_input('package_title', $package_title, "size='48'");
	$i_volname = form_input('volname', $title, "size='48'");
	// $i_no_dvdnav = form_checkbox('no_dvdnav', 't', $series_dvd['no_dvdnav'] == 't');

	$nsix = "$collection_id.".str_pad($series['id'], 3, 0, STR_PAD_LEFT).".".str_pad($dvds['id'], 4, 0, STR_PAD_LEFT).".".$series['nsix'].".iso";

	if($bluray || empty($title))
		$this->table->add_row(array("Volume name:", $i_volname));
	else
		$this->table->add_row(array("Title:", $title));
	if($bluray)
		$this->table->add_row('Blu-ray Disc Title:', $bluray_data['disc_title']);
	$this->table->add_row(array("NSIX:", $nsix));
	if(!empty($provider_id))
		$this->table->add_row(array("Provider ID:", $provider_id));
	if(!empty($vmg_id))
		$this->table->add_row(array("VMG ID:", $vmg_id));
	if($bluray && strlen($dvdread_id) != 32) {
		$this->table->add_row(array("legacy bluray ID:", "<tt>$dvdread_id</tt>"));
		$this->table->add_row(array("dvdread ID:", $i_bluray_id));
	} else {
		$this->table->add_row(array("dvdread ID:", "<tt>$dvdread_id</tt>"));
	}
	if(isset($longest_track))
		$this->table->add_row(array("Longest Track:", $longest_track));
	$this->table->add_row(array("Package title:", $i_package_title));
	$this->table->add_row(array("Series:", $i_series_id));
	$this->table->add_row(array("Audio:", $i_audio_preference));
	// $this->table->add_row(array("No dvdnav:", $i_no_dvdnav));

	$submit = form_submit('submit', 'Update');

	echo $this->table->generate();
	$this->table->clear();

	echo "<p>$submit</p>";

	echo form_close();

	echo "</blockquote>";

