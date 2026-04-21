<p><?php

	echo heading("Bugs", 4);

	$attr = array('id' => 'bugs_update', 'autocomplete' => 'off');

	echo "<blockquote>";

	echo form_open("dvds/update_bugs/".$dvds['id'], $attr);

	foreach($bugs as $dvd_bug) {

		$checked = false;
		if($dvd_bug['dvd_id'])
			$checked = true;
		$input_bugs[$dvd_bug['id']] = form_checkbox("dvd_bug[".$dvd_bug['id']."]", 'accept', $checked);
		$this->table->add_row(array($input_bugs[$dvd_bug['id']], $dvd_bug['name']));

	}

	$submit = form_submit('submit', 'Update');

	echo $this->table->generate();
	$this->table->clear();

	echo "<p>$submit</p>";

	echo form_close();

	echo "</blockquote>";
