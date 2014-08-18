<?php

	class Libraries extends Controller {

		function __construct() {

			parent::Controller();

		}

		function index($id = null) {

			$data['libraries'] = $this->library_model->get_libraries();

			$this->load->view('css/style');
			$this->load->view('html_title', $data);

			if($id) {
				$data['library'] = $this->library_model->get_data($id);
				$this->load->view('library_details', $data['library']);
			} else {
				$this->load->view('libraries', $data);
			}

		}

	}
