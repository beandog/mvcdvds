<?

	echo form_open("presets/update/$id", array('autocomplete' => 'off'));

	echo heading("Edit Details", 4);

	echo "<blockquote>";

	$attr = array('id' => 'series_update', 'autocomplete' => 'off');

	$strict = $loose = false;

	$inputs = array();

	$o_format = array('mkv' => 'mkv', 'mp4' => 'mp4');
	$o_acodec = array('copy' => 'copy', 'aac' => 'aac');

	$i_name = form_input('name', $name);
	$i_crf = form_input('crf', $crf, 'size=2');
	$i_x264opts = form_input('x264opts', $x264opts);
	$i_format = form_dropdown('format', $o_format, $format);
	$i_video_bitrate = form_input('video_bitrate', $video_bitrate);
	$i_acodec = form_dropdown('acodec', $o_acodec, $acodec);
	$i_acodec_bitrate = form_input('acodec_bitrate', $acodec_bitrate);

	$this->table->add_row(array("Name:", $i_name));
	$this->table->add_row(array("CRF:", $i_crf));
	$this->table->add_row(array("x264:", $i_x264opts));
	$this->table->add_row(array("Format:", $i_format));
	$this->table->add_row(array("Video Bitrate:", $i_video_bitrate));
	$this->table->add_row(array("Audio Codec:", $i_acodec));
	$this->table->add_row(array("Audio Bitrate:", $i_acodec_bitrate));

	$submit = form_submit('submit', 'Update');

	echo $this->table->generate();
	$this->table->clear();

	echo "<p>$submit</p>";

	echo form_close();

	echo "</blockquote>";
