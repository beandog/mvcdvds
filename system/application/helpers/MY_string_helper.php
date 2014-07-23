<?

	/**
	* print_r() formatted nicely
	*
	* Intended for HTML output.  Sandwiches the output between <pre> tags.
	*
	* @param mixed $var
	*/
	function pre($var, $header = false, $sort = true) {
		if($header)
			echo "<p><b>$header</b></p>\n";
		echo "<pre>\n";
		if($sort == true && is_array($var))
			ksort($var);
		if(is_array($var) || is_object($var))
		{
			print_r($var);
		}
		else {
			$var = htmlentities($var);
			print_r($var);
		}
		echo "</pre>\n";
	}

	function pg_bool($str) {

		if($str == 't')
			return true;
		else
			return false;

	}

	function bool_pg($bool) {

		if($bool)
			return 't';
		else
			return 'f';

	}

	function pg_null($str) {

		if(empty($str))
			return null;
		else
			return $str;

	}

	function p($int = 1) {

		$str = "<p>\n";
		$str = str_repeat($str, $int);

		return $str;

	}
