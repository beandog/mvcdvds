<?php

	class Bugs_Model extends Database_Table {

		function __construct() {
			$this->name = 'bugs';
			parent::__construct();
		}

		public function get_bugs() {

			$this->db->select('*');

			$arr = $this->get_all('view_dvd_bugs');

			return $arr;

		}

		public function get_dvd_bugs($id) {

			$this->db->select('dvd_bugs.bug_id, dvd_bugs.id dvd_bugs_id, bugs.name, dvd_bugs.description dvd_description, bugs.description bug_description');
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
