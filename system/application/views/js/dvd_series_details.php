<script type="text/javascript">

	function set_ix(series_dvds_id, ix) {

		var url = "<?php echo site_url()."/ajax_series_dvds/set_ix";?>";
		var obj = { series_dvds_id: series_dvds_id, ix: ix };

		$.ajax({

			url: url,
			async: false,
			data: obj,
			type: "POST"

		});

	}

	function set_season(series_dvds_id, season) {

		var url = "<?php echo site_url()."/ajax_series_dvds/set_season";?>";
		var obj = { series_dvds_id: series_dvds_id, season: season };

		$.ajax({

			url: url,
			async: false,
			data: obj,
			type: "POST"

		});

	}

	function set_side(series_dvds_id, side) {

		var url = "<?php echo site_url()."/ajax_series_dvds/set_side";?>";
		var obj = { series_dvds_id: series_dvds_id, side: side };

		$.ajax({

			url: url,
			async: false,
			data: obj,
			type: "POST"

		});

	}

	function set_volume(series_dvds_id, volume) {

		var url = "<?php echo site_url()."/ajax_series_dvds/set_volume";?>";
		var obj = { series_dvds_id: series_dvds_id, volume: volume };

		$.ajax({

			url: url,
			async: false,
			data: obj,
			type: "POST"

		});

	}

</script>
