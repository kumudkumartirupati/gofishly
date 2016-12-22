<?php
    require_once("../includes/initialize.php");
    if (isset($_GET['fsh_id'])) {
    	$fish = Fish::find_by_id((int)$_GET['fsh_id']);
    	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    	if(!$fish) {
    		redirect_to("../");
    	}
    } else {
    	redirect_to("../");
    }
    if (isset($_GET['prem']) && $_GET['prem'] == 1 && $fish->hasPrm) {
    	$premium = 1;
    	$ch_styles = ChopStyle::getChPrmStyleByFishId($fish->id);
    	$cl_styles = CleanStyle::getClPrmStyleByFishId($fish->id);
    	$pr_opts = PriceOption::getPrPrmObjectsByFishId($fish->id);
    	$pk_opts = PackOption::getPkPrmOptByFishId($fish->id);
    	$word = " Premium";
    } elseif (isset($_GET['prem']) && $_GET['prem'] == 0 && !$fish->hasPrm) {
    	$premium = 0;
    	$ch_styles = ChopStyle::getChRegStyleByFishId($fish->id);
    	$cl_styles = CleanStyle::getClRegStyleByFishId($fish->id);
    	$pr_opts = PriceOption::getPrRegObjectsByFishId($fish->id);
    	$pk_opts = PackOption::getPkRegOptByFishId($fish->id);
    	$word = " Regular";
    } elseif (isset($_GET['prem']) && $_GET['prem'] == 0 && $fish->hasPrm == 2) {
    	$premium = 0;
    	$ch_styles = ChopStyle::getChRegStyleByFishId($fish->id);
    	$cl_styles = CleanStyle::getClRegStyleByFishId($fish->id);
    	$pr_opts = PriceOption::getPrRegObjectsByFishId($fish->id);
    	$pk_opts = PackOption::getPkRegOptByFishId($fish->id);
    	$word = " Regular";
    } else {
    	redirect_to("../");
    }
    $title = "Place Order - Go Fishly";
    if($user_session->is_logged_in()) {
        $user = User::find_by_id($user_session->user_id);
        $logged_in = true;
        $user_name = convert_to_camel_case($user->full_name());
    }
    include "header.php";
