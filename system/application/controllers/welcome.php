<?php

class Welcome extends Controller {

	function Welcome() {
		parent::Controller();
	}

	function index() {

		$data['presets'] = $this->presets_model->get_presets();
		$data['dvds'] = $this->dvds_model->get_new_dvds();
		$data['new_dvds'] = $this->dvds_model->get_new_dvds();
		$data['queue'] = $this->queue_model->get_queue();
		$data['isos'] = $this->home_dir->get_isos();

		$this->load->view('css/style');
		$this->load->view('jquery');
		$this->load->view('js/drives');
		$this->load->view('html_title', $data);

		if(count($data['new_dvds']))
			$this->load->view('dvds_new', $data);

		if(count($data['queue'])) {
			$this->load->view('queue');
			$this->load->view('queue_reset');
		}

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

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
