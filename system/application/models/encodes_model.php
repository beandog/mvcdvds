<?php

	class Encodes_Model extends Database_Table {

		function __construct() {
			$this->name = 'bugs';
			parent::__construct();
		}

		public function get_encodes() {

			$this->db->select('*');
			$this->db->where('filename NOT LIKE', '%.HD%');
			$this->db->where('filename NOT LIKE', '%.BD%');
			$this->db->where('filename NOT LIKE', '%.4K%');
			$this->db->order_by('filename');
			$arr = $this->get_assoc('encodes');

			return $arr;

		}

		public function get_app($app) {

			if($app == 'handbrake')
				$q = 'HandBrake';
			elseif($app == 'mkvmerge')
				$q = 'mkvmerge';
			elseif($app == 'ffmpeg')
				$q = 'Lavf';

			$this->db->select('*');
			$this->db->where('application LIKE', "$q%");
			$this->db->where('filename NOT LIKE', '%.HD%');
			$this->db->where('filename NOT LIKE', '%.BD%');
			$this->db->where('filename NOT LIKE', '%.4K%');
			$this->db->order_by('filename');
			$arr = $this->get_assoc('encodes');

			return $arr;

		}

		public function get_preset($q) {

			$this->db->select('*');
			if($q == 'none')
				$this->db->where('x264_preset', null);
			elseif($q == 'medium')
				$this->db->where('x264_preset', 'medium');
			else
				$this->db->where('x264_preset LIKE', "%$q%");
			$this->db->where('filename NOT LIKE', '%.HD%');
			$this->db->where('filename NOT LIKE', '%.BD%');
			$this->db->where('filename NOT LIKE', '%.4K%');
			$this->db->order_by('filename');
			$arr = $this->get_assoc('encodes');

			return $arr;

		}

		public function get_audio($q) {

			$this->db->select('*');
			$this->db->where('acodec LIKE', "%$q%");
			$this->db->where('filename NOT LIKE', '%.HD%');
			$this->db->where('filename NOT LIKE', '%.BD%');
			$this->db->where('filename NOT LIKE', '%.4K%');
			$this->db->order_by('filename');
			$arr = $this->get_assoc('encodes');

			return $arr;

		}

		public function get_subs($q) {

			$this->db->select('*');
			$this->db->where('scodec LIKE', "%$q%");
			$this->db->where('filename NOT LIKE', '%.HD%');
			$this->db->where('filename NOT LIKE', '%.BD%');
			$this->db->where('filename NOT LIKE', '%.4K%');
			$this->db->order_by('filename');
			$arr = $this->get_assoc('encodes');

			return $arr;

		}

		public function get_series($series_id) {

			$series_id = intval($series_id);

			$sql = "SELECT e.*, ve.series_id, ve.series_title, ve.episode_title, ve.episode_part, ve.episode_season, ve.episode_number FROM encodes e LEFT OUTER JOIN view_episodes ve ON e.episode_id = ve.episode_id WHERE ve.series_id = $series_id;";

			$arr_assoc = array();
			$obj = $this->db->query($sql);
			foreach($obj->result_array() as $arr) {
				$arr_assoc[] = $arr;
			}

			return $arr_assoc;

		}

		public function get_dvd($dvd_id) {

			$dvd_id = intval($dvd_id);

			$sql = "SELECT e.*, ve.series_id, ve.series_title, ve.episode_title, ve.episode_part, ve.episode_season, ve.episode_number FROM encodes e LEFT OUTER JOIN view_episodes ve ON e.episode_id = ve.episode_id WHERE ve.dvd_id = $dvd_id;";

			$arr_assoc = array();
			$obj = $this->db->query($sql);
			foreach($obj->result_array() as $arr) {
				$arr_assoc[] = $arr;
			}

			return $arr_assoc;

		}

	}
