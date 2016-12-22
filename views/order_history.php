<?php
    require_once("../includes/initialize.php");
    $title = "Order History - Go Fishly";
    if($user_session->is_logged_in()) {
        $user = User::find_by_id($user_session->user_id);
        $logged_in = true;
        $user_name = convert_to_camel_case($user->full_name());
    }
    if(isset($user)) {
    	$orders = Order::orders_by_usr_id($user->id);
    } else {
    	redirect_to('../');
    }
    include "header.php";
?>
<div class="panel panel-default">
    <br/><br/><br/>
    <div class="panel-body">
        <div class="navbar navbar-default">
        	<div class="center">
        		<br/><br/><br/>
        		<h1>Your Orders And Their Tracking Details</h1>
        		<br/><br/><br/>
        		<div class="col-md-1 col-lg-1">
	    		</div>
	        	<div class="panel-group col-xs-12 col-sm-12 col-md-10 col-lg-10" id="accordion" role="tablist" aria-multiselectable="true">
	        		<div class="center">
	        			<?php
	        				foreach ($orders as $order) {
	        					$fish = Fish::find_by_id($order->fsh_id);
	        					if($order->isPrm) {
	        						$word = '<span class="label label-danger">Premium</span>';
	        					} else {
	        						$word = '<span class="label label-success">Regular</span>';
	        					}
	        					echo '<div class="panel panel-default">
			            			<div class="panel-heading" role="tab" id="headingOne'.$order->id.'">
				            			<div class="row">
				            				<h4 class="panel-title col-xs-12 col-sm-3 col-md-3 col-lg-3">
				            					<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne'.$order->id.'" aria-expanded="false" aria-controls="collapseOne'.$order->id.'">
				            						<button class="btn btn-primary">'.getOrderId((int)$order->id).'</button>
				            					</a>
				            				</h4>
				            				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
				            					<h4><a href="place_order.php?fsh_id='.$fish->id.'&prem='.$order->isPrm.'"><span class="label label-default">Breed: '.convert_to_camel_case($fish->breed).' and Type: '.convert_to_camel_case($fish->type).'</span></a></h4>
				            				</div>
				            				<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
				            					<h4><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne'.$order->id.'" aria-expanded="false" aria-controls="collapseOne'.$order->id.'">'.$word.'</a></h4>
				            				</div>
				            				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
				            					<h4><a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne'.$order->id.'" aria-expanded="false" aria-controls="collapseOne'.$order->id.'">
				            						<span class="label label-default">Ordered On: '.getFormatedDate($order->timestamp).'</span>
				            					</a></h4>
				            				</div>
			            				</div>
			            			</div>
			            			<div id="collapseOne'.$order->id.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne'.$order->id.'">
			            				<div class="panel-body">
			            					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			            						<a href="place_order.php?fsh_id='.$fish->id.'&prem='.$order->isPrm.'"><img src="../images/portfolio/thumb/'.$fish->img_tmb.'" class="img-thumbnail" width="240" height="180"></a>
			            					</div>
			            					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			            						<ul class="list-group">
				            						<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;">Chopping Style: <strong>'.$order->ch_style.'</strong></li>
				            						<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;">Cleaning Style: <strong>'.$order->cl_style.'</strong></li>
				            						<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;">Order Quantity: <strong>'.$order->qtty.'</strong></li>
				            						<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;">'.$order->pr_opt.': <strong>'.$order->amount.'</strong></li>
				            						<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;">Packing Option: <strong>'.$order->pk_opt.'</strong></li>
			            						</ul>
			            					</div>
			            					<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
			            						<ul class="list-group">
				            						<li class="list-group-item">Ordered Time: <span class="label label-default">'.$order->timestamp.'</span></li>
				            						<li class="list-group-item">Order Status: <span class="label label-success">'.$order->status.'</span></li>
				            						<li class="list-group-item">Tracking Details: <span class="label label-warning">'.$order->tracking.'</span></li>
				            						<li class="list-group-item"><strong>Remarks: </strong>'.$order->remarks.'</li>
			            						</ul>
			            					</div>
			            				</div>
			            			</div>
			            		</div>';
	        				} 
	        			?>
	            		<br/><br/><br/>
	        		</div>
	        	</div>
        	</div>
        </div>
    </div>
</div>
<?php
    include "footer.php";
    if(isset($database)) { $database->close_connection(); }
?>