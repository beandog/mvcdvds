<?php

	function media_episode_exists($filename, $media_episode_dirs) {

		foreach($media_episode_dirs as $media_episode_dir) {

			$media_episode_filename = "$media_episode_dir/$filename";

			if(file_exists($media_episode_filename))
				return true;

		}

		return false;

	}

	function media_episode_patterns($media_pattern, $media_episode_dirs) {

		$arr_media_episodes = array();

		foreach($media_episode_dirs as $media_episode_dir) {

			if(is_dir($media_episode_dir))
				$arr_media_episodes = array_merge($arr_media_episodes, scandir($media_episode_dir));

		}

		$media_files = preg_grep($media_pattern, $arr_media_episodes);

		return $media_files;

	}

	function media_episode_filesize($filename, $media_episode_dirs) {

		$filesize = 0;

		foreach($media_episode_dirs as $media_episode_dir) {

			$media_episode_filename = "$media_episode_dir/$filename";

			if(file_exists($media_episode_filename))
				return filesize($media_episode_filename);

		}

		return $filesize;

	}

	function media_episode_filename($episode_nsix, $media_episode_dirs) {

		$arr_filenames = array();

		$arr_filenames[] = "$episode_nsix.mkv";
		// $arr_filenames[] = "$episode_nsix.mp4";

		foreach($media_episode_dirs as $media_episode_dir) {

			foreach($arr_filenames as $filename) {
				$media_filename = "$media_episode_dir/$filename";
				if(file_exists($media_filename))
					return $media_filename;
			}

		}

		return false;

	}
