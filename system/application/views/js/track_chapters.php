<script type="text/javascript">

	function new_chapter_episode(track_id, chapter) {
		
		var url = "<?=site_url()."index.php/ajax_tracks/new_chapter_episode";?>";
		var obj = { track_id: track_id, chapter: chapter };
		
		$.ajax({
			url: url,
			data: obj,
			type: "POST"
		});
	
	}
	
	function make_chapter_episodes() {
	
		$('span[track_id][valid=1]').each(function(i, x) {
				var track_id = $(x).attr('track_id');
				var ix = $(x).attr('ix');
				console.log("track_id: " + track_id + " ix: " + ix);
  				new_chapter_episode(track_id, ix);
 				plus_one_html($('span[name=num_episodes][track_id=' + track_id + '][ix='+ix+']'));
		});
	
	}
	
</script>