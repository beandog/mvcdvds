<p><?php

	if(count($audio)) {

		echo heading("Audio Tracks", 4);

		$bluray = $dvds['bluray'];

		$tbl_heading = array(
			'ix',
			'Language',
			'Format',
			'Ch.',
			'Stream',
			'Active',
		);

		if($bluray)
			$tbl_heading[] = 'Passthrough';

		$this->table->set_heading($tbl_heading);

		$num_episodes = 0;

		$img_add = img(array('src' => "images/icons/add.png", 'border' => 0));
		$img_delete = img("images/icons/delete.png");

		$audio_ix = $tracks[$track_id]['audio_ix'];

		foreach($audio as $audio_id => $audio_row) {

			extract($audio_row);

			$color = 'black';

			$display_ix = "Track $ix";

			if($active === "0")
				$display_active = 'no';
			elseif($active === "1")
				$display_active = 'yes';
			else
				$display_active = 'Missing Metadata';

			$display_passthrough = '';
			if($ix == $audio_ix)
				$display_passthrough = "<img src='/images/icons/sound.png'>";
			/*
			if($langcode == 'eng' && ($passthrough == null || $passthrough == 1))
				$display_passthrough = "<img src='/images/icons/sound.png'>";
			elseif($langcode == 'eng' && ($passthrough == 1))
				$display_passthrough = "<img src='/images/icons/sound_delete.png'>";
			*/

			$tbl_row = array(

				$display_ix,
				$langcode,
				$format,
				$channels,
				$streamid,
				$display_active,
				$display_passthrough

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
