<?

	class Drives_Model extends Model {

		public function Drives_Model() {

			parent::Model();

			$this->device = "/dev/dvd";

		}

		public function eject() {

			$output = system("eject");
			$output = system("whoami");
			var_dump($output);

		}

		public function import() {

			$foo = system("php /home/steve/git/bend/dvd.php import");
			var_dump($foo);

		}

	}
