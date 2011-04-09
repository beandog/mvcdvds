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
			
			$bools = array('grayscale', 'detelecine', 'decomb', 'deinterlace', '_8x8dct', 'cabac', 'no_dct_decimate', 'mixed_refs');
			
			$numbers = array('crf', 'ref', 'bframes', 'weightp', 'subme', 'merange', 'b_adapt', 'trellis', 'keyint', 'rc_lookahead', 'aq_strength', 'psy_rd', 'deblock');
			
			if($submit == 'Update') {
			
				$arr['name'] = $this->input->post('name');
				$arr['base_preset'] = $this->input->post('base_preset');
				
				foreach($bools as $str)
					$arr[$str] = bool_pg($this->input->post($str));
				
				foreach($numbers as $str)
					$arr[$str] = $this->input->post($str);
				
				$this->presets_model->set($arr);
				
			}
			
			
 			redirect("presets/index/$id");
		
		}
	
	}