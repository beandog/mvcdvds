<?

	class Home_Dir extends Model {
	
		protected $id;
		protected $data;
		protected $name;
		protected $primary_key;
	
		public function Home_Dir() {
		
			parent::Model();
			
			$this->dir = "/home/steve/dvds";

		}
		
		public function get_isos() {
		
			$scandir = scandir($this->dir);
			
			$arr = preg_grep("/\.iso$/", $scandir);
			
			return $arr;
		
		}
		
	}

?>