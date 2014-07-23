<?

	$header = array(
		'Title',
	);

	$this->table->set_heading($header);

	foreach($series as $arr) {

// 		pre($row);

		extract($arr);

		$a_title = anchor("series/dvds/$id", $title, array('class' => 'black'));

		$table_row = array(
			$a_title,
		);

		$this->table->add_row($table_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();
