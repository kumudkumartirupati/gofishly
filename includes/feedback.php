<?php
	require_once(LIB_PATH.DS.'db.php');
	class Feedback extends DbObject {
		protected static $table_name="feedback";
		protected static $db_fields = array('id', 'usr_id', 'subject', 'message');
		public $id;
		public $usr_id;
		public $subject;
		public $message;
	}
?>