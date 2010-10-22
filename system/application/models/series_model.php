<?

	class Series_Model extends Database_Table {
	
	
		function __construct() {
		
			$this->name = 'series';
		
			parent::__construct();
			
			
		
		}
		
		public function get_tv_shows() {
		
			$this->db->select('*');
			$this->db->order_by('id');
			
			$arr = $this->get_assoc();
			
			return $arr;
		
		}
		
		public function get_collection($id, $order_by = 'title') {
		
			$this->db->select('*');
			$this->db->order_by('title');
			$this->db->where('collection_id', $id);
			
			$arr = $this->get_assoc();
			
			return $arr;
		
		}
		
	}