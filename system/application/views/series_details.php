<p><?php

	foreach($presets as $id => $arr)
		$arr_dropdown_presets[$id] = $arr['name'];

	echo heading("Series Encoding Settings", 4);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	extract($series);

	echo form_open("series/update/$id", $attr);

	$display_average_length = ($average_length ? $average_length : "");

	// $x264_presets = array('' => '', 'medium' => 'medium', 'slow' => 'slow');

	$input_nsix = form_input('nsix', $nsix, "size='8' maxlength='5'");
	$input_title = form_input('title', $title, "size='50'");
	$input_tvdb = form_input('tvdb', $tvdb, "size='25'");
	$input_jfin = form_input('jfin', $jfin, "size=6");
	$input_crf = form_input('crf', $crf, "size='3'");
	$input_collection = form_dropdown('collection', $collections, $collection['id']);
	if(!is_array($preset))
		$preset['id'] = 0;
	$input_preset = form_dropdown('preset_id', $arr_dropdown_presets, $preset['id']);
	$input_ripping = form_dropdown('ripping_id', $rippers, $ripping_id);
	// $input_x264_preset = form_dropdown('x264_preset', $x264_presets, $x264_preset);
	// $input_preset .= " $input_ripping $input_x264_preset $input_crf";
	$input_preset .= " $input_ripping $input_crf";
	$input_production_year = form_input('production_year', $production_year, "size='4'");
	$input_average_length = form_input('average_length', $display_average_length, "size='3'");
	$input_qa_notes = form_textarea('qa_notes', $qa_notes);
	$input_start_date = form_input('start_date', $start_date, "size='10'");
	$input_active = form_dropdown('active', array(1 => 'Active', 2 => 'Inactive', 3 => 'Archived'), $active);

	$input_tvdb .= " $input_jfin";
	if($tvdb)
		$input_tvdb .= " <a href='https://www.thetvdb.com/series/$tvdb/seasons/all' target='_blank'>All Seasons</a>";

	$this->table->add_row(array("NSIX:", $input_nsix));
	$this->table->add_row(array("Display Title:", $input_title));
	$this->table->add_row(array("TV DB:", $input_tvdb));
	$this->table->add_row(array("Collection:", $input_collection));
	$this->table->add_row(array("Preset:", $input_preset));
	$this->table->add_row(array("Production Year:", $input_production_year));
	$this->table->add_row(array("Avg. Length:", $input_average_length));
	$this->table->add_row(array("Start Date:", $input_start_date));
	$this->table->add_row(array("QA Notes:", $input_qa_notes));
	$this->table->add_row(array("Active:", $input_active));

	$submit = form_submit('submit', 'Update');

	echo $this->table->generate();
	$this->table->clear();

	echo "<p>$submit</p>";

	echo form_close();

	echo "</blockquote>";
