<p><?php

	foreach($presets as $id => $arr)
		$arr_dropdown_presets[$id] = $arr['name'];

	echo heading("Series", 4);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	extract($series);

	echo form_open("series/update/$id", $attr);

	$display_average_length = ($average_length ? $average_length : "");

	$input_collection = form_dropdown('collection', $collections, $collection['id']);
	$input_preset = form_dropdown('preset_id', $arr_dropdown_presets, $preset['id']);
	$input_title = form_input('title', $title, "size='50'");
	$input_average_length = form_input('average_length', $display_average_length, "size='3'");
	$input_production_year = form_input('production_year', $production_year, "size='4'");
	$input_indexed = form_checkbox('indexed', 'accept', pg_bool($indexed));
	$input_grayscale = form_checkbox('grayscale', 'accept', $grayscale);

	$this->table->add_row(array("Collection:", $input_collection));
	$this->table->add_row(array("Preset:", $input_preset));
	$this->table->add_row(array("Display Title:", $input_title));
	$this->table->add_row(array("Avg. Length:", $input_average_length));
	$this->table->add_row(array("Production Year:", $input_production_year));
	$this->table->add_row(array("Indexed:", $input_indexed));
	$this->table->add_row(array("Grayscale:", $input_grayscale));

	$submit = form_submit('submit', 'Update');

	echo $this->table->generate();
	$this->table->clear();

	echo "<p>$submit</p>";

	echo form_close();

	echo "</blockquote>";
