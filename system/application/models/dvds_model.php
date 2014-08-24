<?

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

		public function get_episodes($id, $orderby = 'episode_ix') {

			$this->db->select('episodes.*, tracks.ix AS track_ix, tracks.id AS track_id');
			$this->db->join('tracks', 'tracks.dvd_id = dvds.id');
			$this->db->join('episodes', 'episodes.track_id = tracks.id');
			$this->db->where('dvds.id', $id);

			$this->db->order_by('episodes.season');
			if($orderby = 'episode_ix')
				$this->db->order_by('episodes.ix');
			$this->db->order_by('tracks.ix');
			$this->db->order_by('episodes.starting_chapter');
			$this->db->order_by('episodes.title');

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

			$this->db->select('tracks.id, tracks.dvd_id, tracks.ix, tracks.length, tracks.format, tracks.aspect');
			$this->db->select("COUNT(episodes.id) AS num_episodes");
			$this->db->join('episodes', 'episodes.track_id = tracks.id', 'left outer');
			$this->db->where('dvd_id', $id);
			$this->db->group_by('tracks.id, tracks.dvd_id, tracks.ix, tracks.length, tracks.format, tracks.aspect');

			if($orderby == 'track')
				$this->db->order_by('ix');

			$arr = $this->get_assoc('tracks');

			return $arr;

		}

		/** Check for missing metadata */

		// Find collections where some of the
		// DVDs are not using the latest metadata spec.
		public function old_metadata_spec($dvd_id) {

			$dvd_id = abs(intval($dvd_id));

			// Find the highest metadata spec in the database
			$this->db->select_max('metadata_spec');
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

	}
