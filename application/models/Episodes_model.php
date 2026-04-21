<?php

	class Episodes_Model extends Database_Table {

		function __construct() {

			$this->name = 'episodes';

			parent::__construct();

		}

		function get_track_id($id) {

			$this->db->select('track_id');
			$this->db->where('id', $id);

			$var = $this->get_one('episodes');

			return $var;

		}

		function get_dvd_id($id) {

			$this->db->select('dvd_id');
			$this->db->where('id', $id);

			$var = $this->get_one('view_episodes');

			return $var;

		}

		function delete_episode($id) {

			$id = intval($id);

			if(!$id)
				return;

			$sql = "DELETE FROM episodes WHERE id = $id;";

			$this->db->query($sql);

		}

	}
