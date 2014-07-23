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

				$crf = $this->input->post('crf');
				$video_bitrate = $this->input->post('video_bitrate');
				if(empty($crf) || !$crf)
					$crf = null;
				if(empty($video_bitrate) || !$video_bitrate)
					$video_bitrate = null;

				$arr['name'] = $this->input->post('name');
				$arr['crf'] = $crf;
				$arr['x264opts'] = $this->input->post('x264opts');
				$arr['format'] = $this->input->post('format');
				$arr['video_bitrate'] = $video_bitrate;
				$arr['acodec'] = $this->input->post('acodec');
				$arr['acodec_bitrate'] = $this->input->post('acodec_bitrate');

				$this->presets_model->set($arr);

			}


 			redirect("presets/index/$id");

		}

	}
