<?php
	require_once("../includes/initialize.php");
	if (isset($_POST["checkout"])) {
		if ($user_session->is_logged_in()) {
			$user = User::find_by_id($user_session->user_id);
		} else {
			$user = new User();
			$user->phone = $db->escape_value(trim($_POST['phone']));
			$user->isActvd = 0;
			$user->password = generateRandomString();
		}
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
		if ($user_session->is_logged_in()) {
			if($cart_session->isAddedToCart()) {
				$user->update();
				$bldng = Building::find_by_id($user->bld_id);
				$delivery_address = '<div class="center"><h2>'.convert_to_camel_case($user->full_name()).'</h2></div><strong>Building Details:&nbsp;</strong><p>Area Name: '.$bldng->area_name.', Sub Area Name: '.$bldng->sarea_name.'<br/>Street Name: '.$bldng->street_name.', Building Name: '.$bldng->bldng_name.'<br/></p><strong>Address:&nbsp;</strong><p>Landmark: '.convert_to_camel_case($user->landmark).', Building Popular Name: '.convert_to_camel_case($user->build_pop_name).',<br />Flat Number: '.$user->flat_num.', Family Number: '.$user->fam_num.'<br /></p><strong>Mobile Number:&nbsp;</strong><span>'.$user->phone.'</span><br/><strong>Email:&nbsp;</strong><span>'.$user->email.'</span>';
				foreach ($cart_session->fishes as $cart_itm) {
					$order = new Order();
					$order->usr_id = $user->id;
					$order->qtty = $cart_itm['qtty'];
					$order->amount = $cart_itm['price'] * $cart_itm['qtty'];
					$order->status = "Order Processing";
					$order->ch_style = $cart_itm['ch_style'];
					$order->cl_style = $cart_itm['cl_style'];
					$order->pk_opt = $cart_itm['pk_opt'];
					$order->pr_opt = $cart_itm['pr_opt'];
					$order->isPrm = $cart_itm['isPrm'];
					$order->fsh_id = $cart_itm['id'];
					$order->remarks = "No Remarks Yet";
					$order->tracking = "Not Yet Available";
					$order->timestamp = date('Y-m-d H:i:s');
					$order->address = $db->escape_value($delivery_address);
					$order->create();
				}
				$cart_session->clearCart();
				redirect_to('../views/confirm.php');
			} else {
				redirect_to('../views/checkout.php?err=1');
			}
		} elseif(!$user_session->is_logged_in()) {
			if ($temp = $user->not_valid_form()) {
				redirect_to('../views/'.$temp);
			} elseif ($temp = $user->not_phone()) {
				redirect_to('../views/'.$temp);
			} elseif($cart_session->isAddedToCart() && $user->create()) {
				$bldng = Building::find_by_id($user->bld_id);
				$delivery_address = '<div class="center"><h2>'.convert_to_camel_case($user->full_name()).'</h2></div><strong>Building Details:&nbsp;</strong><p>Area Name: '.$bldng->area_name.', Sub Area Name: '.$bldng->sarea_name.'<br/>Street Name: '.$bldng->street_name.', Building Name: '.$bldng->bldng_name.'<br/></p><strong>Address:&nbsp;</strong><p>Landmark: '.convert_to_camel_case($user->landmark).', Building Popular Name: '.convert_to_camel_case($user->build_pop_name).',<br />Flat Number: '.$user->flat_num.', Family Number: '.$user->fam_num.'<br /></p><strong>Mobile Number:&nbsp;</strong><span>'.$user->phone.'</span><br/><strong>Email:&nbsp;</strong><span>'.$user->email.'</span>';
				foreach ($cart_session->fishes as $cart_itm) {
					$order = new Order();
					$order->usr_id = $user->id;
					$order->qtty = $cart_itm['qtty'];
					$order->amount = $cart_itm['price'] * $cart_itm['qtty'];
					$order->status = "Order Processing";
					$order->ch_style = $cart_itm['ch_style'];
					$order->cl_style = $cart_itm['cl_style'];
					$order->pk_opt = $cart_itm['pk_opt'];
					$order->pr_opt = $cart_itm['pr_opt'];
					$order->isPrm = $cart_itm['isPrm'];
					$order->fsh_id = $cart_itm['id'];
					$order->remarks = "No Remarks Yet";
					$order->tracking = "Not Yet Available";
					$order->timestamp = date('Y-m-d H:i:s');
					$order->address = $db->escape_value($delivery_address);
					$order->create();
				}
				$cart_session->clearCart();
				redirect_to('../views/confirm.php');
			} else {
				redirect_to('../views/checkout.php?err=1');
			}
		} else {
			redirect_to('../views/checkout.php?err=1');
		}
	} else {
		redirect_to('../');
	}
	if(isset($database)) { $database->close_connection(); }
?>