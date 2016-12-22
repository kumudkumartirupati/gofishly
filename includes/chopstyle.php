<?php
	require_once(LIB_PATH.DS.'db.php');
	class ChopStyle extends DbObject {
		protected static $table_name="chop_style";
		protected static $db_fields = array('id', 'fsh_id', 'isPrm', 'style');
		public $id;
		public $fsh_id;
		public $isPrm;
		public $style;
		public static function getChRegStyleByFishId($fsh_id = "") {
			global $database;
			$results = self::find_rows_by_sql("SELECT style FROM ".self::$table_name." WHERE isPrm='0' AND fsh_id='".$database->escape_value($fsh_id)."'");
			return $results;
		}
		public static function getChRegObjectsByFishId($fsh_id = "") {
			global $database;
			$results = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE isPrm='0' AND fsh_id='".$database->escape_value($fsh_id)."'");
			return $results;
		}
		public static function getChPrmStyleByFishId($fsh_id = "") {
			global $database;
			$results = self::find_rows_by_sql("SELECT style FROM ".self::$table_name." WHERE isPrm='1' AND fsh_id='".$database->escape_value($fsh_id)."'");
			return $results;
		}
		public static function getChPrmObjectsByFishId($fsh_id = "") {
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