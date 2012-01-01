<?

	echo form_open("presets/update/$id", array('autocomplete' => 'off'));
	
	echo heading("Edit Details", 4);
	
	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');
	
	$strict = $loose = false;
	
	$inputs = array();

	$o_format = array('mkv', 'mp4');
	$o_acodec = array('copy', 'aac');

	$d_format = 'mkv';
	$d_acodec = 'copy';
	
	$i_name = form_input('name', $name);
	$i_base_preset = form_input('base_preset', $base_preset);
	$i_crf = form_input('crf', $crf, 'size=2');
	$i_x264opts = form_input('x264opts', $x264opts);
	$i_format = form_dropdown('format', $o_format, $d_format);
	$i_acodec = form_dropdown('acodec', $o_acodec, $d_acodec);
	
	$this->table->add_row(array("Name:", $i_name));
	$this->table->add_row(array("Base Preset:", $i_base_preset));
	$this->table->add_row(array("CRF:", $i_crf));
	$this->table->add_row(array("x264:", $i_x264opts));
	$this->table->add_row(array("Format:", $i_format));
	$this->table->add_row(array("Audio:", $i_acodec));
	
	$submit = form_submit('submit', 'Update');
	
	echo $this->table->generate();
	$this->table->clear();
	
	echo "<p>$submit</p>";
	
	echo form_close();
	
	echo "</blockquote>";	
