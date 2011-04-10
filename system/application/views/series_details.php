<p><?

	echo heading("Series", 4);
	
	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	extract($series);

	echo form_open("series/update/$id", $attr);

	$input_collection = form_dropdown('collection', $collections, $collection['id']);
	$input_preset = form_dropdown('preset_id', $presets, $preset['id']);
	$input_long_title = form_input('title_long', $title_long, "size='50'");
	$input_title = form_input('title', $title, "size='50'");
	$input_average_length = form_input('average_length', $average_length, "size='3'");
	$input_production_year = form_input('production_year', $production_year, "size='4'");
	$input_indexed = form_checkbox('indexed', 'accept', pg_bool($indexed));
	
	$this->table->add_row(array("Collection:", $input_collection));
	$this->table->add_row(array("Preset:", $input_preset));
	$this->table->add_row(array("Long Title:", $input_long_title));
	$this->table->add_row(array("Sorting Title:", $input_title));
	$this->table->add_row(array("Avg. Length:", $input_average_length));
	$this->table->add_row(array("Production Year:", $input_production_year));
	$this->table->add_row(array("Indexed:", $input_indexed));
	
	$submit = form_submit('submit', 'Update');
	
	echo $this->table->generate();
	
	echo "<p>$submit</p>";
	
	echo form_close();
	
	echo "</blockquote>";