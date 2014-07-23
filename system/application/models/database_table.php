<?

	/**
	 * @version 20100622a
	 */

	class Database_Table extends Model {

		protected $id;
		protected $data;
		protected $name;
		protected $primary_key;

		public function Database_Table() {

			parent::Model();
			$this->load->database();

			$this->primary_key = 'id';

		}

		public function __call($str, $args) {

			// Check to see if they are setting a column
			if(substr($str, 0, 4) === "set_" && strlen($str) > 4 && count($args)) {
				$key = substr($str, 4);
				$value = current($args);
				$this->set($key, $value);
			}

		}

		public function __toString() {

			return $this->id;

		}

		private function get_result_array($name = null) {

			if(is_null($name))
				$name = $this->name;
			$rs = $this->db->get($name);
			$arr = $rs->result_array();

			$rs->free_result();

			return $arr;

		}

		public function load($id) {

			if(!is_null($id))
				$this->id = $id;

		}

		public function set($mixed, $value = null) {

 			if(!is_null($this->id)) {
 				if(is_array($mixed))
					$this->db->set($mixed);
				else
					$this->db->set($mixed, $value);
				$this->db->where('id', $this->id);
				$this->db->update($this->name);
			}

		}

		public function create_new() {

			$sql = "INSERT INTO ".$this->db->escape_str($this->name)." DEFAULT VALUES;";
			$this->db->query($sql);

 			$this->id = $this->db->insert_id();

 			return $this->id;

		}

		public function delete($id = null) {

			if(is_null($id))
				$id = $this->id;

			$this->db->where($this->primary_key, $id);
			$this->db->delete($this->name);

		}

		public function get_all($name = null) {

			$arr = $this->get_result_array($name);
			return $arr;

		}

		public function get_assoc($name = null) {

			$arr = $this->get_result_array($name);

			$assoc = array();

			foreach($arr as $row) {
				$key = array_shift($row);
				if(count($row) != 1)
					$assoc[$key] = $row;
				else
					$assoc[$key] = current($row);
			}

			return $assoc;

		}

		public function get_col($name = null) {

			$arr = $this->get_result_array($name);

			$var = array();

			foreach($arr as $row) {
				$var[] = current($row);
			}

			return $var;

		}

		public function get_one($name = null) {

			$arr = $this->get_result_array($name);
			$var = null;

			if(count($arr))
				$var = current(current($arr));

			return $var;

		}

		public function get_row($name = null) {

			$arr = $this->get_result_array($name);

			$var = current($arr);
			return $var;

		}

		public function get_data($id) {

			$this->db->select('*');
			$this->db->where('id', $id);

			$arr = $this->get_row();

			return $arr;

		}

	}

?>
