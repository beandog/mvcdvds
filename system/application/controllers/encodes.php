<?php

	class Encodes extends Controller {

		function __construct() {
			parent::Controller();
		}

		function index() {

			$data['encodes'] = $this->encodes_model->get_encodes();

			$this->load->view('css/style');
			$this->load->view('html_title', $data);
			$this->load->view('encodes_header');
			$this->load->view('encodes', $data);

		}

		function app($str) {

			$data['encodes'] = $this->encodes_model->get_app($str);
			$data['app'] = $str;

			$this->load->view('css/style');
			$this->load->view('html_title', $data);
			$this->load->view('encodes_header');
			$this->load->view('encodes', $data);

		}

		function preset($str) {

			$data['encodes'] = $this->encodes_model->get_preset($str);

			$this->load->view('css/style');
			$this->load->view('html_title', $data);
			$this->load->view('encodes_header');
			$this->load->view('encodes', $data);

		}

		function audio($str) {

			$data['encodes'] = $this->encodes_model->get_audio($str);

			$this->load->view('css/style');
			$this->load->view('html_title', $data);
			$this->load->view('encodes_header');
			$this->load->view('encodes', $data);

		}

		function subs($str) {

			$data['encodes'] = $this->encodes_model->get_subs($str);

			$this->load->view('css/style');
			$this->load->view('html_title', $data);
			$this->load->view('encodes_header');
			$this->load->view('encodes', $data);

		}

		function series($str) {

			$data['encodes'] = $this->encodes_model->get_series($str);

			$this->load->view('css/style');
			$this->load->view('html_title', $data);
			$this->load->view('encodes', $data);

		}

	}
