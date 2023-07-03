<?php

	class Bugs extends Controller {


		function __construct() {
			parent::Controller();
		}

		function index($id = null) {

			$data['bugs'] = $this->bugs_model->get_bugs();

			$this->load->view('css/style');
			$this->load->view('html_title', $data);
			$this->load->view('bugs', $data);

		}

		function dvd($dvd_id) {

			$data['dvd']['id'] = $dvd_id;
			$data['dvd']['title'] = $this->bugs_model->get_dvd_title($dvd_id);
			$data['dvd']['notes'] = $this->bugs_model->get_dvd_notes($dvd_id);
			$data['series']['id'] = $this->dvds_model->get_series_id($dvd_id);
			$data['series']['collection_id'] = $this->dvds_model->get_collection_id($dvd_id);
			$data['series']['nsix'] = $this->bugs_model->get_series_nsix($data['series']['id']);
			$data['series']['title'] = $this->bugs_model->get_series_title($data['series']['id']);
			$data['bugs'] = $this->bugs_model->get_dvd_bugs($dvd_id);
			$data['bugs_details'] = $this->bugs_model->get_bugs_details();

			$this->load->view('css/style');
			$this->load->view('html_title', $data);
			$this->load->view('bugs_dvd', $data);

		}

		function update_dvd($dvd_id) {

			$data['bugs'] = $this->dvds_model->get_bugs($dvd_id, null);

			$array_keys = array();
			if($this->input->post('dvd_bug') !== false)
				$array_keys = array_keys($this->input->post('dvd_bug'));

			foreach($data['bugs'] as $arr_bug) {

				$bug_id = $arr_bug['id'];
				if(in_array($bug_id, $array_keys))
					$this->dvds_model->enable_bug($dvd_id, $bug_id);
				else
					$this->dvds_model->disable_bug($dvd_id, $bug_id);

			}

			// $this->bugs_model->set_dvd_notes($dvd_id, $this->input->post('notes'));

			$this->dvds_model->load($dvd_id);
			$this->dvds_model->set_notes(trim($this->input->post('notes')));

			redirect("bugs/dvd/$dvd_id");

		}

	}
