<?php

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

				$crf = abs(intval($this->input->post('crf')));
				$acodec_bitrate = abs(intval($this->input->post('acodec_bitrate')));
				$acodec = $this->input->post('acodec');
				$fps = abs(intval($this->input->post('fps')));

				if($acodec == 'copy')
					$acodec_bitrate = 192;
				if(!$acodec_bitrate)
					$acodec_bitrate = null;

				if(!$crf)
					$crf = 23;

				if(!$fps)
					$fps = null;

				$arr['name'] = $this->input->post('name');
				$arr['x264_tune'] = $this->input->post('x264_tune');
				$arr['x264_preset'] = $this->input->post('x264_preset');
				$arr['format'] = $this->input->post('format');
				$arr['crf'] = $crf;
				$arr['deinterlace'] = $this->input->post('deinterlace');
				$arr['decomb'] = $this->input->post('decomb');
				$arr['detelecine'] = $this->input->post('detelecine');
				$arr['acodec'] = $acodec;
				$arr['acodec_bitrate'] = $acodec_bitrate;
				$arr['fps'] = $fps;

				$this->presets_model->set($arr);

			}

 			redirect("presets/index/$id");

		}

	}
