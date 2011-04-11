<script type="text/javascript">

	function new_episode(track_id) {
		
		var url = <?=anchor("ajax_tracks/new_episode");?> + "/" + track_id;
		
		$.ajax(url);
	
	}
	
	function make_episodes() {
	
		$('span[track_id][valid=1]').each(function(i, x) {
				var track_id = $(x).attr('track_id');
				new_episode(track_id)
				plus_one_html($('span[name=num_episodes][track_id=' + track_id + ']'));
		});
	
	}
	
</script>