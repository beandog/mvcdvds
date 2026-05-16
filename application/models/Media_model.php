<?php

	class Media_Model extends CI_Model {

		function get_media_episode_dirs() {

			$media_episode_dirs = array(
				'/media/sd',
				'/media/hd',
				'/media/tv',
				'/media/bd',
			);

			return $media_episode_dirs;

		}

	}

