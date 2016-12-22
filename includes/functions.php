<?php
	function convert_to_camel_case ($str) {
		return mb_convert_case($str, MB_CASE_TITLE, "UTF-8");
	}
	function redirect_to( $location = NULL ) {
		if ($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}
	function generateRandomString($length = 8) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}
	function getOrderId($id=0) {
		return "OD".sprintf('%08d', $id);
	}
	function getFormatedDate($timestamp) {
		$ts = strtotime($timestamp);
		$time = getdate($ts);
		return $time['weekday'].' - '.$time['mday'].', '.substr($time['month'], 0, 3);
	}
	function delOptions($fish_id = "", $opt_class = "") {
		global $database;
		$options = $opt_class::getByFishId($fish_id);
		foreach ($options as $option) {
			$option->delete();
		}
	}
?>