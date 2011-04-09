<?

	class Series_Model extends Database_Table {
	
	
		function __construct() {
		
			$this->name = 'series';
		
			parent::__construct();
			
			
		
		}
		
		public function get_dvds($id, $orderby = null) {
		
			$this->db->select('dvds.*, series_dvds.season, series_dvds.ix, series_dvds.side');
			$this->db->join('series_dvds', 'series_dvds.dvd_id = dvds.id');
			$this->db->where('series_dvds.series_id', $id);
			
			$this->db->order_by('series_dvds.season');
			$this->db->order_by('series_dvds.ix');
			$this->db->order_by('series_dvds.side');
			$this->db->order_by('dvds.title');
			
			$arr = $this->get_assoc('dvds');
			
			return $arr;
		
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
		
		public function get_preset_id($id) {
		
			$this->db->select('preset_id');
			$this->db->where('series_id', $id);
			
			$var = $this->get_one('series_presets');
			
			return $var;
		
		}
		
		public function get_series_dropdown() {
		
			$this->db->select('series.id');
			$this->db->select("collections.title || ': ' || series.title AS title");
			$this->db->join('collections', 'collections.id = series.collection_id');
			$this->db->order_by('collections.title');
			$this->db->order_by('series.title');
			
			$arr = $this->get_assoc();
			
			return $arr;
		
		}
		
		public function set_preset_id($series_id, $preset_id) {
		
			$this->db->where('series_id', $series_id);
			$this->db->delete('series_presets');
			
			$data = array(
				'series_id' => $series_id,
				'preset_id' => $preset_id,
			);
			
			$this->db->insert('series_presets', $data);
		
		}
		
	}