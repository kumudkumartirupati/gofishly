<?php 
	require_once("../includes/initialize.php");
	if(isset($_GET["rm_all"]) && $_GET["rm_all"]==1) {
		$return_url = base64_decode($_GET["return_url"]);
		$cart_session->clearCart();
		redirect_to($return_url);
	} elseif (isset($_POST["addorder"])) {
		$fish = Fish::find_by_id((int)$_POST["fsh_id"]);
		$return_url = base64_decode($_POST["return_url"]);
		$breed = $db->escape_value($_POST["breed"]);
		$type = $db->escape_value($_POST["type"]);
		$qtty = $db->escape_value($_POST["qtty"]);
		$isPrm = $db->escape_value($_POST["quality"]);
		$price = $db->escape_value($_POST["price"]);
		$pr_opt = $db->escape_value($_POST["pr_opt"]);
		$pk_opt = $db->escape_value($_POST["pk_opt"]);
		$cl_style = $db->escape_value($_POST["cl_style"]);
		$ch_style = $db->escape_value($_POST["ch_style"]);
		$id = $fish->id;
		if($qtty > 50 || $qtty < 1) {
			redirect_to($return_url.'&err=1');
		}
		if ($fish) {
			$new_fish = array(array('breed'=>$breed, 'type'=>$type, 'qtty'=>$qtty, 'price'=>$price, 'cl_style'=>$cl_style, 'ch_style'=>$ch_style, 'pk_opt'=>$pk_opt, 'isPrm'=>$isPrm, 'id'=>$id, 'pr_opt'=>$pr_opt));		
			if($cart_session->isAddedToCart()) {
				$found = false;			
				foreach ($cart_session->fishes as $cart_itm) {
					if($cart_itm["id"] == $id && $cart_itm["cl_style"] == $cl_style && $cart_itm["ch_style"] == $ch_style && $cart_itm["pk_opt"] == $pk_opt && $cart_itm["isPrm"] == $isPrm) {
						$temp = $cart_itm['qtty'] + $qtty;
						$product[] = array('breed'=>$cart_itm['breed'], 'type'=>$cart_itm['type'], 'qtty'=>$temp, 'price'=>$cart_itm['price'], 'cl_style'=>$cart_itm['cl_style'], 'ch_style'=>$cart_itm['ch_style'], 'pk_opt'=>$cart_itm['pk_opt'], 'isPrm'=>$cart_itm['isPrm'], 'id'=>$cart_itm['id'], 'pr_opt'=>$cart_itm['pr_opt']);
						$found = true;
					} else {
						$product[] = array('breed'=>$cart_itm['breed'], 'type'=>$cart_itm['type'], 'qtty'=>$cart_itm['qtty'], 'price'=>$cart_itm['price'], 'cl_style'=>$cart_itm['cl_style'], 'ch_style'=>$cart_itm['ch_style'], 'pk_opt'=>$cart_itm['pk_opt'], 'isPrm'=>$cart_itm['isPrm'], 'id'=>$cart_itm['id'], 'pr_opt'=>$cart_itm['pr_opt']);
					}
				}
				if($found == false) {
					$cart_session->addToCart(array_merge($product, $new_fish));
				} else {
					$cart_session->addToCart($product);
				}			
			} else {
				$cart_session->addToCart($new_fish);
			}		
		}
		redirect_to($return_url);
	} elseif (isset($_GET["rm"]) && isset($_GET["return_url"]) && $cart_session->isAddedToCart() && isset($_GET["cl_style"]) && isset($_GET["ch_style"]) && isset($_GET["pk_opt"]) && isset($_GET["isPrm"])) {
		$id = (int)$_GET["rm"];
		$return_url = base64_decode($_GET["return_url"]);
		$cl_style = $_GET["cl_style"];
		$ch_style = $_GET["ch_style"];
		$pk_opt = $_GET["pk_opt"];
		$isPrm = $_GET["isPrm"];
		foreach ($cart_session->fishes as $cart_itm) {
			if (!($cart_itm["id"] == $id && $cart_itm["cl_style"] == $cl_style && $cart_itm["ch_style"] == $ch_style && $cart_itm["pk_opt"] == $pk_opt && $cart_itm["isPrm"] == $isPrm)) {
				$product[] = array('breed'=>$cart_itm['breed'], 'type'=>$cart_itm['type'], 'qtty'=>$cart_itm['qtty'], 'price'=>$cart_itm['price'], 'cl_style'=>$cart_itm['cl_style'], 'ch_style'=>$cart_itm['ch_style'], 'pk_opt'=>$cart_itm['pk_opt'], 'isPrm'=>$cart_itm['isPrm'], 'id'=>$cart_itm['id'], 'pr_opt'=>$cart_itm['pr_opt']);
			}
		}
		if (count($product) > 0) {
			$cart_session->addToCart($product);
		} else {
			$cart_session->clearCart();
		}
		redirect_to($return_url);
	} else {
		redirect_to('../');
	}
	if(isset($database)) { $database->close_connection(); }
?>