<?

	class Tracks_Model extends Database_Table {
	
	
		function __construct() {
		
			$this->name = 'tracks';
		
			parent::__construct();
		
		}
		
		public function get_audio($id, $orderby = 'ix') {
		
			$this->db->select('*');
			$this->db->where('track_id', $id);
			
			if($orderby == 'ix')
				$this->db->order_by('ix');
			
			$arr = $this->get_assoc('audio');
			
			return $arr;
		
		}
		
		public function get_chapters($id, $orderby = 'ix') {
		
			$this->db->select('*');
			$this->db->where('track_id', $id);
			
			if($orderby == 'ix')
				$this->db->order_by('ix');
			
			$arr = $this->get_assoc('chapters');
			
			return $arr;
		
		}
		
		public function get_dvd_id($id) {
		
			$this->db->select('dvd_id');
			$this->db->where('id', $id);
			
			$var = $this->get_one('tracks');
			
			return $var;
		
		}
		
		public function get_subp($id, $orderby = 'ix') {
		
			$this->db->select('*');
			$this->db->where('track_id', $id);
			
			if($orderby == 'ix')
				$this->db->order_by('ix');
			
			$arr = $this->get_assoc('subp');
			
			return $arr;
		
		}
		
	}