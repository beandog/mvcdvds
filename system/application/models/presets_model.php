<?

	class Presets_Model extends Database_Table {
	
	
		function __construct() {
			$this->name = 'presets';
			parent::__construct();
		}
		
		public function get_presets() {
		
			$this->db->select('id, name');
			$this->db->order_by('id');
			
			$arr = $this->get_assoc();
			
			return $arr;
		
		}
		
	}