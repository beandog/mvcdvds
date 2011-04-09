<?

	class Tracks_Model extends Database_Table {
	
	
		function __construct() {
		
			$this->name = 'tracks';
		
			parent::__construct();
		
		}
		
		public function get_chapters($id, $orderby = 'ix') {
		
			$this->db->select('*');
			$this->db->where('track_id', $id);
			
			if($orderby == 'ix')
				$this->db->order_by('ix');
			
			$arr = $this->get_assoc('chapters');
			
			return $arr;
		
		}
		
	}