<?

	class Ajax_drives extends Controller {
	
		function __construct() {
		
			parent::Controller();
			
			$this->load->model('drives_model');
		
		}
		
		public function eject() {
		
			$this->drives_model->eject();
		
		}
		
		public function import_dvd($device = "/dev/dvd") {
		
			$this->drives_model->import($device);
		
		}

	}

?>