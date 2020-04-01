<?php

	class Collections_Model extends Database_Table {


		function __construct() {
			$this->name = 'collections';
			parent::__construct();
		}

		public function get_collections() {

			$this->db->select('id, title');
			$this->db->order_by('id');

			$arr = $this->get_assoc();

			return $arr;

		}

		public function get_libraries($collection_id) {

			$this->db->select('id, name');
			$this->db->where('collection_id', $collection_id);
			$this->db->order_by('name');

			$arr = $this->get_assoc('libraries');

			return $arr;

		}

		public function collection_series_data($id) {

			$this->db->select('series.id AS series_id, SUM(dvds.filesize) AS sum_filesize, COUNT(dvds.id) AS num_dvds');
			$this->db->join('series_dvds', 'series_dvds.series_id = series.id');
			$this->db->join('dvds', 'dvds.id = series_dvds.dvd_id');
			$this->db->where('series.collection_id', $id);
			$this->db->where('series.active', 1);
			$this->db->group_by('series.id');

			$arr = $this->get_assoc('series');

			return $arr;

		}

		public function get_unarchived_series($collection_id) {

			$this->db->select('series.id, series.title');
			$this->db->join('series_dvds', 'series_dvds.series_id = series.id');
			$this->db->join('dvds', 'dvds.id = series_dvds.dvd_id');
			$this->db->where('series.collection_id', $collection_id);
			$this->db->where('dvds.longest_track', null);
			$this->db->order_by('series.title');
			$this->db->distinct();

			$arr = $this->get_all('series');

			return $arr;

		}

	}
