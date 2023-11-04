<?php

	class Tracks extends Controller {

		function __construct() {

			parent::Controller();

		}

		public function index($track_id) {

			$data['dvd_id'] = $dvd_id = $this->tracks_model->get_dvd_id($track_id);

 			$data['dvds'] = $this->dvds_model->get_data($dvd_id);
 			$collection_id = $this->dvds_model->get_collection_id($dvd_id);
 			$series_id = $this->dvds_model->get_series_id($dvd_id);
 			$data['collection'] = $this->collections_model->get_data($collection_id);
 			$data['series'] = $this->series_model->get_data($series_id);
 			$data['tracks'] = $this->dvds_model->get_tracks($dvd_id);
 			$data['series_dvds'] = $this->series_model->get_dvds($series_id, 'disc');
 			$data['chapters'] = $this->tracks_model->get_chapters($track_id);
			$data['cells'] = $this->tracks_model->get_cells($track_id);
 			$data['audio'] = $this->tracks_model->get_audio($track_id);
 			$data['subp'] = $this->tracks_model->get_subp($track_id);
 			$data['cc'] = $this->tracks_model->get_cc($track_id);
 			$data['track_id'] = $track_id;
			$data['preset'] = $this->presets_model->get_data($this->series_model->get_preset_id($series_id));

 			$this->load->view('css/style');
			$this->load->view('jquery');
			// $this->load->view('js/track_chapters');
			$this->load->view('js/plus_minus');
			$this->load->view('html_title', $data['series']);

 			$this->load->view('series_nav', $data);
 			$this->load->view('track_chapters', $data);
			if($data['dvds']['bluray'] == 0)
				$this->load->view('track_cells', $data);
 			$this->load->view('track_audio', $data);
 			$this->load->view('track_subp', $data);

		}

	}


