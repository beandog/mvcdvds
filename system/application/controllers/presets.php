<?

	class Presets extends Controller {

		function __construct() {

			parent::Controller();
		}

		function index($id = null) {

			$data['presets'] = $this->presets_model->get_presets();

			$this->load->view('css/style');
			$this->load->view('html_title', $data);

			if($id) {
				$data['preset'] = $this->presets_model->get_data($id);
				$this->load->view('preset_details', $data['preset']);
			} else {
				$this->load->view('presets', $data);
			}

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

				$crf = $this->input->post('crf');

				if(!$crf)
					$crf = 20;

				$video_bitrate = $this->input->post('video_bitrate');
				if(empty($crf) || !$crf)
					$crf = null;
				if(empty($video_bitrate) || !$video_bitrate)
					$video_bitrate = null;

				if($this->input->post('two_pass') == 't') {
					$arr['two_pass'] = 't';
					$arr['two_pass_turbo'] = 't';
					$arr['crf'] = null;
				} else {
					$arr['two_pass'] = 'f';
					$arr['two_pass_turbo'] = 'f';
					$arr['crf'] = $crf;
				}

				$acodec = $this->input->post('acodec');
				$acodec_bitrate = $this->input->post('acodec_bitrate');

				if(!$acodec_bitrate)
					$acodec_bitrate = null;

				$arr['name'] = $this->input->post('name');
				$arr['x264opts'] = $this->input->post('x264opts');
				$arr['x264_tune'] = $this->input->post('x264_tune');
				$arr['x264_preset'] = $this->input->post('x264_preset');
				$arr['video_bitrate'] = $video_bitrate;
				$arr['acodec'] = $acodec;
				$arr['acodec_bitrate'] = $acodec_bitrate;

				$this->presets_model->set($arr);

			}

 			redirect("presets/index");

		}

	}
