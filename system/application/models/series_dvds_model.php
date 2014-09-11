<?php

	class Series_Dvds_Model extends Database_Table {


		function __construct() {

			$this->name = 'series_dvds';

			parent::__construct();

		}

		public function delete_dvd($dvd_id) {

			$this->db->where('dvd_id', $dvd_id);
			$this->db->delete('series_dvds');

		}

		public function get_dvd_data($dvd_id) {

			$this->db->select('*');
			$this->db->where('dvd_id', $dvd_id);

			$arr = $this->get_row();

			return $arr;

		}

		public function load_dvd($dvd_id) {

			$this->db->select('id');
			$this->db->where('dvd_id', $dvd_id);

			$id = $this->get_one();

			$this->load($id);

		}

		/**
		 * Calculate the total filesize that a series would use for all
		 * the episodes in the database with its current preset.
		 *
		 * To calculate the total, the formula is:
		 *
		 * ( (# seconds of video) * (video bitrate + audio bitrate) ) / 1024 / 8
		 *
		 * This returns the number of megabytes it will use.
		 *
		 * Without a series_id variable passed, it will return the amount for all
		 * the series in the database.  Otherwise, only for that one series.
		 *
		 * I spent *a lot* of time getting this query working, so don't screw with it.
		 * The difficulty is that the only way to see if a track's length should be included
		 * is if an episode is attached to it.  This makes selecting DISTINCT rows difficult
		 * because there are situations where one track has multiple episodes, or one track
		 * is just one episode.  Writing sub-queries fixed it, even if I don't enjoy using
		 * that approach.  However, don't waste time rewriting it.  The closest I could get
		 * was functions that would drag on forever.
		 */
		public function get_encoded_series_preset_filesize($series_id = null) {

			$sql_select_series = "";

			$series_id = abs(intval($series_id));

			if($series_id)
				$sql_select_series = " WHERE series_id = $series_id";

			$sql = "SELECT series_id, total_seconds, total_bitrate, ((total_seconds * total_bitrate) / 8192) AS megabytes FROM (SELECT dvd_tracks.series_id, SUM(track_length) AS total_seconds, (p.acodec_bitrate + p.video_bitrate) AS total_bitrate FROM (SELECT DISTINCT sd.series_id AS series_id, d.id AS dvd_id, t.id AS track_id, t.ix AS track_ix, t.length AS track_length FROM dvds d JOIN tracks t ON t.dvd_id = d.id LEFT OUTER JOIN episodes e ON e.track_id = t.id JOIN series_dvds sd ON d.id = sd.dvd_id WHERE e.id IS NOT NULL) AS dvd_tracks JOIN series_presets sp ON sp.series_id = dvd_tracks.series_id JOIN presets p ON sp.preset_id = p.id GROUP BY dvd_tracks.series_id, total_bitrate ORDER BY dvd_tracks.series_id) AS series_bitrates $sql_select_series;";

			// At the time of writing, it's been a long time since I wrote queries
			// using the CodeIgniter syntax.  Because of that and the complexity
			// of this query, I'm simply building the associative array myself.
			$arr_assoc = array();
			$obj = $this->db->query($sql);
			foreach($obj->result_array() as $arr) {
				$series_id = array_shift($arr);
				$arr_assoc[$series_id] = $arr;
			}

			return $arr_assoc;

		}

	}
