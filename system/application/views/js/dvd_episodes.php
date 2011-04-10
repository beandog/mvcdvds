<style>

	.tr-state-highlight: { border: 1px solid black; }
	
	.handle: { }

</style>
<script type="text/javascript">
	$(function() {
		$("#sort tbody").sortable({
 			handle: ".handle",
			stop: function() {
				var arr = $('input[ix]');
				arr.each(function(i, e) {
					var ix = (i + 1);
					$(e).attr('ix', ix);
					$(e).val(ix);
				});
			}
		});
	});
	
	function delete_episode(episode_id, e) {
	
		var url = <?=anchor("ajax_tracks/delete_episode");?> + "/" + episode_id;
		
		console.log(url);
		
		if(confirm("Delete episode?")) {
			$.ajax(url);
			remove_row(e);
		}
	
	}
	
</script>