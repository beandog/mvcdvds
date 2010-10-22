<?php

class Welcome extends Controller {

	function Welcome()
	{
		parent::Controller();	
	}
	
	function index()
	{
	
		$data['collections'] = $this->collections_model->get_collections();
		
		$this->load->view('css/style');
		
		$this->load->view('header_collections');
		$this->load->view('home_collections', $data);
	}
	
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */