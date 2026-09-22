<?php

	class Presets extends CI_Controller {

		function index($id = null) {

			$data['presets'] = $this->presets_model->get_presets();

			$this->load->view('css/style');
			$this->load->view('html_title', $data);

			if(is_null($id)) {
				$data['num_series'] = $this->presets_model->get_num_series();
				$this->load->view('presets', $data);
			} elseif(array_key_exists($id, $data['presets'])) {
				$data['preset'] = $this->presets_model->get_data($id);
				$data['preset']['series_titles'] = $this->presets_model->get_series_titles($id);
				$this->load->view('preset_details', $data['preset']);
			} elseif($id) {
				redirect("/presets");
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

				$ivtc = $this->input->post('ivtc');
				if(is_null($ivtc))
					$arr['ivtc'] = 0;
				else
					$arr['ivtc'] = 1;

				$crop_video = $this->input->post('crop_video');
				if(is_null($crop_video))
					$arr['crop_video'] = 0;
				else
					$arr['crop_video'] = 1;

				$digital = $this->input->post('digital');
				if(is_null($digital))
					$arr['digital'] = 0;
				else
					$arr['digital'] = 1;

				$arr['name'] = $this->input->post('name');

				$this->presets_model->set($arr);

			}

 			redirect("presets/index/$id");

		}

	}
