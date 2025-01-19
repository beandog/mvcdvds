<?php

	class Libraries_Model extends Database_Table {


		function __construct() {
			$this->name = 'libraries';
			parent::__construct();
		}

		public function get_libraries() {

			$this->db->select('*');
			$this->db->order_by('collection_id');
			$this->db->order_by('id');

			$arr = $this->get_assoc();

			return $arr;

		}

	}
