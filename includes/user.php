<?php
	require_once(LIB_PATH.DS.'db.php');
	class User extends DbObject {	
		protected static $table_name="users";
		protected static $db_fields = array('id', 'fname', 'lname', 'nationality', 'national_id', 'landmark', 'bld_id', 'build_pop_name', 'flat_num', 'fam_num', 'phone', 'email', 'isActvd', 'password');
		public $id;
		public $fname;
		public $lname;
		public $nationality;
		public $national_id;
		public $landmark;
		public $bld_id;
		public $build_pop_name;
		public $flat_num;
		public $fam_num;
		public $phone;
		public $email;
		public $isActvd;
		public $password;
		public function full_name() {
			if(isset($this->fname) && isset($this->lname)) {
				return $this->fname . " " . $this->lname;
			} else {
				return "";
			}
		}
		public static function authenticate($username="", $password="") {
			global $database;
			$username = $database->escape_value(trim($username));
			$password = $database->escape_value($password);
			$sql  = "SELECT * FROM " . self::$table_name;
			$sql .= " WHERE phone = '{$username}' ";
			$sql .= "AND BINARY password = '{$password}' ";
			$sql .= "LIMIT 1";
			$result_array = self::find_by_sql($sql);
			return !empty($result_array) ? array_shift($result_array) : false;
		}
		public function not_valid_form() {
			global $database;
			$form_check_list = array('fname', 'lname', 'nationality', 'national_id', 'landmark', 'bld_id', 'build_pop_name', 'flat_num', 'fam_num', 'email', 'phone');
			foreach ($form_check_list as $form_check) {
				if (!isset($this->$form_check) || empty($this->$form_check)) {
					$this->$form_check = "";
					return "checkout.php?err_{$form_check}=1";
				}
			}
			return false;
		}
		public function not_phone() {
			global $database;
			$query_pc_check = "SELECT * FROM " . self::$table_name . " WHERE phone = '{$this->phone}'";
			$result_pc_set = $database->query($query_pc_check);
			if (!preg_match('/^[1-9]{1}[0-9]{7}[0-9]{1}$/', $this->phone)) {
				$this->phone = "";
				return "checkout.php?inv_ph=1";
			} elseif($database->num_rows($result_pc_set) == 1) {
				$this->phone = "";
				return "checkout.php?err_reg_phone=1";
			} else {
				return false;
			}
		}
	}
?>