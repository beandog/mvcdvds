<?

	echo form_open("presets/update/$id", array('autocomplete' => 'off'));
	
	echo heading("Edit Details", 4);
	
	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');
	
	$strict = $loose = false;
	
	if($anamorphic == 'strict')
		$strict = true;
	if($anamorphic == 'loose')
		$loose = true;
	
	$arr_b_pyramid = array('none' => 'Off', 'strict' => 'Strict', 'normal' => 'Normal');
	$arr_me = array('diamond' => 'Diamond', 'hex' => 'Hexagon', 'umh' => 'Uneven Multi-Hexagon', 'esa' => 'Exhaustive', 'tesa' => 'Hadamard Exhaustive');
	$arr_direct = array('none' => 'None', 'spatial' => 'Spatial', 'temporal' => 'Temporal', 'auto' => 'Automatic');
	$arr_partitions = array('p8x8,b8x8,i8x8,i4x4' => 'Most', 'none' => 'None', 'i4x4,i8x8' => 'Some', 'all' => 'All');
	$arr_weightp = array('Off', 'Blind', 'Smart');
	$arr_subme = array('SAD, no subpel', 'SAD, qpel', 'SATD, qpel', 'SATD, multi-qpel', 'SATD, qpel on all', 'SATD, multi-qpel on all', 'RD in I/P-Frames', 'RD in all frames', 'RD refine in I/P-frames', 'RD refine in all frames', 'QPRD in all frames');
	$arr_b_adapt = array('Off', 'Fast', 'Optimal');
	
	$inputs = array();
	
	$bools = array('grayscale', 'detelecine', 'decomb', 'deinterlace', '_8x8dct', 'cabac', 'no_dct_decimate', 'mixed_refs');
	
	$numbers = array('crf', 'ref', 'bframes', 'merange', 'trellis', 'keyint', 'rc_lookahead', 'aq_strength', 'psy_rd', 'deblock');
	
	foreach($bools as $str)
		$inputs[$str] = form_checkbox($str, '1', pg_bool($$str));
		
	foreach($numbers as $str)
		$inputs[$str] = form_input($str, $$str, "size='".(max(2, strlen($$str))) ."'");
	
	$i_name = form_input('name', $name);
	$i_base_preset = form_input('base_preset', $base_preset);
	$i_anamorphic_strict = form_radio('anamorphic', 'strict', $strict);
	$i_anamorphic_loose = form_radio('anamorphic', 'loose', $loose);
	$i_b_pyramid = form_dropdown('b_pyramid', $arr_b_pyramid, $b_pyramid);
	$inputs['me'] = form_dropdown('me', $arr_me, $me);
	$inputs['direct'] = form_dropdown('direct', $arr_direct, $direct);
	$inputs['partitions'] = form_dropdown('partitions', $arr_partitions, $partitions);
	$inputs['weightp'] = form_dropdown('weightp', $arr_weightp, $weightp);
	$inputs['subme'] = form_dropdown('subme', $arr_subme, $subme);
	$inputs['b_adapt'] = form_dropdown('b_adapt', $arr_b_adapt, $b_adapt);
	
	$this->table->add_row(array("Name:", $i_name));
	$this->table->add_row(array("Base Preset:", $i_base_preset));
	$this->table->add_row(array("CRF:", $inputs['crf']));
	$this->table->add_row(array("Grayscale:", $inputs['grayscale']));
	$this->table->add_row(array("Detelecine:", $inputs['detelecine']));
	$this->table->add_row(array("Decomb:", $inputs['decomb']));
	$this->table->add_row(array("Deinterlace:", $inputs['deinterlace']));
	$this->table->add_row(array("Anamorphic:", "$i_anamorphic_strict Strict $i_anamorphic_loose Loose"));
	$this->table->add_row(array("Reference Frames:", $inputs['ref']));
	$this->table->add_row(array("Maximum B-Frames:", $inputs['bframes']));
	$this->table->add_row(array("Pyramidal B-Frames:", $i_b_pyramid));
	$this->table->add_row(array("Weighted P-Frames:", $inputs['weightp']));
	$this->table->add_row(array("8x8 Transform:", $inputs['_8x8dct']));
	$this->table->add_row(array("CABAC Entropy Encoding:", $inputs['cabac']));
	$this->table->add_row(array("Motion Est. Method:", $inputs['me']));
	$this->table->add_row(array("Subpel ME & Mode:", $inputs['subme']));
	$this->table->add_row(array("Motion Est. Range:", $inputs['merange']));
	$this->table->add_row(array("Adaptive Direct Mode:", $inputs['direct']));
	$this->table->add_row(array("Adaptive B-Frames:", $inputs['b_adapt']));
	$this->table->add_row(array("Partitions:", $inputs['partitions']));
	$this->table->add_row(array("Trellis:", $inputs['trellis']));
	$this->table->add_row(array("Adaptive Quantization Strength:", $inputs['aq_strength']));
	$this->table->add_row(array("Psychovisual Rate Distortion:", $inputs['psy_rd']));
	$this->table->add_row(array("Deblocking:", $inputs['deblock']));
	$this->table->add_row(array("No DCT Decimate:", $inputs['no_dct_decimate']));
	$this->table->add_row(array("Keyint:", $inputs['keyint']));
	$this->table->add_row(array("RC Lookahead:", $inputs['rc_lookahead']));
	$this->table->add_row(array("Mixed Reference Frames:", $inputs['mixed_refs']));
	
	
	$submit = form_submit('submit', 'Update');
	
	echo $this->table->generate();
	$this->table->clear();
	
	echo "<p>$submit</p>";
	
	echo form_close();
	
	echo "</blockquote>";	