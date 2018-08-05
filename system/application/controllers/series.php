<?php

	class Series extends Controller {

		function __construct() {

			parent::Controller();
		}

		function index($id) {

			$data['series'] = $this->series_model->get_data($id);
			$data['collection'] = $this->collections_model->get_data($data['series']['collection_id']);

			$this->load->view('css/style');

 			$this->load->view('series_nav', $data);

		}

		function dvds($id) {

			$id = abs(intval($id));

			$data['series'] = $this->series_model->get_data($id);
			$data['collection'] = $this->collections_model->get_data($data['series']['collection_id']);
			$data['dvds'] = $this->series_model->get_dvds($id, 'disc');
			$data['dvd_id'] = key($data['dvds']);
			$data['new_dvds'] = $this->dvds_model->get_new_dvds();
			$data['series_id'] = $id;
			$data['preset'] = $this->presets_model->get_data($this->series_model->get_preset_id($id));

			foreach($data['dvds'] as $dvd_id => $row) {
				$data['dvds'][$dvd_id]['num_tracks'] = count($this->dvds_model->get_tracks($dvd_id));
				$data['episodes'][$dvd_id] = $this->dvds_model->get_episodes($dvd_id, 'episode_ix', false);

				$metadata = array();
				if($this->dvds_model->old_metadata_spec($dvd_id) == true)
					$metadata[] = "Legacy Metadata";
				if($this->dvds_model->missing_filesize($dvd_id))
					$metadata[] = "Unknown Filesize";
				if($this->dvds_model->missing_audio_tracks($dvd_id))
					$metadata[] = "Missing Audio Tracks";
				// if($this->dvds_model->missing_episode_titles($dvd_id))
				//	$metadata[] = "Missing Titles";
				if(count($data['episodes'][$dvd_id]) === 0)
					$metadata[] = "No Episodes";
				if($this->dvds_model->has_bugs($dvd_id))
					$metadata[] = "Bugs";

				$data['metadata'][$dvd_id] = $metadata;

			}

			$this->load->view('css/style');
			$this->load->view('html_title', $data['series']);

 			$this->load->view('series_nav', $data);
 			$this->load->view('series_dvds', $data);

 			if(count($data['new_dvds']))
 				$this->load->view('series_new_dvds', $data);

		}

		function details($id) {

			$data['series'] = $this->series_model->get_data($id);
			$data['collection'] = $this->collections_model->get_data($data['series']['collection_id']);
			$data['presets'] = $this->presets_model->get_presets();
			$data['preset'] = $this->presets_model->get_data($this->series_model->get_preset_id($id));
			$data['dvds'] = $this->series_model->get_dvds($id, 'disc');
			$data['dvd_id'] = key($data['dvds']);
			$data['collections'] = $this->collections_model->get_collections();

			$this->load->view('css/style');
			$this->load->view('html_title', $data['series']);

			$this->load->view('series_nav', $data);
			$this->load->view('series_details', $data);

		}

		public function new_dvd() {

			$uri = $this->uri->uri_to_assoc();

			$series_id = $uri['series_id'];
			$dvd_id = $uri['dvd_id'];

			$this->series_dvds_model->delete_dvd($dvd_id);
			$this->series_dvds_model->create_new();
			$this->series_dvds_model->set_series_id($series_id);
			$this->series_dvds_model->set_dvd_id($dvd_id);

			redirect("series/dvds/$series_id");

		}

		public function update($id) {

			$this->series_model->load($id);

			$arr = array(
				'collection_id' => $this->input->post('collection'),
				'nsix' => $this->input->post('nsix'),
				'title' => $this->input->post('title'),
				'average_length' => intval($this->input->post('average_length')),
				'production_year' => $this->input->post('production_year'),
				'indexed' => bool_pg($this->input->post('indexed')),
				'grayscale' => (bool)($this->input->post('grayscale')),
				'dvdnav' => (bool)($this->input->post('dvdnav')),
				'qa_notes' => ($this->input->post('qa_notes')),
				'tvdb' => $this->input->post('tvdb'),
			);

			$this->series_model->set($arr);

			$this->series_model->set_preset_id($id, $this->input->post('preset_id'));

  			redirect("series/details/$id");

		}

	}


