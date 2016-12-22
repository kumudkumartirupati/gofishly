<?php
	require_once(LIB_PATH.DS.'db.php');
	class Order extends DbObject {
		protected static $table_name="orders";
		protected static $db_fields = array('id', 'usr_id', 'fsh_id', 'ch_style', 'cl_style', 'pk_opt', 'pr_opt', 'amount', 'qtty', 'isPrm', 'remarks', 'status', 'tracking', 'address', 'timestamp');
		public $id;
		public $usr_id;
		public $fsh_id;
		public $ch_style;
		public $cl_style;
		public $pk_opt;
		public $pr_opt;
		public $amount;
		public $qtty;
		public $isPrm;
		public $remarks;
		public $status;
		public $tracking;
		public $address;
		public $timestamp;
		public static function orders_by_usr_id($id=0) {
			global $database;
			$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE usr_id='".$database->escape_value($id)."' ORDER BY timestamp DESC");
			return $result_array;
		}
		public static function find_all_by_time() {
			global $database;
			$result_array = self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY timestamp DESC");
			return $result_array;
		}
	}
?>