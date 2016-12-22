<?php
	require_once("../../includes/initialize.php");
	if(!$admin_session->is_logged_in()) {
		redirect_to("../login.php");
	}
	if (isset($_POST["editOrder"])) {
		$id = $db->escape_value(trim($_POST['ord_id']));
		$order = Order::find_by_id($id);
		$tracking = $db->escape_value(trim($_POST['tracking']));
		$status = $db->escape_value(trim($_POST['status']));
		$remarks = $db->escape_value(trim($_POST['remarks']));
		if (!empty($tracking)) {
			$order->tracking = $tracking;
		}
		if (!empty($remarks)) {
			$order->remarks = $remarks;
		}
		if ($status != "") {
			$order->status = $status;
		}
		$return_url = "../index.php?tab=".$_POST["tab"];
		if ($order->update()) {
			redirect_to($return_url.'&ed_ord_suc=1');
		} else {
			redirect_to($return_url.'&err=1');
		}
	} elseif (isset($_GET['tab']) && isset($_GET['ord_id']) && isset($_GET['delOrder'])) {
		$id = $db->escape_value(trim($_GET['ord_id']));
		$order = Order::find_by_id($id);
		$return_url = "../index.php?tab=".$_GET["tab"];
		if ($order->delete()) {
			redirect_to($return_url.'&del_ord_suc=1');
		} else {
			redirect_to($return_url.'&err=1');
		}
	} else {
		$tracking = "";
		$status = "";
		$id="";
		$order="";
		$return_url = "";
		redirect_to("../");
	}
	if(isset($database)) { $database->close_connection(); }
?>