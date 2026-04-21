<?php

	class Plex_Model extends CI_Model {

		function get_plex_episode_dirs() {

			$plex_episode_dirs = array(
				'/media/sd',
				'/media/hd',
				'/media/tv',
				'/media/bd',
			);

			return $plex_episode_dirs;

		}

	}

