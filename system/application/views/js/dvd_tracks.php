<script type="text/javascript">

	function new_episode(track_id) {
		
		var url = <?=anchor("ajax_tracks/new_episode");?> + "/" + track_id;
		
		$.ajax(url);
	
	}
	
</script>