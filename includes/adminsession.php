<?php
	class AdminSession {	
		private $logged_in=false;
		public $adm_id;
		function __construct() {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$this->check_login();
		}
		public function is_logged_in() {
			return $this->logged_in;
		}
		public function login($admin) {
			if ($admin) {
				$this->adm_id = $_SESSION['adm_id'] = $admin->id;
				$this->logged_in = true;
			}
		}
		public function logout() {
			if ($this->logged_in) {
				unset($_SESSION['adm_id']);
				unset($this->adm_id);
				$this->logged_in = false;
			}
		}
		private function check_login() {
			if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 300)) {
				unset($_SESSION['adm_id']);
				unset($this->adm_id);
				$this->logged_in = false;
			} elseif (isset($_SESSION['adm_id'])) {
				$this->adm_id = $_SESSION['adm_id'];
				$this->logged_in = true;
			} else {
				unset($this->adm_id);
				$this->logged_in = false;
			}
			$_SESSION['LAST_ACTIVITY'] = time();
		}
	}
	$admin_session = new AdminSession();
?>