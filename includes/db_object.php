<?php
	require_once(LIB_PATH.DS.'db.php');
	class DbObject {
		protected static $table_name;
		protected static $db_fields = array();
		public static function find_all() {
			return static::find_by_sql("SELECT * FROM ".static::$table_name);
		}
		public static function find_by_sql($sql="") {
			global $database;
			$result_set = $database->query($sql);
			$object_array = array();
			while ($row = $database->fetch_array($result_set)) {
				$object_array[] = static::instantiate($row);
			}
			return $object_array;
		}
		public static function find_rows_by_sql($sql="") {
			global $database;
			$result_set = $database->query($sql);
			$result_array = array();
			while ($row = $database->fetch_array($result_set)) {
				$result_array[] = $row[0];
			}
			return $result_array;
		}
		public static function find_by_id($id=0) {
			global $database;
			$result_array = static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id=".$database->escape_value($id)." LIMIT 1");
			return !empty($result_array) ? array_shift($result_array) : false;
		}
		private static function instantiate($record) {
			$class_name = get_called_class();
			$object = new $class_name;
			foreach($record as $attribute=>$value){
				if($object->has_attribute($attribute)) {
					$object->$attribute = $value;
				}
			}
			return $object;
		}
		private function has_attribute($attribute) {
			return array_key_exists($attribute, $this->attributes());
		}
		protected function attributes() {
			$attributes = array();
			foreach(static::$db_fields as $field) {
				if(property_exists($this, $field)) {
					$attributes[$field] = $this->$field;
				}
			}
			return $attributes;
		}
		protected function sanitized_attributes() {
			global $database;
			$clean_attributes = array();
			foreach($this->attributes() as $key => $value){
				if ($key != "id") {
					$clean_attributes[$key] = $database->escape_value($value);
				}
			}
			return $clean_attributes;
		}
		public function save() {
			return isset($this->id) ? $this->update() : $this->create();
		}
		public function create() {
			global $database;
			$attributes = $this->sanitized_attributes();
			$sql = "INSERT INTO ".static::$table_name." (";
			$sql .= join(", ", array_keys($attributes));
			$sql .= ") VALUES ('";
			$sql .= join("', '", array_values($attributes));
			$sql .= "')";
			if($database->query($sql)) {
				$this->id = $database->insert_id();
				return true;
			} else {
				return false;
			}
		}
		public function update() {
			global $database;
			$attributes = $this->sanitized_attributes();
			$attribute_pairs = array();
			foreach($attributes as $key => $value) {
				if (!empty($value)) {
					$attribute_pairs[] = "{$key}='{$value}'";
				}
			}
			$sql = "UPDATE ".static::$table_name." SET ";
			$sql .= join(", ", $attribute_pairs);
			$sql .= " WHERE id=". $database->escape_value($this->id);
			$database->query($sql);
			return ($database->affected_rows() == 1) ? true : false;
		}
		public function delete() {
			global $database;
			$sql = "DELETE FROM ".static::$table_name;
			$sql .= " WHERE id=". $database->escape_value($this->id);
			$sql .= " LIMIT 1";
			$database->query($sql);
			return ($database->affected_rows() == 1) ? true : false;
		}
	}
?>