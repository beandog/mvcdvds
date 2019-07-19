<p><?php

	foreach($presets as $id => $arr)
		$arr_dropdown_presets[$id] = $arr['name'];

	$arr_dropdown_frequency = array('', 'High', 'Medium', 'Normal', 'New', 'Special');

	echo heading("Series", 4);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	extract($series);

	echo form_open("series/update/$id", $attr);

	$display_average_length = ($average_length ? $average_length : "");

	$input_nsix = form_input('nsix', $nsix, "size='8' maxlength='5'");
	$input_title = form_input('title', $title, "size='50'");
	$input_tvdb = form_input('tvdb', $tvdb, "size='25'");
	$input_collection = form_dropdown('collection', $collections, $collection['id']);
	$input_preset = form_dropdown('preset_id', $arr_dropdown_presets, $preset['id']);
	$input_production_year = form_input('production_year', $production_year, "size='4'");
	$input_average_length = form_input('average_length', $display_average_length, "size='3'");
	$input_indexed = form_checkbox('indexed', 'accept', pg_bool($indexed));
	$input_frequency = form_dropdown('frequency', $arr_dropdown_frequency, $frequency);
	$input_cgi = form_checkbox('cgi', 'accept', $cgi);
	$input_grayscale = form_checkbox('grayscale', 'accept', $grayscale);
	$input_dvdnav = form_checkbox('dvdnav', '1', $dvdnav == '1');
	$input_qa_notes = form_textarea('qa_notes', $qa_notes);

	if($tvdb)
		$input_tvdb .= " <a href='https://www.thetvdb.com/series/$tvdb/seasons/all' target='_blank'>All Seasons</a>";

	$this->table->add_row(array("NSIX:", $input_nsix));
	$this->table->add_row(array("Display Title:", $input_title));
	$this->table->add_row(array("TV DB:", $input_tvdb));
	$this->table->add_row(array("Collection:", $input_collection));
	$this->table->add_row(array("Preset:", $input_preset));
	$this->table->add_row(array("Production Year:", $input_production_year));
	$this->table->add_row(array("Avg. Length:", $input_average_length));
	$this->table->add_row(array("Frequency:", $input_frequency));
	$this->table->add_row(array("CGI:", $input_cgi));
	$this->table->add_row(array("Grayscale:", $input_grayscale));
	$this->table->add_row(array("dvdnav:", $input_dvdnav));
	$this->table->add_row(array("QA Notes:", $input_qa_notes));

	$submit = form_submit('submit', 'Update');

	echo $this->table->generate();
	$this->table->clear();

	echo "<p>$submit</p>";

	echo form_close();

	echo "</blockquote>";
