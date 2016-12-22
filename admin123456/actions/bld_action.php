<?php
	require_once("../../includes/initialize.php");
	if(!$admin_session->is_logged_in()) {
		redirect_to("../login.php");
	}
	if (isset($_POST["addBldng"])) {
		$bldng = new Building();
		$bldng->bldng_name = $db->escape_value(convert_to_camel_case(trim($_POST['bldng'])));
		$bldng->street_name = $db->escape_value(convert_to_camel_case(trim($_POST['street'])));
		$bldng->sarea_name = $db->escape_value(convert_to_camel_case(trim($_POST['sarea'])));
		$bldng->area_name = $db->escape_value(convert_to_camel_case(trim($_POST['area'])));		
		$return_url = "../index.php?tab=".$_POST["tab"];
		if ($bldng->bldng_name != "" && $bldng->street_name != "" && $bldng->sarea_name != "" && $bldng->area_name != "") {
			$bldng->create();
			redirect_to($return_url.'&add_bldng_suc=1');
		} else {
			redirect_to($return_url.'&add_bldng_err=1');
		}
	} elseif (isset($_GET['tab']) && isset($_GET['bldng']) && isset($_GET['delBldng'])) {
		$id = $db->escape_value(trim($_GET['bldng']));
		$bldng = Building::find_by_id($id);
		$return_url = "../index.php?tab=".$_GET["tab"];
		if ($bldng->delete()) {
			redirect_to($return_url.'&del_bldng_suc=1');
		} else {
			redirect_to($return_url.'&err=1');
		}
	} else {
		$bldng = "";
		$id = "";
		$return_url = "";
		redirect_to("../");
	}
	if(isset($database)) { $database->close_connection(); }
?>