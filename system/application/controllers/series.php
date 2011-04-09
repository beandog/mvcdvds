<?

	class Series extends Controller {
	
		function __construct() {
		
			parent::Controller();
		}
		
		function index($id) {
	
			$data['series'] = $this->series_model->get_data($id);
			$data['collection'] = $this->collections_model->get_data($data['series']['collection_id']);
			
			$this->load->view('css/style');
			
 			$this->load->view('series_nav', $data);
		
		}
		
		function dvds($id) {
	
			$data['series'] = $this->series_model->get_data($id);
			$data['collection'] = $this->collections_model->get_data($data['series']['collection_id']);
			$data['dvds'] = $this->series_model->get_dvds($id, 'disc');
			
			foreach($data['dvds'] as $dvd_id => $row) {
				$data['episodes'][$dvd_id] = $this->dvds_model->get_episodes($dvd_id);
			}
			
			

			$this->load->view('css/style');
			
 			$this->load->view('series_nav', $data);
 			$this->load->view('series_dvds', $data);
		
		}
		
		function details($id) {
		
			$data['series'] = $this->series_model->get_data($id);
			$data['collection'] = $this->collections_model->get_data($data['series']['collection_id']);
			$data['presets'] = $this->presets_model->get_presets();
			$data['preset'] = $this->presets_model->get_data($this->series_model->get_preset_id($id));
			
// 			$data['discs'] = $this->discs_model->get_series($id, 'disc');
			
			$data['collections'] = $this->collections_model->get_collections();
			
			$this->load->view('css/style');
			
			$this->load->view('series_nav', $data);
			$this->load->view('series_details', $data);
		
		}
		
		public function update($id) {
		
			$this->series_model->load($id);
			
			$arr = array(
				'collection_id' => $this->input->post('collection'),
				'title_long' => $this->input->post('title_long'),
				'title' => $this->input->post('title'),
				'average_length' => $this->input->post('average_length'),
				'production_year' => $this->input->post('production_year'),
				'indexed' => bool_pg($this->input->post('indexed')),
			);
			
			$this->series_model->set($arr);
			
			$this->series_model->set_preset_id($id, $this->input->post('preset_id'));
			
  			redirect("series/details/$id");
		
		}
	
	}
	
	