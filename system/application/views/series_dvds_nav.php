<?php

	$array_keys = array_keys($series_dvds);
	$index = array_search($dvd_id, $array_keys);
	$current_disc_number = $index + 1;
	$num_series_dvds = count($series_dvds);

	$current_disc_number = str_pad($current_disc_number, strlen($num_series_dvds), 0, STR_PAD_LEFT);

	$nav = array();

 	if($index > 0)
 		$nav[] = anchor("dvds/".$this->uri->segment(2)."/".$array_keys[($index - 1)], img("images/icons/control_rewind_blue.png"));
 	else
 		$nav[] = img("images/icons/control_rewind.png");
 	if($index < ($num_series_dvds - 1))
 		$nav[] = anchor("dvds/".$this->uri->segment(2)."/".$array_keys[($index + 1)], img("images/icons/control_fastforward_blue.png"));
 	else
 		$nav[] = img("images/icons/control_fastforward.png");

 	echo "[Disc $current_disc_number/$num_series_dvds] ".implode(nbs(2), $nav);
