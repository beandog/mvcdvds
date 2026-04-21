<?php

	class Home_Dir extends CI_Model {

		protected $id;
		protected $data;
		protected $name;
		protected $primary_key;

		public $dir = '.';

		public function Home_Dir() {

			parent::Model();

			$this->dir = realpath(".");

		}

		public function get_isos() {

			$scandir = scandir($this->dir);

			$arr = preg_grep("/\.iso$/", $scandir);

			return $arr;

		}

	}

?>
