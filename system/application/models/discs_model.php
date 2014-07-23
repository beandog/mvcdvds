<?

	class Discs_Model extends Database_Table {


		function __construct() {

			$this->name = 'discs';

			parent::__construct();

		}

		public function get_collection($id) {

			$this->db->select('collections.id');
			$this->db->join('tv_shows', 'tv_shows.id = discs.tv_show_id');
			$this->db->join('collections', 'collections.id = tv_shows.collection');
			$this->db->where('discs.id', $id);

			$var = $this->get_one();

			return $var;

		}

		public function get_series($id, $orderby = null) {

			$this->db->select('*');
			$this->db->where('tv_show_id', $id);

			if($orderby == 'disc') {
				$this->db->order_by('volume');
				$this->db->order_by('season');
				$this->db->order_by('disc');
				$this->db->order_by('side');
			}

			$arr = $this->get_assoc();

			return $arr;

		}

		public function get_tracks($id, $orderby = 'track') {

			$this->db->select('*');
			$this->db->where('disc', $id);

			if($orderby == 'track')
				$this->db->order_by('track');

			$arr = $this->get_assoc('tracks');

			return $arr;

		}

	}
