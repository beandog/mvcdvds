<?

	echo form_open("presets/update/$id", array('autocomplete' => 'off'));
	
	echo heading("Edit Details", 4);
	
	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');
	
	$strict = $loose = false;
	
	$inputs = array();
	
	$i_name = form_input('name', $name);
	$i_base_preset = form_input('base_preset', $base_preset);
	$i_crf = form_input('crf', $crf, 'size=2');
	$i_x264opts = form_input('x264opts', $x264opts);
	
	$this->table->add_row(array("Name:", $i_name));
	$this->table->add_row(array("Base Preset:", $i_base_preset));
	$this->table->add_row(array("CRF:", $i_crf));
	$this->table->add_row(array("x264:", $i_x264opts));
	
	$submit = form_submit('submit', 'Update');
	
	echo $this->table->generate();
	$this->table->clear();
	
	echo "<p>$submit</p>";
	
	echo form_close();
	
	echo "</blockquote>";	