<?php

class Collections extends Controller {

	function __construct() {
		parent::Controller();
	}

	function index($id, $order_by = 'title') {

		$data['collection'] = $this->collections_model->get_data($id);
		$data['collections'] = $this->series_model->get_collection($id, $order_by);

		$data['presets'] = $this->presets_model->get_presets();
		$data['series_presets'] = $this->series_model->get_series_presets();
		$data['series_numbers'] = $this->series_dvds_model->get_encoded_series_preset_filesize();

		foreach(array_keys($data['collections']) as $series_id) {

			$data['sum_filesize'][$series_id] = $this->series_model->get_sum_filesize($series_id);
			if(array_key_exists($series_id, $data['series_numbers']))
				$data['series_numbers'][$series_id] = $data['series_numbers'][$series_id];
			else
				$data['series_numbers'][$series_id] = null;
			$data['num_dvds'][$series_id] = $this->series_model->get_num_dvds($series_id);
			$data['num_episodes'][$series_id] = $this->series_model->get_num_episodes($series_id);
			$data['num_dvds_no_episodes'][$series_id] = $this->series_model->num_dvds_no_episodes($series_id);

			$metadata = array();
			if($this->series_model->old_metadata_spec($series_id))
				$metadata[] = "Legacy Metadata";
			// if($this->series_model->missing_episode_titles($series_id))
			//	$metadata[] = "Missing Titles";
			if($data['num_episodes'][$series_id] === 0)
				$metadata[] = "No Series Episodes";
			elseif($data['num_dvds_no_episodes'][$series_id])
				$metadata[] = "DVD No Episodes";

			$data['metadata'][$series_id] = $metadata;

		}

		$this->load->view('css/style');
		$this->load->view('html_title', $data['collection']);

 		$this->load->view('collections', $data);

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
