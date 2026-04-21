<script type='text/javascript'>

	function plus_one(e) {
	
		var i = $(e).val();
		
		if(i.length === 0) {
			$(e).val(1);
		} else {
			$(e).val(parseInt(i) + 1);
		}
			
	}
	
	function minus_one(e) {
	
		var i = $(e).val();
		
		if(i === "1") {
			$(e).val("");
		} else if(parseInt(i) > 0) {
			$(e).val(parseInt(i) - 1);
		}
	
	}
	
	function plus_one_html(e) {
	
		var i = $(e).html();
		
		if(i.length === 0) {
			$(e).html(1);
		} else {
			$(e).html(parseInt(i) + 1);
		}
	
	}

</script>