<?php

	class Tracks_Model extends Database_Table {


		function __construct() {

			$this->name = 'tracks';

			parent::__construct();

		}

		public function get_audio($id, $orderby = 'ix') {

			$this->db->select('*');
			$this->db->where('track_id', $id);

			if($orderby == 'ix')
				$this->db->order_by('ix');

			$arr = $this->get_assoc('audio');

			return $arr;

		}

		public function get_chapters($id, $orderby = 'ix') {

			$this->db->select('chapters.id, chapters.track_id, chapters.ix, chapters.length, chapters.startcell');
			$this->db->select('COUNT(episodes.id) AS num_episodes');
			$this->db->join('episodes', 'episodes.track_id = chapters.track_id AND episodes.starting_chapter = chapters.ix AND episodes.ending_chapter = chapters.ix', 'left outer');
			$this->db->where('chapters.track_id', $id);
			$this->db->group_by('chapters.id, chapters.track_id, chapters.ix, chapters.length, chapters.startcell');

			if($orderby == 'ix')
				$this->db->order_by('ix');

			$arr = $this->get_assoc('chapters');

			return $arr;

		}

		public function get_dvd_id($id) {

			$this->db->select('dvd_id');
			$this->db->where('id', $id);

			$var = $this->get_one('tracks');

			return $var;

		}

		public function get_subp($id, $orderby = 'ix') {

			$this->db->select('*');
			$this->db->where('track_id', $id);

			if($orderby == 'ix')
				$this->db->order_by('ix');

			$arr = $this->get_assoc('subp');

			return $arr;

		}

		public function get_cc($id) {

			$this->db->select('closed_captioning');
			$this->db->where('id', $id);

			$arr = $this->get_one('tracks');

			return $arr;

		}

		public function get_track_ix_id($dvd_id, $ix) {

			$this->db->select('id');
			$this->db->where('dvd_id', $dvd_id);
			$this->db->where('ix', $ix);

			$var = $this->get_one('tracks');

			return $var;

		}

	}
