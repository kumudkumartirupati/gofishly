<?php
	class CartSession {
		private $addedToCart = false;
		public $fishes;
		function __construct() {
			if (session_status() == PHP_SESSION_NONE) {
				session_start();
			}
			$this->ifAdded();
		}
		public function isAddedToCart() {
			return $this->addedToCart;
		}
		public function addToCart($fish) {
			if($fish){
				$this->fishes = $_SESSION['fishes'] = $fish;
				$this->addedToCart = true;
			}
		}
		public function clearCart() {
			if($this->addedToCart) {
				unset($_SESSION['fishes']);
				unset($this->fishes);
				$this->addedToCart = false;
			}
		}
		private function ifAdded() {
			if(isset($_SESSION['fishes'])) {
				$this->fishes = $_SESSION['fishes'];
				$this->addedToCart = true;
			} else {
				unset($this->fishes);
				$this->addedToCart = false;
			}
		}
	}
	$cart_session = new CartSession();
?>