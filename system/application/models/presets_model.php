<?

	class Presets_Model extends Database_Table {
	
	
		function __construct() {
			$this->name = 'presets';
			parent::__construct();
		}
		
		public function get_presets() {
		
			$this->db->select('id, name');
			$this->db->where('base_preset > \'\'');
			$this->db->order_by('name');
			
			$arr = $this->get_assoc();
			
			return $arr;
		
		}
		
		public function get_base_presets() {
		
			$this->db->select('id, name');
			$this->db->where('base_preset', '');
			$this->db->order_by('name');
			
			$arr = $this->get_assoc();
			
			return $arr;	
		
		}
		
	}