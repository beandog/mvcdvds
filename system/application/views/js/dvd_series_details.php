<script type="text/javascript">

	function set_ix(series_dvds_id, ix) {
	
		var url = <?=anchor("ajax_series_dvds/set_ix");?>;
		var obj = { series_dvds_id: series_dvds_id, ix: ix };
		
		$.ajax({
		
			url: url,
			async: false,
			data: obj,
			type: "POST"
		
		});
	
	}

	function set_season(series_dvds_id, season) {
		
		var url = <?=anchor("ajax_series_dvds/set_season");?>;
		var obj = { series_dvds_id: series_dvds_id, season: season };
		
		$.ajax({
		
			url: url,
			async: false,
			data: obj,
			type: "POST"
		
		});
	
	}
	
</script>