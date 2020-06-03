<p><?php

	foreach($presets as $id => $arr)
		$arr_dropdown_presets[$id] = $arr['name'];

	if(count($libraries)) {
		$libraries[0] = '';
		ksort($libraries);
	}
	$input_libraries = '';

	echo heading("Series", 4);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	extract($series);

	echo form_open("series/update/$id", $attr);

	$display_average_length = ($average_length ? $average_length : "");
	$display_upgrade_id = ($upgrade_id ? $upgrade_id : "");

	$input_nsix = form_input('nsix', $nsix, "size='8' maxlength='5'");
	$input_title = form_input('title', $title, "size='50'");
	$input_tvdb = form_input('tvdb', $tvdb, "size='25'");
	$input_crf = form_input('crf', $crf, "size='3'");
	$input_collection = form_dropdown('collection', $collections, $collection['id']);
	if(count($libraries)) {
		$input_libraries = form_dropdown('library', $libraries, $series['library_id']);
		$input_collection .= " $input_libraries";
	}
	$input_collection .= " $input_crf";
	$input_preset = form_dropdown('preset_id', $arr_dropdown_presets, $preset['id']);
	$input_production_year = form_input('production_year', $production_year, "size='4'");
	$input_average_length = form_input('average_length', $display_average_length, "size='3'");
	$input_upgrade_id = form_input('upgrade_id', $display_upgrade_id, "size='3'");
	$input_grayscale = form_checkbox('grayscale', 'accept', $grayscale);
	$input_detelecine = form_checkbox('detelecine', 'accept', $detelecine);
	$input_decomb = form_dropdown('decomb', array('None', 'Default', 'Permissive'), $decomb);
	$input_dvdnav = form_checkbox('dvdnav', '1', $dvdnav == '1');
	$input_qa_notes = form_textarea('qa_notes', $qa_notes);
	$input_screenshots = form_input('screenshots', $screenshots, "size='18'");
	$input_start_date = form_input('start_date', $start_date, "size='10'");
	$input_active = form_checkbox('active', 'accept', $active);

	if($tvdb)
		$input_tvdb .= " <a href='https://www.thetvdb.com/series/$tvdb/seasons/all' target='_blank'>All Seasons</a>";

	$this->table->add_row(array("NSIX:", $input_nsix));
	$this->table->add_row(array("Display Title:", $input_title));
	$this->table->add_row(array("TV DB:", $input_tvdb));
	$this->table->add_row(array("Collection:", $input_collection));
	$this->table->add_row(array("Preset:", $input_preset));
	$this->table->add_row(array("Production Year:", $input_production_year));
	$this->table->add_row(array("Avg. Length:", $input_average_length));
	if($collection_id == 1 || $collection_id == 2 || $collection_id == 4)
		$this->table->add_row(array("Upgrade:", $input_upgrade_id));
	$this->table->add_row(array("Start Date:", $input_start_date));
	$this->table->add_row(array("Grayscale:", $input_grayscale));
	$this->table->add_row(array("Detelecine:", $input_detelecine));
	$this->table->add_row(array("Decomb:", $input_decomb));
	$this->table->add_row(array("dvdnav:", $input_dvdnav));
	$this->table->add_row(array("Screenshots:", $input_screenshots));
	$this->table->add_row(array("QA Notes:", $input_qa_notes));
	$this->table->add_row(array("Active:", $input_active));

	$submit = form_submit('submit', 'Update');

	echo $this->table->generate();
	$this->table->clear();

	echo "<p>$submit</p>";

	echo form_close();

	echo "</blockquote>";
