<?php

	class Plex_Model extends Model {

		function get_plex_episode_dirs() {

			$plex_episode_dirs = array(
				'/opt/plex/episodes',
				'/opt/plex/sd',
				'/opt/plex/hd',
			);

			return $plex_episode_dirs;

		}

	}

