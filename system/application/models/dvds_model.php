<?

	class Dvds_Model extends Database_Table {
	
	
		function __construct() {
		
			$this->name = 'dvds';
		
			parent::__construct();
		
		}
		
		public function get_collection_id($id) {
		
			$this->db->select('series.collection_id');
			$this->db->join('series_dvds', 'series_dvds.dvd_id = dvds.id');
			$this->db->join('series', 'series.id = series_dvds.series_id');
			$this->db->where('series_dvds.dvd_id', $id);
			
			$var = $this->get_one();
			
			return $var;
		
		}
		
		public function get_episodes($id, $orderby = 'episode_ix') {
		
			$this->db->select('episodes.*, tracks.ix AS track_ix, tracks.id AS track_id');
			$this->db->join('tracks', 'tracks.dvd_id = dvds.id');
			$this->db->join('episodes', 'episodes.track_id = tracks.id');
			$this->db->where('dvds.id', $id);
			
			$this->db->order_by('episodes.season');
			if($orderby = 'episode_ix')
				$this->db->order_by('episodes.ix');
			$this->db->order_by('tracks.ix');
			$this->db->order_by('episodes.starting_chapter');
			$this->db->order_by('episodes.title');
			
			$arr = $this->get_assoc();
			
			return $arr;
		
		}
		
		public function get_last_episode_ix($dvd_id) {
		
			$this->db->select('MAX(episodes.ix)');
			$this->db->join('episodes', 'episodes.track_id = tracks.id');
			$this->db->where('tracks.dvd_id', $dvd_id);
			
			$var = $this->get_one('tracks');
			
			return $var;
		
		}
		
		public function get_last_track_ix($dvd_id) {
		
			$this->db->select('MAX(tracks.ix)');
			$this->db->join('episodes', 'episodes.track_id = tracks.id');
			$this->db->where('tracks.dvd_id', $dvd_id);
			
			$var = $this->get_one('tracks');
			
			return $var;
		
		}
		
		public function get_new_dvds() {
		
			$this->db->select('dvds.*');
			$this->db->join('series_dvds', "series_dvds.dvd_id = dvds.id", 'left');
			$this->db->where('series_dvds.id', null);
			$this->db->order_by('dvds.id');
			
			$arr = $this->get_assoc();
			
			return $arr;
		
		}
		
		public function get_series_id($id) {
		
			$this->db->select('series_dvds.series_id');
			$this->db->join('series_dvds', 'series_dvds.dvd_id = dvds.id');
			$this->db->join('series', 'series.id = series_dvds.series_id');
			$this->db->where('series_dvds.dvd_id', $id);
			
			$var = $this->get_one();
			
			return $var;
		
		}
		
		public function get_tracks($id, $orderby = 'track') {
		
			$this->db->select('tracks.id, tracks.dvd_id, tracks.ix, tracks.length, tracks.vts_id, tracks.vts, tracks.ttn, tracks.fps, tracks.format, tracks.aspect, tracks.width, tracks.height, tracks.df, tracks.angles');
			$this->db->select("COUNT(episodes.id) AS num_episodes");
			$this->db->join('episodes', 'episodes.track_id = tracks.id', 'left outer');
			$this->db->where('dvd_id', $id);
			$this->db->group_by('tracks.id, tracks.dvd_id, tracks.ix, tracks.length, tracks.vts_id, tracks.vts, tracks.ttn, tracks.fps, tracks.format, tracks.aspect, tracks.width, tracks.height, tracks.df, tracks.angles');
			
			if($orderby == 'track')
				$this->db->order_by('ix');
			
			$arr = $this->get_assoc('tracks');
			
			return $arr;
		
		}
		
	}
