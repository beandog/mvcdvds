<p><?php

	$bluray = false;
	if($tracks[$track_id]['playlist'] != null)
		$bluray = true;

	if(count($subp) || $cc) {

		echo heading("Subtitles", 4);

		$tbl_heading = array(
			'ix',
			'Language',
			'Stream',
			'Active',
		);

		if($bluray)
			$tbl_heading[] = 'Passthrough';

		$this->table->set_heading($tbl_heading);

		foreach($subp as $subp_id => $subp_row) {

			extract($subp_row);

			$color = 'black';

			$display_ix = "Track $ix";
			if($bluray)
				$display_ix = "Track ".($ix + count($audio));

			$display_language = "$langcode";

			if($active === "0")
				$display_active = 'no';
			elseif($active === "1")
				$display_active = 'yes';
			else
				$display_active = 'Missing Metadata';

			$display_passthrough = '';
			if($langcode == 'eng' && ($passthrough == null || $passthrough == 1))
				$display_passthrough = 'Default';

			$tbl_row = array(

				$display_ix,
				$display_language,
				$streamid,
				$display_active,

			);

			if($bluray)
				$tbl_row[] = $display_passthrough;

			$this->table->add_row($tbl_row);

		}

		if($cc) {

			$color = 'black';

			$display_ix = "Track ".(count($subp) + 1);
			$display_language = "en";
			$streamid = 'cc';
			$display_active = 'yes';

			$tbl_row = array(

				$display_ix,
				$display_language,
				$streamid,
				$display_active,

			);

			$this->table->add_row($tbl_row);

		}

		$tmpl = array(
			'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
		);

		$this->table->set_template($tmpl);

		echo $this->table->generate();
		$this->table->clear();

	}
