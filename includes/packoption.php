<?php
	require_once(LIB_PATH.DS.'db.php');	
	class PackOption extends DbObject {
		protected static $table_name="pack_opt";
		protected static $db_fields = array('id', 'fsh_id', 'isPrm', 'opt_name');
		public $id;
		public $fsh_id;
		public $isPrm;
		public $opt_name;
		public static function getPkRegOptByFishId($fsh_id = "") {
			global $database;
			$results = self::find_rows_by_sql("SELECT opt_name FROM ".self::$table_name." WHERE isPrm='0' AND fsh_id='".$database->escape_value($fsh_id)."'");
			return $results;
		}
		public static function getPkRegObjectsByFishId($fsh_id = "") {
			global $database;
			$results = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE isPrm='0' AND fsh_id='".$database->escape_value($fsh_id)."'");
			return $results;
		}
		public static function getPkPrmOptByFishId($fsh_id = "") {
			global $database;
			$results = self::find_rows_by_sql("SELECT opt_name FROM ".self::$table_name." WHERE isPrm='1' AND fsh_id='".$database->escape_value($fsh_id)."'");
			return $results;
		}
		public static function getPkPrmObjectsByFishId($fsh_id = "") {
			global $database;
			$results = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE isPrm='1' AND fsh_id='".$database->escape_value($fsh_id)."'");
			return $results;
		}
		public static function getByFishId($fsh_id = "") {
			global $database;
			$results = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE fsh_id='".$database->escape_value($fsh_id)."'");
			return $results;
		}
	}
?>