<?php
	require_once("../../includes/initialize.php");
	if(!$admin_session->is_logged_in()) {
		redirect_to("../login.php");
	}
	if (isset($_GET['tab']) && isset($_GET['fb_id']) && isset($_GET['delFb'])) {
		$id = $db->escape_value(trim($_GET['fb_id']));
		$fb = Feedback::find_by_id($id);
		$return_url = "../index.php?tab=".$_GET["tab"];
		if ($fb->delete()) {
			redirect_to($return_url.'&del_fb_suc=1');
		} else {
			redirect_to($return_url.'&err=1');
		}
	} else {
		$id="";
		$fb="";
		$return_url = "";
		redirect_to("../");
	}
	if(isset($database)) { $database->close_connection(); }
?>