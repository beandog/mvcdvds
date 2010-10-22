<?

	class Discs extends Controller {
	
		function __construct() {
		
			parent::Controller();
		
		}
		
		function index($id) {
	
			$data['discs'] = $this->discs_model->get_data($id);
			$collection = $this->discs_model->get_collection($id);
			$data['collection'] = $this->collections_model->get_data($collection);
			$data['series'] = $this->series_model->get_data($data['discs']['tv_show_id']);
			$data['tracks'] = $this->discs_model->get_tracks($id);
			
			$this->load->view('css/style');
			
 			$this->load->view('series_header', $data['series']);
 			$this->load->view('collection_link', $data['collection']);
			$this->load->view('disc_header', $data);
			$this->load->view('disc_tracks', $data);
		
		}
	
	}
	
	