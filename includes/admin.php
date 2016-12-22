<?php
	require_once(LIB_PATH.DS.'db.php');
	class Admin extends DbObject {	
		protected static $table_name="admins";
		protected static $db_fields = array('id', 'name', 'email', 'role', 'password');
		public $id;
		public $name;
		public $email;
		public $role;
		public $password;
		public function register_admin() {
			global $database;
			$this->form_validation();
			return $this->create();
		}
		public function update_admin($adm_id = "") {
			global $database;
			$this->form_validation2();
			$sql = "UPDATE " . self::$table_name . " SET fname = '{$this->fname}', lname = '{$this->lname}', adln1 = '{$this->adln1}', adln2 = '{$this->adln2}', landmark = '{$this->landmark}', city = '{$this->city}', pincode = '{$this->pincode}', state = '{$this->state}', email = '{$this->email}' WHERE id = '{$adm_id}'";
			$database->query($sql);
		}
		public function update_pwd($adm_id = "") {
			global $database;
			$sql = "UPDATE " . self::$table_name . " SET password = '{$this->password}' WHERE id = '{$adm_id}'";
			$database->query($sql);
		}
		public static function authenticate($username="", $password="") {
			global $database;
			$username = $database->escape_value(trim($username));
			$password = $database->escape_value($password);
			$sql  = "SELECT * FROM " . self::$table_name;
			$sql .= " WHERE email = '{$username}' ";
			$sql .= "AND BINARY password = '{$password}' ";
			$sql .= "LIMIT 1";
			$result_array = self::find_by_sql($sql);
			return !empty($result_array) ? array_shift($result_array) : false;
		}
		private function form_validation() {
			global $database;
			$form_check_list = array('fname', 'lname', 'adln1', 'city', 'pincode', 'phone');
			foreach ($form_check_list as $form_check) {
				if (!isset($this->$form_check) || empty($this->$form_check)) {
					redirect_to("../views/checkout.php?err_{$form_check}=1");
				}
			}
			if ($this->state == "NAN") {
				redirect_to("../views/checkout.php?err_state=1");
			}
			if (!preg_match('/^[1-9]{1}[0-9]{2}\s{0,1}[0-9]{3}$/', $this->pincode)) {
				$this->pincode = "";
				redirect_to("../views/checkout.php?inv_pc=1");
			}
			if (!preg_match('/^[1-9]{1}[0-9]{8}[0-9]{1}$/', $this->phone)) {
				$this->phone = "";
				redirect_to("../views/checkout.php?inv_ph=1");
			}
			$query_pc_check = "SELECT * FROM " . self::$table_name . " WHERE phone = '{$this->phone}'";
			$result_pc_set = $database->query($query_pc_check);
			if($database->num_rows($result_pc_set) == 1) {
				redirect_to("../views/checkout.php?err_reg_phone=1");
			}
		}
	}
?>