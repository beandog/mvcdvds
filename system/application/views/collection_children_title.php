<?php

	echo "<table width='100%'><tr><td>\n";
	foreach($children as $child_id => $child_name) {
		$children_titles[] = anchor("/collections/index/$child_id", $child_name);
	}
	$children_title = implode(" | ", $children_titles);
	echo $children_title;
	echo "</td>";
	echo "</tr>";
	echo "</table>";
	echo "<br>";

?>
