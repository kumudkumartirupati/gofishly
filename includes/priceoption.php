<?php
	require_once(LIB_PATH.DS.'db.php');
	class PriceOption extends DbObject {
		protected static $table_name="price_opt";
		protected static $db_fields = array('id', 'fsh_id', 'isPrm', 'opt_name', 'price');
		public $id;
		public $fsh_id;
		public $isPrm;
		public $opt_name;
		public $price;
		public static function getPrRegObjectsByFishId($fsh_id = "") {
			global $database;
			$results = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE isPrm='0' AND fsh_id='".$database->escape_value($fsh_id)."'");
			return $results;
		}
		public static function getPrPrmObjectsByFishId($fsh_id = "") {
			global $database;
			$results = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE isPrm='1' AND fsh_id='".$database->escape_value($fsh_id)."'");
			return $results;
		}
		public static function getPrmPriceCumOption($fsh_id = "") {
			global $database;
			$temp = array();
			$results = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE isPrm='1' AND fsh_id='".$database->escape_value($fsh_id)."'");
			foreach ($results as $result) {
				$temp[] = $result->opt_name." (".$result->price.")";
			}
			return $temp;
		}
		public static function getRegPriceCumOption($fsh_id = "") {
			global $database;
			$temp = array();
			$results = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE isPrm='0' AND fsh_id='".$database->escape_value($fsh_id)."'");
			foreach ($results as $result) {
				$temp[] = $result->opt_name." (".$result->price.")";
			}
			return $temp;
		}
		public static function getByFishId($fsh_id = "") {
			global $database;
			$results = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE fsh_id='".$database->escape_value($fsh_id)."'");
			return $results;
		}
	}
?>