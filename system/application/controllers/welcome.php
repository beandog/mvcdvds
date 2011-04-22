<?php

class Welcome extends Controller {

	function Welcome() {
		parent::Controller();	
	}
	
	function index() {
	
		$data['collections'] = $this->collections_model->get_collections();
		$data['presets'] = $this->presets_model->get_presets();
		$data['dvds'] = $this->dvds_model->get_new_dvds();
		$data['new_dvds'] = $this->dvds_model->get_new_dvds();
		$data['title'] = "DVDs Admin v3.0";
		$data['queue'] = $this->queue_model->get_queue();
		
		$this->load->view('css/style');
		$this->load->view('jquery');
		$this->load->view('js/drives');
		$this->load->view('html_title', $data);
		
		$this->load->view('header_collections');
		$this->load->view('home_collections', $data);
		$this->load->view('welcome_presets', $data);
		$this->load->view('presets', $data);
		$data['presets'] = $this->presets_model->get_base_presets();
		$this->load->view('presets', $data);
		
		if(count($data['new_dvds']))
			$this->load->view('dvds_new', $data);
		
		if(count($data['queue'])) {
			$this->load->view('queue');
			$this->load->view('queue_reset');
		}
		
	}
	
	public function search() {
	
		$q = $this->input->post('q');
	
	}
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */