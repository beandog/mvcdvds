<?

	class Collections_Model extends Database_Table {
	
	
		function __construct() {
			$this->name = 'collections';
			parent::__construct();
		}
		
		public function get_collections() {
		
			$this->db->select('id, title');
			$this->db->order_by('id');
			
			$arr = $this->get_assoc();
			
			return $arr;
		
		}
		
	}