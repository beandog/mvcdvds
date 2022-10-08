<?php

	class Episodes extends Controller {

		function __construct() {

			parent::Controller();

		}

		public function index($id) {

			$data['episode'] = $this->episodes_model->get_data($id);
			$data['track'] = $this->tracks_model->get_data($data['episode']['track_id']);
			$data['dvd'] = $this->dvds_model->get_data($data['track']['dvd_id']);
			$data['dvd_id'] = $data['track']['dvd_id'];
			$series_id = $this->dvds_model->get_series_id($data['track']['dvd_id']);
			$data['series'] = $this->series_model->get_data($series_id);
			$data['preset'] = $this->presets_model->get_data($this->series_model->get_preset_id($series_id));
			$data['collection'] = $this->collections_model->get_data($data['series']['collection_id']);
			$data['dvds'] = $this->series_model->get_dvds($series_id);
			$data['plex_episode_dirs'] = $this->plex_model->get_plex_episode_dirs();
			$data['id'] = $id;

			$episode_nsix = $data['series']['collection_id'];
			$episode_nsix .= ".".str_pad($series_id, 3, 0, STR_PAD_LEFT);
			$episode_nsix .= ".".str_pad($data['track']['dvd_id'], 4, 0, STR_PAD_LEFT);
			$episode_nsix .= ".".str_pad($id, 5, 0, STR_PAD_LEFT);
			$episode_nsix .= ".".$data['series']['nsix'];
			$data['episode_nsix'] = $episode_nsix;

			$this->load->view('plex_episodes', $data);
			$data['filename'] = plex_episode_filename($episode_nsix, $data['plex_episode_dirs']);
			$data['mediainfo'] = '';
			if($data['filename'])
				$data['mediainfo'] = shell_exec("mediainfo ".$data['filename']);

			$this->load->view('css/style');
			$this->load->view('jquery');
			$this->load->view('html_title', $data['series']);
			$this->load->view('js/play_episode');
			$this->load->view('series_nav', $data);
			$this->load->view('episode_details', $data);

		}

	}
