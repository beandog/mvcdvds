<?

	class Ajax_series_dvds extends Controller {
	
		function __construct() {
		
			parent::Controller();
		
		}
		
		public function set_ix() {
		
			$series_dvds_id = $this->input->get_post('series_dvds_id');
			$ix = intval($this->input->get_post('ix'));
			
			if(!$ix)
				$ix = pg_null($ix);
		
			$this->series_dvds_model->load($series_dvds_id);
			$this->series_dvds_model->set_ix($ix);
		
		}
		
		public function set_season() {
		
			$series_dvds_id = $this->input->get_post('series_dvds_id');
			$season = intval($this->input->get_post('season'));
			
			if(!$season)
				$season = pg_null($season);
		
			$this->series_dvds_model->load($series_dvds_id);
			$this->series_dvds_model->set_season($season);
		
		}
		
		public function set_side() {
		
			$series_dvds_id = $this->input->get_post('series_dvds_id');
			$side = $this->input->get_post('side');
		
			$this->series_dvds_model->load($series_dvds_id);
			$this->series_dvds_model->set_side($side);
		
		}
		
		public function set_volume() {
		
			$series_dvds_id = $this->input->get_post('series_dvds_id');
			$volume = intval($this->input->get_post('volume'));
			
			if(!$volume)
				$volume = pg_null($volume);
		
			$this->series_dvds_model->load($series_dvds_id);
			$this->series_dvds_model->set_volume($volume);
		
		}

	}

?>