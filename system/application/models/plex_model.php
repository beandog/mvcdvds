<?php

	class Plex_Model extends Model {

		function get_plex_episode_dirs() {

			$plex_episode_dirs = array(
				'/opt/plex/episodes',
				'/opt/plex/sd',
				'/opt/plex/hd',
				'/opt/plex/tv',
				'/opt/plex/4k',
				'/opt/plex/bd',
			);

			return $plex_episode_dirs;

		}

	}

