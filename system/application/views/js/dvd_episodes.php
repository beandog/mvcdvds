<style>

	.tr-state-highlight: { border: 1px solid black; }

	.handle: { }

</style>
<script type="text/javascript">
	$(function() {
		$("#sort tbody").sortable({
 			handle: ".handle",
			stop: function() {
				reindex();
			}
		});
	});

	function delete_episode(episode_id, e) {

		var url = "<?php echo site_url()."/ajax_tracks/delete_episode/";?>" + episode_id;

		if(confirm("Delete episode?")) {
			$.ajax(url);
			remove_row(e);
		}

	}

	function reindex() {

		var arr = $('input[ix]');
		arr.each(function(i, e) {
			var ix = (i + 1);
			$(e).attr('ix', ix);
			$(e).val(ix);
		});

	}

	function remove_indexes() {

		var arr = $('input[ix]');
		arr.each(function(i, e) {
			var ix = (i + 1);
			$(e).attr('ix', ix);
			$(e).val("");
		});
	}

</script>
