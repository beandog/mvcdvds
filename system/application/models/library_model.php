<?

	class Library_Model extends Database_Table {


		function __construct() {
			$this->name = 'library';
			parent::__construct();
		}

		public function get_libraries() {

			$this->db->select('*');
			$this->db->order_by('name');

			$arr = $this->get_assoc();

			return $arr;

		}

	}