?>
<div class="panel panel-default">
	<br /><br /><br />
	<div class="panel-body">
		<div class="navbar navbar-default">
			<div class="center">
				<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
					<br /><br />
					<?php 
						if (isset($_GET['err']) && $_GET['err'] == 1) {
							echo '<br /><div class="alert alert-danger" role="alert">Maximum order quantity is 50</div>';
						}
						echo '<h1>'.convert_to_camel_case($fish->type).' of '.convert_to_camel_case($fish->breed).' Breed -'.$word.'</h1><br />';
					?>
					<div class="row">
						<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					        <?php echo '<a href="../images/portfolio/full/'.$fish->img_ful.'" target="_blank"><img src="../images/portfolio/thumb/'.$fish->img_tmb.'" class="img-thumbnail" width="200" height="150"></a>'; ?>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<?php
								if ($fish->hasPrm == 2) {
							        if ($premium) {
						        		echo '<br /><br /><a href="place_order.php?fsh_id='.$fish->id.'&prem=0"><button type="button" class="btn btn-warning">Goto Regular Quality Fish</button></a>';
						        	} else {
						        		echo '<br /><br /><a href="place_order.php?fsh_id='.$fish->id.'&prem=1"><button type="button" class="btn btn-success">Goto Premium Quality Fish</button></a>';
						        	}
						        }
				        	?>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
							<ul class="list-group" style="margin-bottom: auto;">
            				<?php
                				foreach ($pr_opts as $pr_opt) {                					
					            	echo '<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;"><strong>'.convert_to_camel_case($pr_opt->opt_name).': </strong><span class="label label-primary" style="font-size:16px;">'.$pr_opt->price.' <i class="icon-rupee"></i></span></li>';
		                        }
                			?>
                			</ul>
						</div>
					</div><br />
					<div class="row">
						<form action="../actions/cart_update.php" method="POST">
							<input type="hidden" class="form-control" name="breed" value=<?php echo '"'.convert_to_camel_case($fish->breed).'"'; ?> readonly>
							<input type="hidden" class="form-control" name="type" value=<?php echo '"'.convert_to_camel_case($fish->type).'"'; ?> readonly>
							<input type="hidden" name="quality" value="<?php echo $premium; ?>">
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					            <input id="qtty" type="text" value="1" name="qtty" class="form-control">
				        	</div>
							<br /><br /><br />
				        	<?php
			            		echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			            			<div class="input-group">
			            				<span class="input-group-addon">Choose a'.$word.' Chopping Style</span>
			                			<select class="selectpicker form-control" data-live-search="true" name="ch_style" title="Please select a Style">';
			                				foreach ($ch_styles as $ch_style) {
			                					echo '<option>'.convert_to_camel_case($ch_style).'</option>';
			                				}
			                			echo '</select>
				            		</div>
								</div>';
			            		echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			            			<div class="input-group">
			            				<span class="input-group-addon">Choose a'.$word.' Cleaning Style</span>
			                			<select class="selectpicker form-control" data-live-search="true" name="cl_style" title="Please select a Style">';
			                				foreach ($cl_styles as $cl_style) {
			                					echo '<option>'.convert_to_camel_case($cl_style).'</option>';
			                				}
			                			echo '</select>
				            		</div>
								</div>';
				            ?>
				            <br /><br /><br />
				            <?php
				            	if (count($pk_opts) > 0) {
				            		echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				            			<div class="input-group">
				            				<span class="input-group-addon">Choose a'.$word.' Packing Option</span>
				                			<select class="selectpicker form-control" data-live-search="true" name="pk_opt" title="Please select a Style">';
				                				foreach ($pk_opts as $pk_opt) {
				                					echo '<option>'.convert_to_camel_case($pk_opt).'</option>';
				                				}
				                			echo '</select>
					            		</div>
									</div>';
								}
								echo '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			            			<div class="input-group">
			            				<span class="input-group-addon">Choose a'.$word.' Pricing Option</span>
			                			<select class="selectpicker form-control" data-live-search="true" name="price" title="Please select a Style">';
			                				foreach ($pr_opts as $pr_opt) {
			                					echo '<option value="'.$pr_opt->price.'">'.convert_to_camel_case($pr_opt->opt_name).': '.$pr_opt->price.'</option>';
			                				}
			                			echo '</select>
				            		</div>
				            		<input type="hidden" name="pr_opt" value="'.$pr_opt->opt_name.'">
								</div>';
							?>
							<br /><br /><br />
				            <div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
				            	<div class="input-group">
									<input type="hidden" class="form-control" name="fsh_id" value="<?php echo $fish->id; ?>">
								</div>
								<div class="input-group">
									<input type="hidden" class="form-control" name="return_url" value="<?php echo $current_url; ?>">
								</div>
				            </div>
				            <div class="col-xs-6 col-sm-9 col-md-9 col-lg-9">
				            	<div class="input-group">
				            		<a class="btn btn-info" type="button" href="../#portfolio">Continue Shopping</a>
				            	</div>
							</div>
							<div class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
				            	<div class="input-group">
				            		<button type="submit" name="addorder" class="btn btn-primary">Add to Cart</button>
				            	</div>
							</div>
						</form><br /><br /><br />
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				<br /><br />
				<div class="navbar navbar-default">
					<div class="center">
						<h3>Your Shopping Cart</h3>
					</div>
					<div class="box">
						<div class="row">
							<div class="shopping-cart">
								<?php
									if($cart_session->isAddedToCart()) {
									    $total = 0;
									    echo '<ol>';
									    foreach ($cart_session->fishes as $fish) {
									    	if ($fish['isPrm']) { $prmm = "Premium"; } else { $prmm = "Regular"; }
									    	$subtotal = ((float)$fish["price"]*(float)$fish["qtty"]);
									        echo '<li class="cart-itm">';
									        echo '<span class="remove-itm"><a href="../actions/cart_update.php?rm='.$fish["id"].'&return_url='.$current_url.'&ch_style='.$fish["ch_style"].'&cl_style='.$fish["cl_style"].'&pk_opt='.$fish["pk_opt"].'&isPrm='.$fish["isPrm"].'">&times;</a></span>';
									        echo '<h3>Fish: '.$fish["type"].' - '.$fish["breed"].'</h3>';
									        echo '<div class="p-qty">Qty: '.$fish["qtty"].' - Quality: '.$prmm.'</div>';
									        echo '<div class="p-price">Chop Style: '.$fish["ch_style"].'</div>';
									        echo '<div class="p-price">Clean Style: '.$fish["cl_style"].'</div>';
									        if (!empty(trim($fish['pk_opt']))) {
									        	echo '<div class="p-price">Packing Option: '.$fish["pk_opt"].'</div>';
									        }
									        echo '<div class="p-price">Total Price (As Per Pricing Option): '.$subtotal.'  <i class="icon-rupee"></i></div>';
									        echo '</li>';
									        $total = ($total + $subtotal);
									    }
									    echo '</ol>';
									    echo '<span class="check-out-txt"><strong>Total : '.$total.'  <i class="icon-rupee"></i></strong></span>';
										echo '<span class="empty-cart"><a href="../actions/cart_update.php?rm_all=1&return_url='.$current_url.'">Empty Cart</a></span>';
									} else {
									    echo '<p>Your Cart is empty</p>';
									}
								?>
							</div>
						</div><br />
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				            	<div class="center">
				            		<a class="btn btn-success" type="button" href="checkout.php?return_url=<?php echo $current_url; ?>">Check Out</a>
				            	</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div><br /><br /><br />
	</div>
</div>
<?php
    include "footer.php";
    if(isset($database)) { $database->close_connection(); }?>
    