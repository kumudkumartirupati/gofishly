<?php
	require_once("../../includes/initialize.php");
	if (isset($_POST["login"])) {
		$email = trim($_POST['email']);
		$password = $_POST['password'];
		$return_url = base64_decode($_POST["return_url"]);
		$found_admin = Admin::authenticate($email, $password);
		if ($found_admin) {
			$admin_session->login($found_admin);
			if (!empty($return_url)) {
				redirect_to($return_url);
			} else {
				redirect_to('../');
			}
		} else {
			redirect_to('../login.php?err=1'.'&return_url='.$_POST["return_url"]);
		}
	} elseif (isset($_GET["lo"]) && $_GET['lo'] == 1 && isset($_GET["return_url"])) {
		$return_url = base64_decode($_GET["return_url"]);
		$admin_session->logout();
		redirect_to($return_url);
	} else {
		$phone = "";
		$password = "";
		redirect_to("../");
	}
	if(isset($database)) { $database->close_connection(); }
?>