<?php

	class Queue_Model extends Database_Table {


		function __construct() {

			$this->name = 'queue';

			parent::__construct();

		}

		public function delete_episode($queue_id) {

			$queue_id = abs(intval($queue_id));

			if($queue_id) {
				$this->db->where('id', $queue_id);
				$this->db->delete('queue');
			}

		}

		public function delete_series($series_id) {

			$series_id = abs(intval($series_id));

			if($series_id) {
				$arr_queue = $this->get_queue($series_id);

				foreach($arr_queue as $arr) {

					$this->delete_episode($arr['queue_id']);

				}
			}

		}

		public function get_queue($series_id = null) {

			if(!is_null($series_id))
				$series_id = abs(intval($series_id));

			$this->db->select('queue.id AS queue_id, queue.hostname, view_episodes.*, queue.x264, queue.xml, queue.mkv');
			$this->db->join('view_episodes', 'view_episodes.episode_id = queue.episode_id');
			if($series_id)
				$this->db->where('view_episodes.series_id', $series_id);
			$this->db->order_by('queue.x264 DESC, queue.xml DESC, queue.mkv DESC, queue.insert_date');

			$arr = $this->get_all();

			return $arr;

		}

		public function get_series() {

			$this->db->select('series_id, series_title');
			$this->db->distinct();
			$this->db->join('view_episodes', 'view_episodes.episode_id = queue.episode_id');

			$arr = $this->get_all('queue');

			return $arr;

		}

		public function reset() {

			$this->db->where('id IS NOT NULL');
			$this->db->delete('queue');

		}

	}
