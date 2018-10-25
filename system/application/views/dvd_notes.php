<?php

	/** DVD Metadata **/
	echo heading("Notes", 4);

	$attr = array('id' => 'dvd_update', 'autocomplete' => 'off');

	echo "<blockquote>";

	echo form_open("dvds/update_metadata/".$dvds['id'], $attr);

	$i_dvd_notes = form_textarea(array('name' => 'notes', 'rows' => 5, 'cols' => 50), $dvds['notes']);

	$this->table->add_row(array("Bugs:", $i_dvd_notes));

	$submit = form_submit('submit', 'Update');

	echo $this->table->generate();
	$this->table->clear();

	echo "<p>$submit</p>";

	echo form_close();

	echo "</blockquote>";
