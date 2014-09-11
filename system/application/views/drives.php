<?php

	echo heading("Disc Drives");

	$arr[] = anchor("#", "Import DVD", "onclick='import_dvd(); return false'");
	$arr[] = anchor("#", "Eject", "onclick='eject(); return false'");

	echo ul($arr);
