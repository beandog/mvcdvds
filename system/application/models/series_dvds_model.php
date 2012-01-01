<?

	class Series_Dvds_Model extends Database_Table {
	
	
		function __construct() {
		
			$this->name = 'series_dvds';
		
			parent::__construct();
		
		}
		
		public function delete_dvd($dvd_id) {
		
			$this->db->where('dvd_id', $dvd_id);
			$this->db->delete('series_dvds');
			
		}
		
		public function get_dvd_data($dvd_id) {
		
			$this->db->select('*');
			$this->db->where('dvd_id', $dvd_id);
			
			$arr = $this->get_row();
			
			return $arr;
		
		}
		
		public function load_dvd($dvd_id) {
		
			$this->db->select('id');
			$this->db->where('dvd_id', $dvd_id);
			
			$id = $this->get_one();
			
			$this->load($id);
		
		}
		
		
		
	}