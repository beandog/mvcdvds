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


	}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
