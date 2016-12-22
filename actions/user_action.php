<?php
	require_once("../includes/initialize.php");
	if (isset($_POST["login"])) {
		$phone = trim($_POST['uname']);
		$password = $_POST['pwd'];
		$return_url = base64_decode($_POST["return_url"]);
		$found_user = User::authenticate($phone, $password);
		if ($found_user) {
			$user_session->login($found_user);
			redirect_to($return_url);
		} else {
			redirect_to($return_url.'&err=1');
		}
	} elseif (isset($_GET["lo"]) && $_GET['lo'] == 1 && isset($_GET["return_url"])) {
		$return_url = base64_decode($_GET["return_url"]);
		$user_session->logout();
		redirect_to($return_url);
	} elseif (isset($_POST["ajax_login"])) {
		$phone = trim($_POST['uname']);
		$password = $_POST['pwd'];
		$found_user = User::authenticate($phone, $password);
		if ($found_user) {
			$user_session->login($found_user);
			$array = array();
            $array['status'] = 1;
            $array['html'] = '<div class="alert alert-success" role="alert">Logged In Successfully!! Please Wait Till The Page Refreshes</div>';
			echo json_encode($array);
		} else {
			$array = array();
            $array['status'] = 0;
            $array['html'] = '<div class="alert alert-danger" role="alert">Invalid Username And Password Combination</div>';
			echo json_encode($array);
		}
	} else {
		$phone = "";
		$password = "";
		redirect_to("../");
	}
	if(isset($database)) { $database->close_connection(); }
?>