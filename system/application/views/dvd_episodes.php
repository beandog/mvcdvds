<p>
<?
	
	$img_dvd = img(array('src' => "images/icons/dvd.png", 'class' => 'handle'));

	$tbl_heading = array(
		'',
		'Track',
		'ix',
		'Title',
		'Part',
		'Ch.',
		'',
		'Ssn.',
		''
	);
	
	$series_dvds_nav = $this->load->view('series_dvds_nav', array('series_dvds' => $series_dvds), true);
	
	echo heading("Episodes $series_dvds_nav", 4);
	
	if($series['indexed'] == 't') {
		echo anchor("", "Reindex Episodes", "onclick='reindex(); return false;'");
		echo nbs();
		echo anchor("", "Remove Indexes", "onclick='remove_indexes(); return false;'");
		echo p();
	}
	
	echo form_open("dvds/update_episodes/".$dvds['id'], "autocomplete='off' method='post'");
	
	$this->table->set_heading($tbl_heading);
	
	foreach($episodes as $episode_id => $row) {
	
		$img_delete = img(array('src' => "images/icons/delete.png", 'class' => 'pointer', 'onclick' => 'delete_episode('.$episode_id.', this); return false;'));
		
		extract($row);
		
		// Link to track
		$a_track = anchor("tracks/index/$track_id", $img_dvd);
		
		// Track
		$i_track_ix = form_input("episode[$episode_id][track_ix]", $track_ix, "size='2' track_id='$track_id' episode_id='$episode_id'");
		
		// Episode #
		$i_ix = "<input type='text' size='2' name='episode[$episode_id][ix]' value='$ix' ix='$ix' track_id='$track_id' episode_id='$episode_id'>\n";
		
		// Episode Title
		$i_title = form_input("episode[$episode_id][title]", $title, "size='30' track_id='$track_id' episode_id='$episode_id'");
		
		// Episode Part
		$i_part = form_input("episode[$episode_id][part]", $part, "size='2' track_id='$track_id' episode_id='$episode_id'");
		
		// Track chapters
		$i_starting_chapter = form_input("episode[$episode_id][starting_chapter]", $starting_chapter, "size='2' track_id='$track_id' episode_id='$episode_id'");
		$i_ending_chapter = form_input("episode[$episode_id][ending_chapter]", $ending_chapter, "size='2' track_id='$track_id' episode_id='$episode_id'");
		
		// Episode season (override disc)
		$i_season = form_input("episode[$episode_id][season]", $season, "size='2' track_id='$track_id' episode_id='$episode_id'");
		
		$tbl_row = array(
		
			$a_track,
			$i_track_ix,
			$i_ix,
			$i_title,
			$i_part,
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
	$this->table->clear();
	
	echo p().form_submit('submit', 'Update Episodes');
	
	echo form_close();