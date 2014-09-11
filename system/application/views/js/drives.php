<script type="text/javascript">

	function eject() {

		var url = "<?php echo site_url()."index.php/ajax_drives/eject";?>";

		$.ajax(url);

	}

	function import_dvd() {

		var url = "<?php echo site_url()."ajax_drives/import_dvd";?>";

		$.ajax(url);

	}

</script>
