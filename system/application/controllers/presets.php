<?php

	class Presets extends Controller {

		function __construct() {

			parent::Controller();
		}

		function index($id = null) {

			$data['presets'] = $this->presets_model->get_presets();

			$this->load->view('css/style');
			$this->load->view('html_title', $data);

			if(array_key_exists($id, $data['presets'])) {
				$data['preset'] = $this->presets_model->get_data($id);
				$data['preset']['series_titles'] = $this->presets_model->get_series_titles($id);
				$this->load->view('preset_details', $data['preset']);
			} elseif($id) {
				redirect("/presets");
			} else {
				$data['num_series'] = $this->presets_model->get_num_series();
				$this->load->view('presets', $data);
			}

		}

		function create_new() {

			$id = $this->presets_model->create_new();
			$this->presets_model->set_name('New Preset');
			$this->presets_model->set_format('mkv');

			redirect("presets/index/$id");

		}

		public function update($id) {

			$this->presets_model->load($id);

			$submit = $this->input->post('submit');

			if($submit == 'Update') {

				$crf = abs(intval($this->input->post('crf')));
				$acodec = $this->input->post('acodec');

				if(!strlen($this->input->post('crf')))
					$crf = 23;

				if(!$fps)
					$fps = null;

				$arr['name'] = $this->input->post('name');
				$arr['x264_tune'] = $this->input->post('x264_tune');
				// $arr['x264_preset'] = $this->input->post('x264_preset');
				$arr['crf'] = $crf;
				$arr['detelecine'] = $this->input->post('detelecine');
				// $arr['vcodec'] = $this->input->post('vcodec');
				$arr['acodec'] = $acodec;
				$arr['fps'] = $this->input->post('fps');

				$this->presets_model->set($arr);

			}

 			redirect("presets/index/$id");

		}

	}
