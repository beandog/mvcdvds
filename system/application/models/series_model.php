<?

	class Series_Model extends Database_Table {
	
	
		function __construct() {
		
			$this->name = 'series';
		
			parent::__construct();
			
			
		
		}
		
		public function get_dvds($id, $orderby = null) {
		
			$this->db->select('dvds.*, series_dvds.season, series_dvds.volume, series_dvds.ix, series_dvds.side');
			$this->db->join('series_dvds', 'series_dvds.dvd_id = dvds.id');
			$this->db->where('series_dvds.series_id', $id);
			
			$this->db->order_by('series_dvds.season');
			$this->db->order_by('series_dvds.volume');
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
		
		// Find all the DVDs in a collection
		// Additionally, set a 'missing_metadata' boolean if
		// there are values in the dvds table that are null
		public function get_collection($id, $order_by = 'title') {
		
			$this->db->select('series.*');
			$this->db->select('COUNT(dvds.id) AS missing_metadata');
			$this->db->join('series_dvds', 'series_dvds.series_id = series.id', 'left outer');
			$this->db->join('dvds', 'series_dvds.dvd_id = dvds.id AND (dvds.longest_track IS NULL OR dvds.filesize IS NULL)', 'left outer');
			$this->db->group_by('series.id, series.collection_id, series.title, series.production_year, series.production_studio, series.indexed, series.average_length, series.grayscale');
			$this->db->order_by('series.title');
			$this->db->where('series.collection_id', $id);
			
			$arr = $this->get_assoc('series');
			
			return $arr;
		
		}

		// Get the sum of the filesize of all DVDs in the series
		public function get_sum_filesize($id) {
		
			$this->db->select('SUM(dvds.filesize) AS sum_filesize');
			$this->db->join('series_dvds', 'series_dvds.series_id = series.id');
			$this->db->join('dvds', 'dvds.id = series_dvds.dvd_id AND dvds.filesize IS NOT NULL');
			$this->db->where('series.id', $id);

			$var = $this->get_one();

			return $var;

		}
		
		public function get_indexed($id) {
		
			$this->db->select('indexed');
			$this->db->where('id', $id);
			
			$var = $this->get_one();
			
			return $var;
		
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
		
		public function search($q) {
		
			$q = strtolower($q);
			
			$this->db->select('series.*');
			$this->db->select('COUNT(dvds.id) AS missing_index');
			$this->db->join('series_dvds', 'series_dvds.series_id = series.id');
			$this->db->join('dvds', 'series_dvds.dvd_id = dvds.id AND dvds.longest_track IS NULL', 'left outer');
			$this->db->group_by('series.id, series.collection_id, series.title, series.production_year, series.production_studio, series.indexed, series.average_length, series.grayscale');
			$this->db->order_by('series.title');
			$this->db->where('LOWER(series.title) LIKE', "%${q}%");
			
			$arr = $this->get_assoc('series');
			
			return $arr;
		
		}
		
	}
