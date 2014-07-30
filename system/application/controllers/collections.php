<?php

class Collections extends Controller {

	function __construct() {
		parent::Controller();
	}

	function index($id) {

		$data['collection'] = $this->collections_model->get_data($id);
		$data['collections'] = $this->series_model->get_collection($id);
		foreach(array_keys($data['collections']) as $series_id) {

			$data['sum_filesize'][$series_id] = $this->series_model->get_sum_filesize($series_id);
			$data['num_dvds'][$series_id] = $this->series_model->get_num_dvds($series_id);

			// The get_collection function for the series model (above)
			// already sets a variable 'missing_metadata'.  FIXME I'm not
			// going to rewrite that query, so I already have a separate one
			// that looks for missing metadata in other places.  Add the
			// two together here, so either one sets the boolean in the
			// array in the final data.
			if(!$data['collections'][$series_id]['missing_metadata'] && $this->series_model->missing_metadata($series_id))
				$data['collections'][$series_id]['missing_metadata'] = true;
		}

		$this->load->view('css/style');
		$this->load->view('html_title', $data['collection']);

 		$this->load->view('list_collection_data', $data);
	}

	function new_series($id) {

		$series_id = $this->series_model->create_new();
		$this->series_model->set_collection_id($id);

		redirect("series/details/$series_id");

	}

	function unarchived_series($id) {

		$data['series'] = $this->collections_model->get_unarchived_series($id);
		$data['collection'] = $this->collections_model->get_data($id);

		$this->load->view('css/style');
		$this->load->view('html_title', $data['collection']);
		$this->load->view('collection_header', $data['collection']);
		$this->load->view('collection_unarchived_series', $data);

	}

}
