<?

	class Series extends Controller {
	
		function __construct() {
		
			parent::Controller();
		}
		
		function index($id) {
	
			$data['series'] = $this->series_model->get_data($id);
			$data['collection'] = $this->collections_model->get_data($data['series']['collection_id']);
// 			$data['discs'] = $this->discs_model->get_series($id, 'disc');
			
			$this->load->view('css/style');
			
			$this->load->view('series_header', $data['series']);
			$this->load->view('collection_link', $data['collection']);
			$this->load->view('series_nav', $data['series']);
// 			$this->load->view('series_discs', $data);
		
		}
		
		function discs($id) {
	
			$data['series'] = $this->series_model->get_data($id);
			$data['collection'] = $this->collections_model->get_data($data['series']['collection']);
			$data['discs'] = $this->discs_model->get_series($id, 'disc');

			$this->load->view('css/style');
			
			$this->load->view('series_header', $data['series']);
			$this->load->view('collection_link', $data['collection']);
			$this->load->view('series_nav', $data['series']);
			$this->load->view('series_discs', $data);
		
		}
		
		function details($id) {
		
			$data['series'] = $this->series_model->get_data($id);
			$data['collection'] = $this->collections_model->get_data($data['series']['collection_id']);
// 			$data['discs'] = $this->discs_model->get_series($id, 'disc');
			
			$data['collections'] = $this->collections_model->get_collections();
			
			$this->load->view('css/style');
			
			$this->load->view('series_header', $data['series']);
			$this->load->view('collection_link', $data['collection']);
			$this->load->view('series_nav', $data['series']);
			$this->load->view('series_details', $data);
		
		}
		
		public function update($id) {
		
			$this->series_model->load($id);
			
			$arr = array(
				'collection' => $this->input->post('collection'),
				'title_long' => $this->input->post('title_long'),
				'title' => $this->input->post('title'),
				'min_len' => $this->input->post('min_len'),
				'max_len' => $this->input->post('max_len'),
				'start_year' => $this->input->post('start_year'),
				'cartoon' => bool_pg($this->input->post('cartoon')),
				'unordered' => bool_pg($this->input->post('unordered')),
				'grayscale' => bool_pg($this->input->post('grayscale')),
				'handbrake' => bool_pg($this->input->post('handbrake')),
				'handbrake_preset' => $this->input->post('handbrake_preset'),
				'crf' => $this->input->post('crf'),
				'keyint' => $this->input->post('keyint'),
				'tune' => $this->input->post('tune'),
			);
			
			$this->series_model->set($arr);
			
 			redirect("series/details/$id");
		
		}
	
	}
	
	