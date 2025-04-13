<?php

	class Bugs_Model extends Database_Table {

		function __construct() {
			$this->name = 'bugs';
			parent::__construct();
		}

		public function get_bugs() {

			$sql = "SELECT DISTINCT d.id AS dvd_id, s.collection_id, s.id AS series_id, s.production_year, (((s.collection_id || '.'::text) || to_char(s.id, 'FM000'::text)) || '.'::text) || to_char(d.id, 'FM0000'::text) AS dvd_nsix_iso, s.nsix, s.active, d.bluray, sd.season, sd.volume, sd.side, s.title AS series_title, d.title AS dvd_title FROM dvd_bugs db JOIN dvds d ON d.id = db.dvd_id JOIN series_dvds sd ON sd.dvd_id = d.id JOIN series s ON s.id = sd.series_id ORDER BY s.collection_id, s.id, s.title, sd.season, sd.volume, sd.side, d.title;";

			$arr_assoc = array();
			$obj = $this->db->query($sql);
			foreach($obj->result_array() as $arr) {
				$arr_assoc[] = $arr;
			}

			return $arr_assoc;

		}

		public function get_dvd_bugs($id) {

			$this->db->select('dvd_bugs.bug_id, dvd_bugs.id dvd_bugs_id, bugs.name, bugs.description bug_description');
			$this->db->join('bugs', 'bugs.id = dvd_bugs.bug_id');
			$this->db->where('dvd_bugs.dvd_id', $id);
			$this->db->orderby('bugs.name');

			$arr = $this->get_assoc('dvd_bugs');

			return $arr;

		}

		public function get_bugs_details() {

			$this->db->select('*');
			$this->db->orderby('disc, name');

			$arr = $this->get_assoc('bugs');

			return $arr;

		}

		public function get_dvd_title($dvd_id) {

			$this->db->select('title');
			$this->db->where('id', $dvd_id);

			$var = $this->get_one('dvds');

			return $var;

		}

		public function get_dvd_notes($dvd_id) {

			$this->db->select('notes');
			$this->db->where('id', $dvd_id);

			$var = $this->get_one('dvds');

			return $var;

		}

		public function get_series_nsix($series_id) {

			$this->db->select('nsix');
			$this->db->where('id', $series_id);

			$var = $this->get_one('series');

			return $var;

		}

		public function get_series_title($series_id) {

			$this->db->select('title');
			$this->db->where('id', $series_id);

			$var = $this->get_one('series');

			return $var;

		}

		public function get_series_notes($series_id) {

			$this->db->select('qa_notes');
			$this->db->where('id', $series_id);

			$var = $this->get_one('series');

			return $var;

		}

		public function set_dvd_notes($dvd_id, $notes) {

			$this->db->where('id', $dvd_id);
			$this->db_delete('notes');

			$data = array(
				'notes' => $notes
			);

			$this->db->insert('dvds', $data);

		}

	}
