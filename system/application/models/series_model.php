<?php

	class Series_Model extends Database_Table {


		function __construct() {

			$this->name = 'series';

			parent::__construct();

		}

		public function get_dvds($id, $orderby = null) {

			$this->db->select('dvds.*, series_dvds.season, series_dvds.volume, series_dvds.ix, series_dvds.side');
			$this->db->join('series_dvds', 'series_dvds.dvd_id = dvds.id');
			$this->db->where('series_dvds.series_id', $id);

			$this->db->order_by('dvds.bluray DESC');
			$this->db->order_by('series_dvds.season');
			$this->db->order_by('series_dvds.volume');
			$this->db->order_by('series_dvds.ix');
			$this->db->order_by('series_dvds.side');
			$this->db->order_by('dvds.title');

			$arr = $this->get_assoc('dvds');

			return $arr;

		}

		public function get_tv_shows() {

			$this->db->select('*');
			$this->db->order_by('id');

			$arr = $this->get_assoc();

			return $arr;

		}

		// Find all the DVDs in a collection
		public function get_collection($id, $active = 1) {

			$this->db->select('series.*');
			$this->db->join('series_dvds', 'series_dvds.series_id = series.id', 'left outer');
			$this->db->join('dvds', 'series_dvds.dvd_id = dvds.id', 'left outer');
			$this->db->group_by('series.id, series.collection_id, series.title, series.production_year, series.average_length');
			$this->db->where('series.collection_id', $id);
			$this->db->where('active', $active);
			$this->db->order_by('series.title');

			$arr = $this->get_assoc('series');

			return $arr;

		}

		// Get the sum of the filesize of all DVDs in the series
		public function get_sum_filesize($id) {

			$this->db->select('SUM(dvds.filesize) AS sum_filesize');
			$this->db->join('series_dvds', 'series_dvds.series_id = series.id');
			$this->db->join('dvds', 'dvds.id = series_dvds.dvd_id AND dvds.filesize IS NOT NULL');
			$this->db->where('series.id', $id);

			$var = $this->get_one();

			return $var;

		}

		// Get the total number of DVDs for a series
		public function get_num_dvds($id) {

			$this->db->select('COUNT(dvds.id) AS num_dvds');
			$this->db->join('series_dvds', 'series_dvds.series_id = series.id');
			$this->db->join('dvds', 'dvds.id = series_dvds.dvd_id');
			$this->db->where('series.id', $id);

			$var = $this->get_one();

			return $var;

		}

		// Get the total number of episodes for a series
		public function get_num_episodes($id, $include_skipped = true) {

			$id = abs(intval($id));

			$this->db->select('COUNT(1) AS num_episodes');
			$this->db->where('series_id', $id);
			if(!$include_skipped)
				$this->db->where('episode_skip', 0);

			$var = $this->get_one('view_episodes');

			$var = intval($var);

			return $var;

		}

		// Get the total number of seasons for a series
		public function get_num_seasons($id) {

			$id = abs(intval($id));

			$this->db->select('COUNT(DISTINCT season) AS num_seasons');
			$this->db->where('series_id', $id);
			$var = $this->get_one('series_dvds');

			$var = intval($var);

			return $var;

		}

		// Get the dvd id of any DVDs that have zero episodes on them.
		// Used to check for missing metadata
		public function num_dvds_no_episodes($id) {

			$id = abs(intval($id));

			$sql = "SELECT DISTINCT sd.series_id FROM series_dvds sd LEFT OUTER JOIN view_episodes e ON sd.dvd_id = e.dvd_id WHERE e.episode_id IS NULL AND sd.series_id = $id ORDER BY sd.series_id;";
			$obj = $this->db->query($sql);
			$num_rows = $obj->num_rows();

			return $num_rows;

		}

		public function get_preset_id($id) {

			$this->db->select('preset_id');
			$this->db->where('series_id', $id);

			$var = $this->get_one('series_presets');

			return $var;

		}

		public function get_series_dropdown() {

			$this->db->select('series.id');
			$this->db->select("collections.title || ': ' || series.title AS title");
			$this->db->join('collections', 'collections.id = series.collection_id');
			$this->db->order_by('collections.title');
			$this->db->order_by('series.title');

			$arr = $this->get_assoc();

			return $arr;

		}

		public function get_series_presets() {

			$this->db->select('series_id, preset_id');
			$this->db->order_by('series_id');

			$arr = $this->get_assoc('series_presets');

			return $arr;

		}

		public function set_preset_id($series_id, $preset_id) {

			$this->db->where('series_id', $series_id);
			$this->db->delete('series_presets');

			$data = array(
				'series_id' => $series_id,
				'preset_id' => $preset_id,
			);

			$this->db->insert('series_presets', $data);

		}

		public function search($q) {

			$q = strtolower($q);

			$this->db->select('series.*');
			$this->db->order_by('series.title');
			$this->db->where('LOWER(series.title) LIKE', "%${q}%");
			$this->db->or_where('UPPER(series.nsix) LIKE', strtoupper("%${q}%"));
			$this->db->or_where('series.id =', intval("${q}"));

			$arr = $this->get_assoc('series');

			return $arr;

		}

		/** Check for missing metadata */

		// Find series where some of the episodes have no title
		public function missing_episode_titles($series_id = null) {

			$this->db->select('COUNT(1)');
			$this->db->where("episode_title", "");
			$this->db->where("series_id", $series_id);
			$var = $this->get_one("view_episodes");

			$bool = (bool)$var;

			return $bool;

		}

		// Find episodes where season and episode number are not manually set
		public function missing_episode_numbers($series_id = null) {

			$this->db->select('COUNT(1)');
			$this->db->where("(episode_number IS NULL OR episode_number =  0)");
			$this->db->where("series_id", $series_id);
			$var = $this->get_one("view_episodes");

			$bool = (bool)$var;

			return $bool;

		}

		// Find Blu-rays where dvread_id is legacy value, with 40 or 64 string length instead of 32
		public function legacy_dvdread_id($series_id = null) {

			$this->db->select('COUNT(1)');
			$this->db->join('dvds', 'series_dvds.dvd_id = dvds.id');
			$this->db->where('LENGTH(dvds.dvdread_id) != 32');
			$this->db->where('series_dvds.series_id', $series_id);
			$var = $this->get_one("series_dvds");

			$bool = boolval($var);

			return $bool;

		}

	}
