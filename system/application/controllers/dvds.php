<?php

	class Dvds extends Controller {

		function __construct() {

			parent::Controller();

		}

		public function index($id) {

			$data['dvds'] = $this->dvds_model->get_data($id);
			$collection_id = $this->dvds_model->get_collection_id($id);
			$series_id = $this->dvds_model->get_series_id($id);
			$data['collection'] = $this->collections_model->get_data($collection_id);
			$data['series'] = $this->series_model->get_data($series_id);
			$data['tracks'] = $this->dvds_model->get_tracks($id);

			$this->load->view('css/style');

 			$this->load->view('dvds_nav', $data);

		}

		public function delete($id) {

			$series_id = $this->dvds_model->get_series_id($id);
			$this->dvds_model->delete($id);

			redirect("series/dvds/$series_id");

		}

		public function details($id) {

			$data['dvds'] = $this->dvds_model->get_data($id);
			$data['series_dvd'] = $this->series_dvds_model->get_dvd_data($id);
			$collection_id = $this->dvds_model->get_collection_id($id);
			$series_id = $this->dvds_model->get_series_id($id);
			$data['collection'] = $this->collections_model->get_data($collection_id);
			$data['series'] = $this->series_model->get_data($series_id);
			$data['tracks'] = $this->dvds_model->get_tracks($id);
			$data['episodes'] = $this->dvds_model->get_episodes($id);
			$data['series_dvds'] = $this->series_model->get_dvds($series_id, 'disc');

			// Navigation
			$data['dvd_id'] = $id;

			$data['select_series'] = $this->series_model->get_series_dropdown();

			foreach($data['tracks'] as $track_id => $row) {
				$data['chapters'][$track_id] = $this->tracks_model->get_chapters($track_id);
			}

			$this->load->view('css/style');
			$this->load->view('jquery');
			$this->load->view('js/plus_minus');
			$this->load->view('js/dvd_series_details');
			$this->load->view('html_title', $data['series']);

 			$this->load->view('series_nav', $data);
 			$this->load->view('dvd_series_details', $data);
 			$this->load->view('dvd_details', $data);

		}

		public function episodes($id) {

			$data['dvds'] = $this->dvds_model->get_data($id);
			$collection_id = $this->dvds_model->get_collection_id($id);
			$series_id = $this->dvds_model->get_series_id($id);
			$data['collection'] = $this->collections_model->get_data($collection_id);
			$data['series'] = $this->series_model->get_data($series_id);
			$data['tracks'] = $this->dvds_model->get_tracks($id);

			if($this->series_model->get_indexed($series_id) == 'f')
				$orderby = 'episode_ix';
			else
				$orderby = 'tracks_ix';

			$data['episodes'] = $this->dvds_model->get_episodes($id, $orderby);
			$data['series_dvds'] = $this->series_model->get_dvds($series_id, 'disc');

			$data['next_episode'] = $this->_estimate_next_episode($data);

			// Navigation
			$data['dvd_id'] = $id;

			foreach($data['tracks'] as $track_id => $row) {
				$data['chapters'][$track_id] = $this->tracks_model->get_chapters($track_id);
			}

			$this->load->view('css/style');
			$this->load->view('jquery');
			$this->load->view('html_title', $data['series']);

			$this->load->view('series_nav', $data);
 			$this->load->view('js/dvd_episodes');
 			$this->load->view('js/tables');
 			$this->load->view('dvd_episodes', $data);

		}

		public function new_dvd($id) {

			$data['dvds'] = $this->dvds_model->get_data($id);
			$data['select_series'] = $this->series_model->get_series_dropdown();

			$this->load->view('dvd_details', $data);

		}

		public function tracks($id) {

			$data['dvds'] = $this->dvds_model->get_data($id);
			$collection_id = $this->dvds_model->get_collection_id($id);
			$series_id = $this->dvds_model->get_series_id($id);
			$data['collection'] = $this->collections_model->get_data($collection_id);
			$data['series'] = $this->series_model->get_data($series_id);
			$data['tracks'] = $this->dvds_model->get_tracks($id);
			$data['series_dvds'] = $this->series_model->get_dvds($series_id, 'disc');
			// Navigation
			$data['dvd_id'] = $id;

			foreach($data['tracks'] as $track_id => $row) {
				$data['chapters'][$track_id] = $this->tracks_model->get_chapters($track_id);
			}

			$this->load->view('css/style');
			$this->load->view('jquery');
			$this->load->view('js/dvd_tracks');
			$this->load->view('js/plus_minus');
			$this->load->view('html_title', $data['series']);

 			$this->load->view('series_nav', $data);
 			$this->load->view('dvd_tracks', $data);

		}

		public function update_episodes($dvd_id) {

			$episodes = $this->input->post('episode');

			foreach($episodes as $episode_id => $arr) {

				extract($arr);

				// Set new track ID using the track ix as a reference
				$track_id = $this->tracks_model->get_track_ix_id($dvd_id, $track_ix);

				$this->episodes_model->load($episode_id);
				$this->episodes_model->set('track_id', intval($track_id));
				$this->episodes_model->set('ix', intval($ix));
				$this->episodes_model->set('title', $title);
				$this->episodes_model->set('part', pg_null($part));
				$this->episodes_model->set('starting_chapter', pg_null($starting_chapter));
				$this->episodes_model->set('ending_chapter', pg_null($ending_chapter));
 				$this->episodes_model->set('season', intval($season));


			}

			redirect("/dvds/episodes/$dvd_id");

		}

		public function update_series_dvd($dvd_id) {

			/*
			$no_dvdnav = $this->input->post('no_dvdnav');
			if($no_dvdnav != 't')
				$no_dvdnav = 'f';
			*/

			$this->series_dvds_model->load_dvd($dvd_id);
			$this->series_dvds_model->set_series_id($this->input->post('series_id'));
			$this->series_dvds_model->set_audio_preference($this->input->post('audio_preference'));
			// $this->series_dvds_model->set_no_dvdnav($no_dvdnav);

			redirect("dvds/details/$dvd_id");

		}

		private function _estimate_next_episode($dvd_data) {

			extract($dvd_data);

			$using_chapters = false;


			$episode_tracks = array();
			$possible_tracks = array();

			$max_episode_ix = 1;

			$season = "";

			foreach($episodes as $episode_id => $arr) {

				// See if we are using chapters at all
				if(!(empty($starting_chapter) && empty($ending_chapter))) {
					$using_chapters = true;
				}

				$episode_tracks[] = $arr['track_id'];

				if($arr['ix'] > 1)
					$max_episode_ix = max($max_episode_ix, ($arr['ix'] + 1));

				$season = $arr['season'];

			}

			// Find the tracks that match possible lengths
			foreach($tracks as $track_id => $arr) {

				if(!in_array($track_id, $episode_tracks) && length_close_to_average($arr['length'], $series['average_length'])) {

					$possible_tracks[$arr['ix']] = $arr;
					$possible_tracks[$arr['ix']]['track_id'] = $track_id;

				}

			}

			$last_track_ix = $this->dvds_model->get_last_track_ix($dvds['id']);
			$last_episode_ix = $this->dvds_model->get_last_episode_ix($dvds['id']);

// 			var_dump($last_track_ix);
// 			var_dump($last_episode_ix);

			$data['track'] = current($possible_tracks);
			$data['ix'] = $max_episode_ix;
			$data['season'] = $season;

// 			var_dump($using_chapters);

// 			pre($possible_tracks);

//  			pre($dvd_data);

			return $data;

		}

	}


