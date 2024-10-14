<?php

	function plex_episode_exists($filename, $plex_episode_dirs) {

		foreach($plex_episode_dirs as $plex_episode_dir) {

			$plex_episode_filename = "$plex_episode_dir/$filename";

			if(file_exists($plex_episode_filename))
				return true;

		}

		return false;

	}

	function plex_episode_patterns($plex_pattern, $plex_episode_dirs) {

		$arr_plex_episodes = array();

		foreach($plex_episode_dirs as $plex_episode_dir) {

			$arr_plex_episodes = array_merge($arr_plex_episodes, scandir($plex_episode_dir));

		}

		$plex_files = preg_grep($plex_pattern, $arr_plex_episodes);

		return $plex_files;

	}

	function plex_episode_filesize($filename, $plex_episode_dirs) {

		$filesize = 0;

		foreach($plex_episode_dirs as $plex_episode_dir) {

			$plex_episode_filename = "$plex_episode_dir/$filename";

			if(file_exists($plex_episode_filename))
				return filesize($plex_episode_filename);

		}

		return $filesize;

	}

	function plex_episode_filename($episode_nsix, $plex_episode_dirs) {

		$arr_filenames = array();

		$arr_filenames[] = "$episode_nsix.mkv";
		// $arr_filenames[] = "$episode_nsix.mp4";

		foreach($plex_episode_dirs as $plex_episode_dir) {

			foreach($arr_filenames as $filename) {
				$plex_filename = "$plex_episode_dir/$filename";
				if(file_exists($plex_filename))
					return $plex_filename;
			}

		}

		return false;

	}
