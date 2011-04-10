<p>
<?

	extract($tracks);
	
	$tbl_heading = array(
		'',
		'Track',
		'ix',
		'Title',
		'Ch.',
		'',
		'Ssn.',
		''
	);
	
	echo heading("Episodes", 4);
	
	echo anchor("", "Reindex Episodes", "onclick='reindex(); return false;'");
	echo nbs();
	echo anchor("", "Remove Indexes", "onclick='remove_indexes(); return false;'");
	echo p();
	
	echo form_open("dvds/update_episodes/".$dvds['id'], "autocomplete='off' method='post'");
	
	$this->table->set_heading($tbl_heading);
	
	$img_dvd = img(array('src' => "images/icons/dvd.png", 'class' => 'handle'));
	
	foreach($episodes as $episode_id => $row) {
	
		$img_delete = img(array('src' => "images/icons/delete.png", 'class' => 'pointer', 'onclick' => 'delete_episode('.$episode_id.', this); return false;'));
		
		extract($row);
		
		$i_track_ix = form_input("episode[$episode_id][track_ix]", $track_ix, "size='2' track_id='$track_id' episode_id='$episode_id'");
// 		$i_ix = form_hidden("ix[$id]", $ix, "ix='$ix' track_id='$track_id' episode_id='$id'");
// 		$i_ix = form_hidden(array('name' => "ix[$id]", 'value' => $ix, 'ix' => $ix, 'track_id' => $track_id, 'episode_id' => $id));
		$i_ix = "<input type='text' size='2' name='episode[$episode_id][ix]' value='$ix' ix='$ix' track_id='$track_id' episode_id='$episode_id'>\n";
		$i_title = form_input("episode[$episode_id][title]", $title, "size='30' track_id='$track_id' episode_id='$episode_id'");
		
		$i_season = form_input("episode[$episode_id][season]", $season, "size='2' track_id='$track_id' episode_id='$episode_id'");
		
		// FIXME Only display chapters if prompted to
		$i_starting_chapter = form_input("episode[$episode_id][starting_chapter]", $starting_chapter, "size='2' track_id='$track_id' episode_id='$episode_id'");
		$i_ending_chapter = form_input("episode[$episode_id][ending_chapter]", $ending_chapter, "size='2' track_id='$track_id' episode_id='$episode_id'");
	
	
		$tbl_row = array(
		
			$img_dvd,
			
			$i_track_ix,
			$i_ix,
			$i_title,
			$i_starting_chapter,
			$i_ending_chapter,
 			$i_season,
 			$img_delete,
		
		);
		
 		$this->table->add_row($tbl_row);
		
	}
	
	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra" id="sort"><tbody>',
		'table_close' => '</tbody></table>',
		'row_end' => "</tr>\n",
		'cell_end' => "</td>\n",
	);
	
	$this->table->set_template($tmpl);
	
	echo $this->table->generate();
	
	echo p().form_submit('submit', 'Update Episodes');
	
	echo form_close();