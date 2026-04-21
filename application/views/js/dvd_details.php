<script type="text/javascript">

	function set_series_id(series_dvds_id, series_id) {

		var url = "<?php echo site_url()."/ajax_series_dvds/set_series_id";?>";
		var obj = { series_dvds_id: series_dvds_id, series_id: series_id };

		$.ajax({

			url: url,
			async: false,
			data: obj,
			type: "POST"

		});

	}

</script>
