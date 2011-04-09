<script type="text/javascript">

	function new_episode(track_id) {
		
		var url = <?=anchor("dvds/new_episode");?> + "/" + track_id;
		
		$.ajax(url);
	
	}

</script>