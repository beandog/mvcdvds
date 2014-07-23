<?

	class Episodes_Model extends Database_Table {


		function __construct() {

			$this->name = 'episodes';

			parent::__construct();

		}

		function get_track_id($episode_id) {

			$this->db->select('track_id');
			$this->db->where('id', $episode_id);

			$var = $this->get_one('episodes');

			return $var;

		}

	}
