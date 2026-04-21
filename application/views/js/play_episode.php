<script type='text/javascript'>

	function play_episode(episode_url, episode_filename) {

		console.log("Play video " + episode_url);
		$('#episode_filename').text(episode_filename);
		vid = document.getElementById('video');
		// vid.load();
		// vid.play();

		if($('#episode_player').attr('src') == episode_url) {

			if(vid.paused)
				vid.play();
			else
				vid.pause();

		} else {

			$('#episode_player').attr('src', episode_url);
			vid.load();
			vid.play();
			$('#video').removeAttr('hidden');

		}

	}

</script>
