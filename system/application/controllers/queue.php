<?php

	class Queue extends Controller {

		function Queue() {
			parent::Controller();
		}

		function delete($episode_id) {

			$this->queue_model->delete_episode($episode_id);
			redirect("/queue");

		}

		function delete_series($series_id) {

			$this->queue_model->delete_series($series_id);
			redirect("/queue");

		}

		function reset() {

			$this->queue_model->reset();
			redirect("/");

		}

		function index() {

			$total_episodes = 0;

			$data['series'] = $this->queue_model->get_series();

			$this->load->view('css/style');
			$this->load->view('jquery');
			$this->load->view('js/drives');
			$this->load->view('html_title');
			$this->load->view('queue_header');

			foreach($data['series'] as $key => $arr) {
				extract($arr);
				$data['series'][$key]['num_episodes'] = count($this->queue_model->get_queue($series_id));
				$total_episodes += $data['series'][$key]['num_episodes'];
			}

			if($total_episodes) {

				$this->load->view('queue_series', $data);

				foreach($data['series'] as $arr) {
					extract($arr);
					$data['series_title'] = $series_title;
					$data['series_id'] = $series_id;
					$data['queue'] = $this->queue_model->get_queue($series_id);
					$this->load->view('queue_episodes', $data);
				}

				$this->load->view('queue_reset');

			}

		}

	}
