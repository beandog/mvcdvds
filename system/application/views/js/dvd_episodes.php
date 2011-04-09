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
</script>