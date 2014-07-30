<?php

	class Queue extends Controller {

		function Queue() {
			parent::Controller();
		}

		function delete($episode_id) {

			$this->queue_model->delete_episode($episode_id);
			redirect("/");

		}

		function reset() {

			$this->queue_model->reset();

			redirect("/");

		}

		function index() {

			$data['queue'] = $this->queue_model->get_queue();
			$this->load->view('css/style');
			$this->load->view('jquery');
			$this->load->view('js/drives');
			$this->load->view('html_title', $data);
			$this->load->view('queue');
			$this->load->view('queue_reset');

		}

	}
