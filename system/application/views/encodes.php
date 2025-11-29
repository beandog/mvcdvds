<?php

	function seconds_to_hms($duration) {

		$hours = floor($duration / 3600);
		$minutes = floor($duration / 60);
		$seconds = floor($duration % 60);

		$d_hours = str_pad($hours, 2, 0, STR_PAD_LEFT);
		$d_minutes = str_pad($minutes, 2, 0, STR_PAD_LEFT);
		$d_seconds = str_pad($seconds, 2, 0, STR_PAD_LEFT);

		$d_time = "$d_minutes:$d_seconds";
		if($hours)
			$d_time = "$d_hours:$d_time";

		return $d_time;

	}

	$img_dvd = img(array('src' => "images/icons/dvd.png", 'class' => 'handle'));
	$img_episode = img(array('src' => "images/icons/application_view_gallery.png", 'class' => 'handle'));

	$header = array(
		'',
		'Filename',
		'Application',
		'Preset',
		'CRF',
		'Duration',
		'Encoded',
		'Video',
		'Audio',
		'Subs',
		'Filesize',
		'Media',
	);

	$this->table->set_heading($header);

	foreach($encodes as $row) {

		extract($row);

		$arr = explode('.', $filename);
		$collection_id = $arr[0];
		$series_id = intval($arr[1]);
		$dvd_id = intval($arr[2]);

		$d_application = $application;
		$d_episode_mbs = number_format($episode_mbs);
		$d_episode_mbs .= " MBs";
		$d_encoded_date = '';
		$d_duration = seconds_to_hms($duration);

		$d_dvd = "<center>".anchor("dvds/episodes/$dvd_id", $img_dvd)."</center>";
		$d_filename = anchor("dvds/episodes/$dvd_id", $filename);
		$d_episode_info = "<center>".anchor("episodes/index/$episode_id", $img_episode)."</center>";

		$d_vcodec = "<center>$vcodec</center>";
		$d_acodec = "<center>$acodec</center>";
		$d_scodec = "<center>$scodec</center>";

		$a_app = '';
		if(strstr($application, 'HandBrake')) {
			$arr = explode(' ', $application);
			$d_application = "${arr[0]} ${arr[1]}";
			$app = 'handbrake';
			$a_app = anchor('encodes/app/handbrake', $d_application);
		} elseif(strstr($application, 'mkvmerge')) {
			$arr = explode(' ', $application);
			$d_application = "${arr[0]} ${arr[1]}";
			$app = 'mkvmerge';
			$a_app = anchor('encodes/app/mkvmerge', $d_application);
		} elseif(strstr($application, 'Lavf')) {
			$app = 'ffmpeg';
			$a_app = anchor('encodes/app/ffmpeg', 'ffmpeg');
			$d_application = 'ffmpeg';
		}
		if($encoded_date)
			$d_encoded_date = date('Y-m-d', strtotime($encoded_date));

		$table_row = array(

			$d_dvd,
			$d_filename,
			$d_application,
			$x264_preset,
			$x264_crf,
			$d_duration,
			$d_encoded_date,
			$d_vcodec,
			$d_acodec,
			$d_scodec,
			$d_episode_mbs,
			$d_episode_info,

		);

		$this->table->add_row($table_row);

	}

	$tmpl = array(
		'table_open' => '<table border="0" cellpadding="4" cellspacing="0" class="zebra">',
	);

	$this->table->set_template($tmpl);

	echo $this->table->generate();
	$this->table->clear();

