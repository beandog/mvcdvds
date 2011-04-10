<?

	class Ajax_tracks extends Controller {
	
		function __construct() {
		
			parent::Controller();
		
		}
		
		public function delete_episode($id) {
		
			$this->episodes_model->delete($id);
		
		}

		public function new_episode($id) {
		
			$episode_id = $this->episodes_model->create_new();
			$this->episodes_model->set_track_id($id);
		
		}

	}

?>