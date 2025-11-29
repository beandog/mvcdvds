<?php

	class Encodes_Model extends Database_Table {

		function __construct() {
			$this->name = 'bugs';
			parent::__construct();
		}

		public function get_encodes() {

			$this->db->select('*');
			$this->db->order_by('filename');
			$arr = $this->get_assoc('encodes');

			return $arr;

		}

	}
