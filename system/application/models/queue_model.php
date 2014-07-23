<?

	class Queue_Model extends Database_Table {


		function __construct() {

			$this->name = 'queue';

			parent::__construct();

		}

		public function delete_episode($episode_id) {

			$this->db->where('episode_id', $episode_id);
			$this->db->delete('queue');

		}

		public function get_queue() {

			$this->db->select('queue.hostname, view_episodes.*');
			$this->db->join('view_episodes', 'view_episodes.episode_id = queue.episode_id');
			$this->db->order_by('queue.priority, queue.insert_date');

			$arr = $this->get_all();

			return $arr;

		}

		public function reset() {

			$this->db->where('id IS NOT NULL');
			$this->db->delete('queue');

		}

	}
