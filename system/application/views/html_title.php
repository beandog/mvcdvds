<?php

	echo "<link rel='icon' type='image/png' href='".base_url()."images/icons/dvd.png'>";
	echo "<title>DVD Media 3.0</title>";

	echo heading("DVD Media", 1);
	echo "<p>";
	echo "<table width='100%'><tr><td>\n";
	echo anchor("/", "Home");
	echo " | ".anchor("presets/", "Presets");
	echo " | ".anchor("bugs/", "Bugs");
	echo " | ".anchor("collections/index/1", "Cartoons");
	echo " | ".anchor("collections/index/2", "TV Shows");
	echo " | ".anchor("collections/index/3", "Church Videos");
	echo " | ".anchor("collections/index/4", "Movies");
	echo " | ".anchor("collections/index/5", "IMAX");
	echo " | ".anchor("collections/index/6", "HDTV");
	echo " | ".anchor("collections/index/7", "Documentary");
	echo " | ".anchor("collections/index/8", "Blu-rays");
	echo " | ".anchor("collections/index/9", "Holidays");
	echo "</td><td align='right'>";
?>
<form action='<?=$this->config->item('base_url').$this->config->item('index_page');?>/welcome/search' method='post'><input type='text' name='q'> <input type='submit' value='Search'></form></td>
</tr>
</table>
