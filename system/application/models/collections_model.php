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
