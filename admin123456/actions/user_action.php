<?php
	require_once("../../includes/initialize.php");
	if(!$admin_session->is_logged_in()) {
		redirect_to("../login.php");
	}
	if (isset($_POST["editUser"])) {
		$id = $db->escape_value(trim($_POST['usr_id']));
		$user = User::find_by_id($id);
		$phone = $db->escape_value(trim($_POST['phone']));
		$isActvd = $db->escape_value(trim($_POST['isActvd']));
		if (!empty($phone)) {
			$user->phone = $phone;
		}
		if ($isActvd != "") {
			$user->isActvd = (int)$isActvd;
		}
		$return_url = "../index.php?tab=".$_POST["tab"];
		if ($user->update()) {
			redirect_to($return_url.'&ed_usr_suc=1');
		} else {
			redirect_to($return_url.'&err=1');
		}
	} elseif (isset($_GET['tab']) && isset($_GET['usr_id']) && isset($_GET['delUser'])) {
		$id = $db->escape_value(trim($_GET['usr_id']));
		$user = User::find_by_id($id);
		$return_url = "../index.php?tab=".$_GET["tab"];
		if ($user->delete()) {
			redirect_to($return_url.'&del_usr_suc=1');
		} else {
			redirect_to($return_url.'&err=1');
		}
	} else {
		$phone = "";
		$isActvd = "";
		$id="";
		$user="";
		$return_url = "";
		redirect_to("../");
	}
	if(isset($database)) { $database->close_connection(); }
?>