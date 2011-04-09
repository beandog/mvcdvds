<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
	
		$data['collections'] = $this->collections_model->get_collections();
		$data['presets'] = $this->presets_model->get_presets();
		$data['dvds'] = $this->dvds_model->get_new_dvds();
		
		$this->load->view('css/style');
		
		$this->load->view('header_collections');
		$this->load->view('home_collections', $data);
		
		$this->load->view('presets', $data);
		
		if(count($data['dvds']))
			$this->load->view('dvds_new');
		
	}
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */