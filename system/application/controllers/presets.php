<?

	class Presets extends Controller {
	
		function __construct() {
		
			parent::Controller();
		}
		
		function index($id) {
	
			$data['preset'] = $this->presets_model->get_data($id);
			$this->load->view('css/style');
			
			$this->load->view('presets_header', $data['preset']);
			$this->load->view('preset_details', $data['preset']);
			
		}
		
		function create_new() {
		
			$id = $this->presets_model->create_new();
			$this->presets_model->set_name('New Preset');
			
			redirect("presets/index/$id");
		
		}
		
		public function update($id) {
		
			$this->presets_model->load($id);
			
			$submit = $this->input->post('submit');
			
			if($submit == 'Update') {
			
				$arr['name'] = $this->input->post('name');
				$arr['base_preset'] = $this->input->post('base_preset');
				$arr['crf'] = $this->input->post('crf');
				$arr['x264opts'] = $this->input->post('x264opts');
				
				$this->presets_model->set($arr);
				
			}
			
			
 			redirect("presets/index/$id");
		
		}
	
	}