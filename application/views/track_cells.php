<p><?php

	echo heading("Cells", 4);

	$tbl_heading = array(
		'ix',
		'First sector',
		'Last sector',
	);

	$this->table->set_heading($tbl_heading);

	foreach($cells as $cell_id => $cell_row) {

		extract($cell_row);

		$color = 'black';

		$display_ix = "Cell $ix";
		$display_first_sector = $first_sector;
		$display_last_sector = $last_sector;

		$tbl_row = array(

			$display_ix,
			$display_first_sector,
			$display_last_sector

		);

		$this->table->add_row($tbl_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();
