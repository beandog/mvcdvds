<p><?php

	if(count($subp)) {

		echo heading("Subtitles", 4);

		$tbl_heading = array(
			'ix',
			'Language',
			'Stream',
			'Active',
		);

		$this->table->set_heading($tbl_heading);

		foreach($subp as $subp_id => $subp_row) {

			extract($subp_row);

			$color = 'black';

			$display_ix = "Track $ix";
			$display_language = "$langcode";
			if($active === 0)
				$display_active = 'no';
			elseif($active === 1)
				$display_active = 'yes';
			else
				$display_active = '';

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
