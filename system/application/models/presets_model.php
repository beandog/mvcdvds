<?

	class Presets_Model extends Database_Table {


		function __construct() {
			$this->name = 'presets';
			parent::__construct();
		}

		public function get_presets() {

			$this->db->select('*');
			$this->db->order_by('name');

			$arr = $this->get_all();

			return $arr;

		}

	}
