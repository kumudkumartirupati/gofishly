<?php
	require_once(LIB_PATH.DS.'db.php');
	class Building extends DbObject {
		protected static $table_name="buildings";
		protected static $db_fields = array('id', 'area_name', 'sarea_name', 'street_name', 'bldng_name');
		public $id;
		public $area_name;
		public $sarea_name;
		public $street_name;
		public $bldng_name;
		public static function getAllAreas() {
			global $database;
			$results = self::find_rows_by_sql("SELECT DISTINCT area_name FROM ".self::$table_name);
			return $results;
		}
		public static function getSubAreas($area = "") {
			global $database;
			$results = self::find_rows_by_sql("SELECT DISTINCT sarea_name FROM ".self::$table_name." WHERE area_name='{$area}'");
			return $results;
		}
		public static function getStreets($sarea = "", $area = "") {
			global $database;
			$results = self::find_rows_by_sql("SELECT DISTINCT street_name FROM ".self::$table_name." WHERE sarea_name='{$sarea}' AND area_name='{$area}'");
			return $results;
		}
		public static function getBuildingObjects($street = "", $sarea = "", $area = "") {
			global $database;
			$results = self::find_by_sql("SELECT * FROM ".self::$table_name." WHERE street_name='{$street}' AND sarea_name='{$sarea}' AND area_name='{$area}'");
			return $results;
		}
	}
?>