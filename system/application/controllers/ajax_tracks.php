<?

	class Ajax_tracks extends Controller {

		function __construct() {

			parent::Controller();

		}

		public function delete_episode($id) {

			$this->episodes_model->delete($id);

		}

		public function new_chapter_episode() {

			$track_id = $this->input->get_post('track_id');
			$chapter = $this->input->get_post('chapter');

			$episode_id = $this->episodes_model->create_new();
			$this->episodes_model->set_track_id($track_id);
			$this->episodes_model->set_starting_chapter($chapter);
			$this->episodes_model->set_ending_chapter($chapter);

		}

		public function new_episode($id) {

			$episode_id = $this->episodes_model->create_new();
			$this->episodes_model->set_track_id($id);

		}

	}

?>
