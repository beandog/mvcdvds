<?php

	class Dvds_Model extends Database_Table {


		function __construct() {

			$this->name = 'dvds';

			parent::__construct();

		}

		public function get_collection_id($id) {

			$this->db->select('series.collection_id');
			$this->db->join('series_dvds', 'series_dvds.dvd_id = dvds.id');
			$this->db->join('series', 'series.id = series_dvds.series_id');
			$this->db->where('series_dvds.dvd_id', $id);

			$var = $this->get_one();

			return $var;

		}

		public function get_episodes($id, $orderby = 'episode_ix', $include_skipped = true) {

			$this->db->select('episodes.*, tracks.ix AS track_ix, tracks.id AS track_id');
			$this->db->join('tracks', 'tracks.dvd_id = dvds.id');
			$this->db->join('episodes', 'episodes.track_id = tracks.id');
			$this->db->where('dvds.id', $id);
			if(!$include_skipped)
				$this->db->where('episodes.skip', 0);

			$this->db->order_by('episodes.season');
			if($orderby = 'episode_ix')
				$this->db->order_by('episodes.ix');
			$this->db->order_by('tracks.ix');
			$this->db->order_by('episodes.starting_chapter');
			$this->db->order_by('episodes.id');

			$arr = $this->get_assoc();

			return $arr;

		}

		public function get_last_episode_ix($dvd_id) {

			$this->db->select('MAX(episodes.ix)');
			$this->db->join('episodes', 'episodes.track_id = tracks.id');
			$this->db->where('tracks.dvd_id', $dvd_id);

			$var = $this->get_one('tracks');

			return $var;

		}

		public function get_last_track_ix($dvd_id) {

			$this->db->select('MAX(tracks.ix)');
			$this->db->join('episodes', 'episodes.track_id = tracks.id');
			$this->db->where('tracks.dvd_id', $dvd_id);

			$var = $this->get_one('tracks');

			return $var;

		}

		public function get_new_dvds() {

			$this->db->select('dvds.*');
			$this->db->join('series_dvds', "series_dvds.dvd_id = dvds.id", 'left');
			$this->db->where('series_dvds.id', null);
			$this->db->order_by('dvds.id');

			$arr = $this->get_assoc();

			return $arr;

		}

		public function get_series_id($id) {

			$this->db->select('series_dvds.series_id');
			$this->db->join('series_dvds', 'series_dvds.dvd_id = dvds.id');
			$this->db->join('series', 'series.id = series_dvds.series_id');
			$this->db->where('series_dvds.dvd_id', $id);

			$var = $this->get_one();

			return $var;

		}

		public function get_tracks($id, $orderby = 'track') {

			$this->db->select('tracks.id, tracks.dvd_id, tracks.ix, tracks.codec, tracks.length, tracks.format, tracks.aspect, tracks.closed_captioning, tracks.vts, tracks.audio_ix, tracks.filesize');
			$this->db->select("COUNT(DISTINCT episodes.id) AS num_episodes");
			$this->db->select("COUNT(subp.id) AS num_eng_subp");
			$this->db->join('episodes', 'episodes.track_id = tracks.id', 'left outer');
			$this->db->join('subp', 'subp.track_id = tracks.id AND subp.langcode = \'en\' AND subp.active = 1', 'left outer');
			$this->db->where('dvd_id', $id);
			$this->db->group_by('tracks.id, tracks.dvd_id, tracks.ix, tracks.length, tracks.codec, tracks.format, tracks.aspect, tracks.filesize');

			if($orderby == 'track')
				$this->db->order_by('ix');

			$arr = $this->get_assoc('tracks');

			return $arr;

		}

		public function get_bluray_disc_title($id) {

			 $this->db->select('disc_title');
			 $this->db->where('dvd_id', $id);

			 $var = $this->get_one('blurays');

			 return $var;

		}

		public function get_bugs($id, $disc_type = 0) {

			$this->db->select('bugs.id');
			$this->db->select('bugs.disc');
			$this->db->select('bugs.name');
			$this->db->select('dvd_bugs.dvd_id');
			$this->db->join('dvd_bugs', "dvd_bugs.bug_id = bugs.id AND dvd_bugs.dvd_id = $id", 'left');
			$this->db->where("bugs.disc = $disc_type");
			$this->db->order_by('bugs.name');

			$arr = $this->get_all('bugs');

			return $arr;

		}

		public function enable_bug($id, $bug_id) {

			$this->db->select('id');
			$this->db->where('dvd_id', $id);
			$this->db->where('bug_id', $bug_id);

			$dvd_bug_id = $this->get_one('dvd_bugs');

			if($dvd_bug_id)
				return;

			$data = array(
				'dvd_id' => $id,
				'bug_id' => $bug_id,
			);

			$this->db->insert('dvd_bugs', $data);

		}

		public function disable_bug($id, $bug_id) {

			$this->db->where('dvd_id', $id);
			$this->db->where('bug_id', $bug_id);
			$this->db->delete('dvd_bugs');

		}

		/** Check for missing metadata */

		// Find collections where some of the
		// DVDs are not using the latest metadata spec.
		public function old_metadata_spec($dvd_id, $disc_type = 'dvd') {

			$dvd_id = abs(intval($dvd_id));

			// Find the highest metadata spec in the database
			$this->db->select_max('metadata_spec');
			if($disc_type == 'dvd')
				$this->db->where('bluray', 0);
			if($disc_type == 'bluray')
				$this->db->where('bluray', 1);
			$newest_spec = abs(intval($this->get_one('dvds')));

			$this->db->select("metadata_spec");
			$this->db->where("id", $dvd_id);
			$current_spec = abs(intval($this->get_one('dvds')));

			// Differences between spec v.3 and 2 and similar enough not to warrant
			// a notice.
			if($newest_spec === $current_spec || ($newest_spec == 3 && $current_spec == 2))
				return false;
			else
				return true;

		}

		// Find series where some of the episodes have no title
		public function missing_episode_titles($id) {

			$this->db->select('COUNT(1)');
			$this->db->where("episode_title", "");
			$this->db->where("dvd_id", $id);
			$var = $this->get_one("view_episodes");

			$bool = (bool)$var;

			return $bool;

		}

		// Find series where some of the episode numbers aren't set manually
		public function missing_episode_numbers($id) {

			$this->db->select('COUNT(1)');
			$this->db->where("(episode_number IS NULL OR episode_number = 0)");
			$this->db->where("dvd_id", $id);
			$var = $this->get_one("view_episodes");

			$bool = (bool)$var;

			return $bool;

		}

		// Find series where some of the episodes have no filesize
		public function missing_filesize($id) {

			$this->db->select('filesize');
			$this->db->where("id", $id);
			$var = $this->get_one("dvds");

			$var = abs(intval($var));

			if(!$var)
				return true;
			else
				return false;

		}

		// Find where no tracks have any audio tracks
		public function missing_audio_tracks($id) {

			$this->db->select('COUNT(1)');
			$this->db->join('tracks', 'audio.track_id = tracks.id', 'left outer');
			$this->db->where('tracks.dvd_id', $id);
			$var = intval($this->get_one('audio'));

			if($var)
				return false;
			else
				return true;

		}

		// Find DVDs where some of the episodes have not been scanned for PTS info
		public function missing_pts($id) {

			$this->db->select('COUNT(1)');
			$this->db->where("progressive", null);
			$this->db->where("dvd_id", $id);
			$this->db->where("episode_skip", 0);
			$var = $this->get_one("view_episodes");

			if($var)
				return true;

			$this->db->select('COUNT(1)');
			$this->db->where("progressive", 0);
			$this->db->where("top_field", 0);
			$this->db->where("bottom_field", 0);
			$this->db->where("dvd_id", $id);
			$this->db->where("episode_skip", 0);
			$var = $this->get_one("view_episodes");

			if($var)
				return true;

			return false;

		}

		// Find if DVD has any documented bugs
		public function has_bugs($id) {

			$this->db->select('dvd_id');
			$this->db->where('dvd_id', $id);
			$var = $this->get_one('dvd_bugs');

			if($var)
				return true;
			else
				return false;

		}

	}
