<?php

	class Presets_Model extends Database_Table {


		function __construct() {
			$this->name = 'presets';
			parent::__construct();
		}

		public function get_presets() {

			$this->db->select('*');
			$this->db->order_by('name');

			$arr = $this->get_assoc();

			return $arr;

		}

		public function get_rippers() {

			$this->db->select('*');
			$this->db->order_by('id');

			$arr = $this->get_assoc('ripping');

			return $arr;

		}

		public function get_series_titles($preset_id = null) {

			$this->db->select('series.id, series.nsix, series.title, series.crf');
			$this->db->join('series_presets', 'series_presets.series_id = series.id');
			$this->db->where('series_presets.preset_id', $preset_id);
			$this->db->order_by('series.collection_id');
			$this->db->order_by('series.title');

			$arr = $this->get_assoc('series');

			return $arr;

		}

		public function get_num_series() {

			$this->db->select('DISTINCT(preset_id), COUNT(series_id)');
			$this->db->group_by('preset_id');
			$this->db->order_by('preset_id');

			$arr = $this->get_assoc('series_presets');

			return $arr;

		}

	}
