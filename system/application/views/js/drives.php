<script type="text/javascript">

	function eject() {
	
		var url = <?=anchor("ajax_drives/eject");?>;
		
		$.ajax(url);
	
	}

	function import_dvd() {
	
		var url = <?=anchor("ajax_drives/import_dvd");?>;
		
		$.ajax(url);
	
	}

</script>