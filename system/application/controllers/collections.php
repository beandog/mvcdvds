<?php

class Collections extends Controller {

	function __construct() {
		parent::Controller();
	}
	
	function index($id)
	{
	
		$data['collection'] = $this->collections_model->get_data($id);
		$data['collections'] = $this->series_model->get_collection($id);
		
		$this->load->view('css/style');
		
 		$this->load->view('collection_header', $data['collection']);
 		$this->load->view('list_collection_data', $data);
	}
	
	function new_series($id) {
	
		$series_id = $this->series_model->create_new();
		$this->series_model->set_collection_id($id);
		
		redirect("series/details/$series_id");
	
	}
	
	
}
