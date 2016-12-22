<?php
	require_once("../includes/initialize.php");
	if (isset($_POST["sub_area"])) {
		$area = $db->escape_value($_POST["area"]);
		if ($area != "") {
			$sareas = Building::getSubAreas($area);
			echo '<option value="">Select A Sub Area</option>';
			foreach ($sareas as $sarea) {
				echo '<option value="'.$sarea.'">'.$sarea.'</option>';
			}
		} else {
			echo "";
		}
	} elseif (isset($_POST["get_street"])) {
		$area = $db->escape_value($_POST["area"]);
		$sarea = $db->escape_value($_POST["sarea"]);
		if ($sarea != "" && $area != "") {
			$streets = Building::getStreets($sarea, $area);
			echo '<option value="">Select A Street Name</option>';
			foreach ($streets as $street) {
				echo '<option value="'.$street.'">'.$street.'</option>';
			}
		} else {
			echo "";
		}
	} elseif (isset($_POST["building"])) {
		$area = $db->escape_value($_POST["area"]);
		$sarea = $db->escape_value($_POST["sarea"]);
		$street = $db->escape_value($_POST["street"]);
		if ($sarea != "" && $area != "" && $street != "") {
			$bldngs = Building::getBuildingObjects($street, $sarea, $area);
			echo '<option value="">Select A Building Name</option>';
			foreach ($bldngs as $bldng) {
				echo '<option value="'.$bldng->id.'">'.$bldng->bldng_name.'</option>';
			}
		} else {
			echo "";
		}
	} elseif(!$user_session->is_logged_in()) {
		redirect_to("../");
	} elseif (isset($_POST["ch_contact"])) {
		$user = User::find_by_id($user_session->user_id);
		$user->fname = $db->escape_value(trim($_POST['fname']));
		$user->lname = $db->escape_value(trim($_POST['lname']));
		$user->nationality = $db->escape_value(trim($_POST['nationality']));
		$user->national_id = $db->escape_value(trim($_POST['national_id']));
		$user->landmark = $db->escape_value(trim($_POST['landmark']));
		$user->bld_id = $db->escape_value((int)$_POST['bld_id']);
		$user->build_pop_name = $db->escape_value(trim($_POST['build_pop_name']));
		$user->flat_num = $db->escape_value(trim($_POST['flat_num']));
		$user->fam_num = $db->escape_value(trim($_POST['fam_num']));
		$user->email = $db->escape_value(trim($_POST['email']));
		$return_url = "../views/ac_stngs.php?tab=".$_POST["tab"];
		if ($user->update()) {
			redirect_to($return_url.'&chc_suc=1');
		} else {
			redirect_to($return_url.'&err=1');
		}
	} elseif (isset($_POST["ch_pass"])) {
		$return_url = "../views/ac_stngs.php?tab=".$_POST["tab"];
		if ($user_session->is_logged_in()) {
			$n_pass = trim($_POST['n_pass']);
			$c_pass = trim($_POST['c_pass']);
			$nr_pass = trim($_POST['nr_pass']);
			$temp_user = User::find_by_id($user_session->user_id);
			if($c_pass == $temp_user->password) {
				if($n_pass == $nr_pass && $n_pass != "") {
					$temp_user->password = $db->escape_value($n_pass);
					$temp_user->update();
					redirect_to($return_url.'&chc_suc=1');
				} else {
					redirect_to($return_url.'&err_repass=1');
				}				
			} else {
				redirect_to($return_url.'&err_pass=1');
			}
		} else {
			redirect_to($return_url.'&err=1');
		}
	} elseif (isset($_POST["feedback"])) {
		$return_url = "../views/ac_stngs.php?tab=".$_POST["tab"];
		if ($user_session->is_logged_in()) {
			$feedback = new Feedback();
			$feedback->usr_id = trim($user_session->user_id);
			$feedback->subject = trim($_POST['subject']);
			$feedback->message = nl2br(trim($_POST['message']));
			$feedback->create();
			redirect_to($return_url.'&chc_suc=1');
		} else {
			redirect_to($return_url.'&err=1');
		}
	} else {
		redirect_to('../views/ac_stngs.php?err=1');
	}
	if(isset($database)) { $database->close_connection(); }
?>