<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		// MVCDVDS 2.0 - not sure if this is needed, why would I want presets?
		/*
		$data['presets'] = $this->presets_model->get_presets();
		$data['dvds'] = $this->dvds_model->get_new_dvds();
		$data['isos'] = $this->home_dir->get_isos();
		*/

		$data = array();
		$data['new_dvds'] = $this->dvds_model->get_new_dvds();

		$this->load->view('css/style');
		$this->load->view('jquery');
		$this->load->view('html_title', $data);

		if(count($data['new_dvds']))
			$this->load->view('dvds_new', $data);

	}

	public function search() {

		$q = $this->input->post('q');

		$data['title'] = 'Search Results';
		$data['collections'] = $this->series_model->search($q);

		if(count($data['collections']) === 1) {

			$series_id = key($data['collections']);
			redirect("series/dvds/$series_id");

		}

		$this->load->view('css/style');
		$this->load->view('html_title', $data);
		$this->load->view('search_results', $data);

	}
}
