<?php

	class Series extends Controller {

		function __construct() {

			parent::Controller();
		}

		function index($id) {

  			redirect("/");

			/*
			$data['series'] = $this->series_model->get_data($id);
			$data['collection'] = $this->collections_model->get_data($data['series']['collection_id']);

			$this->load->view('css/style');

 			$this->load->view('series_nav', $data);
			*/

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
			$data['plex_episode_dirs'] = $this->plex_model->get_plex_episode_dirs();

			if(in_array($data['collection']['id'], array(4, 5, 7, 8, 9)))
				$movie = true;
			else
				$movie = false;

			$nsix_type = substr($data['series']['nsix'], 0, 2);
			if(in_array($data['collection']['id'], array(6, 8)) || $nsix_type == 'BD' || $nsix_type == 'HD' || $nsix_type == '4K') {
				$bluray = true;
				$disc_type = 'bluray';
			} else {
				$bluray = false;
				$disc_type = 'dvd';
			}

			foreach($data['dvds'] as $dvd_id => $row) {

				if($disc_type == 'bluray') {
					$bluray_disc_title = $this->dvds_model->get_bluray_disc_title($dvd_id);
					if(!$data['dvds'][$dvd_id]['title'])
						$data['dvds'][$dvd_id]['title'] = strtoupper($bluray_disc_title);
				}

				$data['dvds'][$dvd_id]['num_tracks'] = count($this->dvds_model->get_tracks($dvd_id));
				$data['episodes'][$dvd_id] = $this->dvds_model->get_episodes($dvd_id, 'episode_ix', false);
				$episodes_skipped = count($data['episodes'][$dvd_id]) - count($this->dvds_model->get_episodes($dvd_id, 'episode_ix', true));

				$metadata = array();
				if($this->dvds_model->missing_filesize($dvd_id))
					$metadata[] = "Unknown Filesize";
				if($this->dvds_model->missing_audio_tracks($dvd_id))
					$metadata[] = "Missing Audio Tracks";
				if($this->dvds_model->missing_episode_titles($dvd_id))
					$metadata[] = "Missing Titles";
				if($this->dvds_model->missing_episode_numbers($dvd_id) && !$movie)
					$metadata[] = "Legacy Episode Numbers";
				if($disc_type == 'bluray' && $this->dvds_model->missing_bluray_id($dvd_id))
					$metadata[] = "Legacy Unique ID";
				if(count($data['episodes'][$dvd_id]) === 0 && $episodes_skipped === 0)
					$metadata[] = "No Episodes";
				if($this->dvds_model->has_bugs($dvd_id))
					$metadata[] = "Bugs";
				// if($this->dvds_model->missing_pts($dvd_id) && !$bluray)
				//	$metadata[] = "Missing PTS";
				/*
				if($row['bluray'] && $row['decss'] === '')
					$metadata[] = "DRM";
				elseif($row['bluray'] && is_null($row['decss']))
					$metadata[] = "Missing KEYDB";
				elseif($row['bluray'] && $row['decss'])
					$metadata[] = "AACS";
				*/

				$data['metadata'][$dvd_id] = $metadata;

			}

			$this->load->view('css/style');
			$this->load->view('html_title', $data['series']);

 			$this->load->view('series_nav', $data);
 			$this->load->view('plex_episodes', $data);
 			$this->load->view('series_dvds', $data);

 			if(count($data['new_dvds']))
 				$this->load->view('series_new_dvds', $data);

		}

		function details($id) {

			if($id == null)
				redirect("/");

			$data['series'] = $this->series_model->get_data($id);
			$data['collection'] = $this->collections_model->get_data($data['series']['collection_id']);
			$data['presets'] = $this->presets_model->get_presets();
			$data['preset'] = $this->presets_model->get_data($this->series_model->get_preset_id($id));
			$data['rippers'] = $this->presets_model->get_rippers();
			$data['dvds'] = $this->series_model->get_dvds($id, 'disc');
			$data['dvd_id'] = key($data['dvds']);
			$data['collections'] = $this->collections_model->get_collections();
			$data['libraries'] = $this->collections_model->get_libraries($data['series']['collection_id']);

			$this->load->view('css/style');
			$this->load->view('html_title', $data['series']);

			$this->load->view('series_nav', $data);

			$nsix_type = substr($data['series']['nsix'], 0, 2);
			if(in_array($data['collection']['id'], array(6, 8)) || $nsix_type == 'BD' || $nsix_type == 'HD' || $nsix_type == '4K')
				$data['series']['bluray'] = true;
			else
				$data['series']['bluray'] = false;

			if($data['series']) {
				$this->load->view('series_details', $data);
			}

		}

		function qa($id) {

			if($id == null)
				redirect("/");

			$data['series'] = $this->series_model->get_data($id);
			$data['collection'] = $this->collections_model->get_data($data['series']['collection_id']);
			$data['presets'] = $this->presets_model->get_presets();
			$data['preset'] = $this->presets_model->get_data($this->series_model->get_preset_id($id));
			$data['dvds'] = $this->series_model->get_dvds($id, 'disc');
			$data['dvd_id'] = key($data['dvds']);
			$data['collections'] = $this->collections_model->get_collections();
			$data['libraries'] = $this->collections_model->get_libraries($data['series']['collection_id']);

			$this->load->view('css/style');
			$this->load->view('html_title', $data['series']);

			$this->load->view('series_nav', $data);
			$this->load->view('series_qa', $data);

		}

		function videos($id) {

			if($id == null)
				redirect("/");

			$data['series'] = $this->series_model->get_data($id);
			$data['collection'] = $this->collections_model->get_data($data['series']['collection_id']);
			$data['presets'] = $this->presets_model->get_presets();
			$data['preset'] = $this->presets_model->get_data($this->series_model->get_preset_id($id));
			$data['dvds'] = $this->series_model->get_dvds($id, 'disc');
			$data['dvd_id'] = key($data['dvds']);
			$data['collections'] = $this->collections_model->get_collections();
			$data['libraries'] = $this->collections_model->get_libraries($data['series']['collection_id']);

			$this->load->view('css/style');
			$this->load->view('html_title', $data['series']);

			$this->load->view('series_nav', $data);
			$this->load->view('series_videos', $data);

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
				'nsix' => strtoupper($this->input->post('nsix')),
				'title' => $this->input->post('title'),
				'ripping_id' => $this->input->post('ripping_id'),
				'average_length' => intval($this->input->post('average_length')),
				'production_year' => $this->input->post('production_year'),
				'grayscale' => (bool)($this->input->post('grayscale')),
				'detelecine' => (bool)($this->input->post('detelecine')),
				'decomb' => $this->input->post('decomb'),
				'dvdnav' => (bool)($this->input->post('dvdnav')),
				'qa_notes' => ($this->input->post('qa_notes')),
				'tvdb' => $this->input->post('tvdb'),
				'jfin' => $this->input->post('jfin'),
				'active' => $this->input->post('active'),
			);

			if($this->input->post('library'))
				$arr['library_id'] = $this->input->post('library');
			else
				$arr['library_id'] = null;

			/*
			if($this->input->post('x264_preset'))
				$arr['x264_preset'] = $this->input->post('x264_preset');
			else
				$arr['x264_preset'] = null;
			*/

			if($this->input->post('crf'))
				$arr['crf'] = intval($this->input->post('crf'));
			else
				$arr['crf'] = null;

			if($this->input->post('start_date'))
				$arr['start_date'] = $this->input->post('start_date');
			else
				$arr['start_date'] = null;

			$this->series_model->set($arr);

			$this->series_model->set_preset_id($id, $this->input->post('preset_id'));

  			redirect("series/details/$id");

		}

	}


