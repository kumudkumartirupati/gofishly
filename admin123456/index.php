<?php
    require_once("../includes/initialize.php");
    $title = "Admin Panel - Go Fishly";
    if (!isset($_GET['tab']) && empty($_GET['tab'])) {
        $tab = 1;
    } else {
        $tab = $_GET['tab'];
    }
    include "header.php";
    if ($tab == 4) {
    	$orders = Order::find_all();
		foreach ($orders as $order) {
			if (!empty($order->fsh_id)) {
				$fish = Fish::find_by_id($order->fsh_id);
			} else {
				$fish = 0;
			}
			if ($fish) {
				$reg_prs = PriceOption::getRegPriceCumOption($fish->id);
				$prm_prs = PriceOption::getPrmPriceCumOption($fish->id);
				if ($fish->hasPrm == 1) {
                    $fish_text = '<strong>Premium Chopping Styles: </strong><span>'.convert_to_camel_case(join(', ', ChopStyle::getChPrmStyleByFishId($fish->id))).'.</span><br/><strong>Premium Cleaning Styles: </strong><span>'.convert_to_camel_case(join(', ', CleanStyle::getClPrmStyleByFishId($fish->id))).'.</span><br/><strong>Premium Packing Options: </strong><span>'.convert_to_camel_case(join(', ', PackOption::getPkPrmOptByFishId($fish->id))).'.</span><br/><strong>Premium Pricing Options:&nbsp;</strong><span>'.convert_to_camel_case(join(', ', $prm_prs)).'.</span><br/>';
                } elseif ($fish->hasPrm == 0) {
                    $fish_text = '<strong>Regular Chopping Styles: </strong><span>'.convert_to_camel_case(join(', ', ChopStyle::getChRegStyleByFishId($fish->id))).'.</span><br/><strong>Regular Cleaning Styles: </strong><span>'.convert_to_camel_case(join(', ', CleanStyle::getClRegStyleByFishId($fish->id))).'.</span><br/><strong>Regular Packing Options: </strong><span>'.convert_to_camel_case(join(', ', PackOption::getPkRegOptByFishId($fish->id))).'.</span><br/><strong>Regular Pricing Options:&nbsp;</strong><span>'.convert_to_camel_case(join(', ', $reg_prs)).'.</span><br/>';
                } else {
                    $fish_text = '<strong>Premium Chopping Styles: </strong><span>'.convert_to_camel_case(join(', ', ChopStyle::getChPrmStyleByFishId($fish->id))).'.</span><br/><strong>Premium Cleaning Styles: </strong><span>'.convert_to_camel_case(join(', ', CleanStyle::getClPrmStyleByFishId($fish->id))).'.</span><br/><strong>Premium Packing Options: </strong><span>'.convert_to_camel_case(join(', ', PackOption::getPkPrmOptByFishId($fish->id))).'.</span><br/><strong>Premium Pricing Options:&nbsp;</strong><span>'.convert_to_camel_case(join(', ', $prm_prs)).'.</span><br/><strong>Regular Chopping Styles: </strong><span>'.convert_to_camel_case(join(', ', ChopStyle::getChRegStyleByFishId($fish->id))).'.</span><br/><strong>Regular Cleaning Styles: </strong><span>'.convert_to_camel_case(join(', ', CleanStyle::getClRegStyleByFishId($fish->id))).'.</span><br/><strong>Regular Packing Options: </strong><span>'.convert_to_camel_case(join(', ', PackOption::getPkRegOptByFishId($fish->id))).'.</span><br/><strong>Regular Pricing Options:&nbsp;</strong><span>'.convert_to_camel_case(join(', ', $reg_prs)).'.</span><br/>';
                }
				echo '<div class="modal fade orderedfish'.$order->id.'" tabindex="-1" role="dialog" aria-labelledby="OrderedFish" aria-hidden="true">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div style="padding-left: 10px;padding-bottom: 10px;">
								<div class="center">
									<h2>Type: '.convert_to_camel_case($fish->type).' - Breed: '.convert_to_camel_case($fish->breed).'</h2>
								</div>'.$fish_text.'
							</div>
						</div>
					</div>
				</div>';
			}
			echo '<div class="modal fade ordereduser'.$order->id.'" tabindex="-1" role="dialog" aria-labelledby="OrderedUser" aria-hidden="true">	                            		
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div style="padding-left: 10px;padding-bottom: 10px;">
						'.$order->address.'
						</div>
					</div>
				</div>
			</div>';
			echo '<div class="modal fade editOrder'.$order->id.'" tabindex="-1" role="dialog" aria-labelledby="EditOrder" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div style="padding-left: 10px;padding-bottom: 10px;">
							<div class="center">
								<h2>Order Id: '.getOrderId($order->id).'</h2>
								<form role="form" action="actions/order_action.php" method="post">
									<div class="form-group">
										<label for="tracking" class="col-sm-4">Tracking Details</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="tracking" maxlength="50" placeholder="Enter Shipment Tracking Details">
										</div>
									</div>
									<br/><br/>
									<div class="form-group">
										<label for="remarks" class="col-sm-4">Remarks</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="remarks" maxlength="100" placeholder="Enter Remarks If Any">
										</div>
									</div>
									<br/><br/>
									<div class="form-group">
										<label for="status" class="col-sm-4">Order Status</label>
										<div class="col-sm-8">
											<select class="form-control" name="status">
												<option value="">Select An Order Status</option>
	                                    		<option value="Order Processing">Order Processing</option>
	                                    		<option value="Order Accepted">Order Accepted</option>
	                                    		<option value="Work In Progess">Work In Progress</option>
	                                    		<option value="Dispatched">Dispatched</option>
	                                    		<option value="Delivered">Delivered</option>
	                                    	</select>
                                    	</div>
									</div>
									<input type="hidden" class="form-control" name="tab" value="'.$tab.'">
									<input type="hidden" class="form-control" name="ord_id" value="'.$order->id.'">
									<br/><br/>
									<div class="col-sm-12">
										<button type="submit" name="editOrder" class="btn btn-primary btn-lg">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>';
		}
    }
    if ($tab == 3) {
		if (!empty($_GET['fsh_id'])) {
			$fish_id = (int)trim($_GET['fsh_id']);
			$fish = Fish::find_by_id($fish_id);
			$reg_prs = PriceOption::getRegPriceCumOption($fish->id);
			$prm_prs = PriceOption::getPrmPriceCumOption($fish->id);
			if ($fish->hasPrm == 1) {
                $fish_text = '<strong>Premium Chopping Styles: </strong><span>'.convert_to_camel_case(join(', ', ChopStyle::getChPrmStyleByFishId($fish->id))).'.</span><br/><strong>Premium Cleaning Styles: </strong><span>'.convert_to_camel_case(join(', ', CleanStyle::getClPrmStyleByFishId($fish->id))).'.</span><br/><strong>Premium Packing Options: </strong><span>'.convert_to_camel_case(join(', ', PackOption::getPkPrmOptByFishId($fish->id))).'.</span><br/><strong>Premium Pricing Options:&nbsp;</strong><span>'.convert_to_camel_case(join(', ', $prm_prs)).'.</span><br/>';
            } elseif ($fish->hasPrm == 0) {
                $fish_text = '<strong>Regular Chopping Styles: </strong><span>'.convert_to_camel_case(join(', ', ChopStyle::getChRegStyleByFishId($fish->id))).'.</span><br/><strong>Regular Cleaning Styles: </strong><span>'.convert_to_camel_case(join(', ', CleanStyle::getClRegStyleByFishId($fish->id))).'.</span><br/><strong>Regular Packing Options: </strong><span>'.convert_to_camel_case(join(', ', PackOption::getPkRegOptByFishId($fish->id))).'.</span><br/><strong>Regular Pricing Options:&nbsp;</strong><span>'.convert_to_camel_case(join(', ', $reg_prs)).'.</span><br/>';
            } else {
                $fish_text = '<strong>Premium Chopping Styles: </strong><span>'.convert_to_camel_case(join(', ', ChopStyle::getChPrmStyleByFishId($fish->id))).'.</span><br/><strong>Premium Cleaning Styles: </strong><span>'.convert_to_camel_case(join(', ', CleanStyle::getClPrmStyleByFishId($fish->id))).'.</span><br/><strong>Premium Packing Options: </strong><span>'.convert_to_camel_case(join(', ', PackOption::getPkPrmOptByFishId($fish->id))).'.</span><br/><strong>Premium Pricing Options:&nbsp;</strong><span>'.convert_to_camel_case(join(', ', $prm_prs)).'.</span><br/><strong>Regular Chopping Styles: </strong><span>'.convert_to_camel_case(join(', ', ChopStyle::getChRegStyleByFishId($fish->id))).'.</span><br/><strong>Regular Cleaning Styles: </strong><span>'.convert_to_camel_case(join(', ', CleanStyle::getClRegStyleByFishId($fish->id))).'.</span><br/><strong>Regular Packing Options: </strong><span>'.convert_to_camel_case(join(', ', PackOption::getPkRegOptByFishId($fish->id))).'.</span><br/><strong>Regular Pricing Options:&nbsp;</strong><span>'.convert_to_camel_case(join(', ', $reg_prs)).'.</span><br/>';
            }
			echo '<div class="modal fade chclFish" tabindex="-1" role="dialog" aria-labelledby="ChClFish" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div style="padding-left: 10px;padding-bottom: 10px;">
							<div class="center">
								<h2>Type: '.convert_to_camel_case($fish->type).' - Breed: '.convert_to_camel_case($fish->breed).'</h2>
							</div>'.$fish_text.'
						</div>
					</div>
				</div>
			</div>';
			$ch_styles = ChopStyle::getByFishId($fish->id);
			$cl_styles = CleanStyle::getByFishId($fish->id);
			$pr_options = PriceOption::getByFishId($fish->id);
			$pk_options = PackOption::getByFishId($fish->id);
			foreach ($ch_styles as $ch_style) {
				echo '<div class="modal fade editChFish'.$ch_style->id.'" tabindex="-1" role="dialog" aria-labelledby="editChFish" aria-hidden="true">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div style="padding-left: 10px;padding-bottom: 10px;">
								<div class="center">
									<h2>Edit Chopping Style Of Id: '.$ch_style->id.'</h2>
									<form role="form" action="actions/fish_action.php" method="post">
										<div class="form-group">
											<label for="ch_style" class="col-sm-4">Edit Chopping Style</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="ch_style" maxlength="20" placeholder="Enter A New Chopping Style">
											</div>
										</div>
										<input type="hidden" class="form-control" name="tab" value="'.$tab.'">
										<input type="hidden" class="form-control" name="fsh_id" value="'.$fish_id.'">
										<input type="hidden" class="form-control" name="ch_id" value="'.$ch_style->id.'">
										<br/><br/>
										<div class="col-sm-12">
											<button type="submit" name="editChStyle" class="btn btn-primary btn-lg">Submit</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>';
			}
			foreach ($cl_styles as $cl_style) {
				echo '<div class="modal fade editClFish'.$cl_style->id.'" tabindex="-1" role="dialog" aria-labelledby="editClFish" aria-hidden="true">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div style="padding-left: 10px;padding-bottom: 10px;">
								<div class="center">
									<h2>Edit Cleaning Style Of Id: '.$cl_style->id.'</h2>
									<form role="form" action="actions/fish_action.php" method="post">
										<div class="form-group">
											<label for="cl_style" class="col-sm-4">Edit Cleaning Style</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="cl_style" maxlength="20" placeholder="Enter A New Cleaning Style">
											</div>
										</div>
										<input type="hidden" class="form-control" name="tab" value="'.$tab.'">
										<input type="hidden" class="form-control" name="fsh_id" value="'.$fish_id.'">
										<input type="hidden" class="form-control" name="cl_id" value="'.$cl_style->id.'">
										<br/><br/>
										<div class="col-sm-12">
											<button type="submit" name="editClStyle" class="btn btn-primary btn-lg">Submit</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>';
			}
			foreach ($pr_options as $pr_option) {
				echo '<div class="modal fade editPrFish'.$pr_option->id.'" tabindex="-1" role="dialog" aria-labelledby="editPrFish" aria-hidden="true">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div style="padding-left: 10px;padding-bottom: 10px;">
								<div class="center">
									<h2>Edit Pricing Option Of Id: '.$pr_option->id.'</h2>
									<form role="form" action="actions/fish_action.php" method="post">
										<div class="form-group">
											<label for="pr_option" class="col-sm-5">Edit Pricing Option Name</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" name="pr_option" maxlength="25" placeholder="Enter A New Pricing Option Name">
											</div>
										</div><br/><br/>
										<div class="form-group">
											<label for="price" class="col-sm-5">Edit Price</label>
											<div class="col-sm-7">
												<input type="text" class="form-control" name="price" maxlength="10" placeholder="Enter A New Price For This Option">
											</div>
										</div>
										<input type="hidden" class="form-control" name="tab" value="'.$tab.'">
										<input type="hidden" class="form-control" name="fsh_id" value="'.$fish_id.'">
										<input type="hidden" class="form-control" name="pr_id" value="'.$pr_option->id.'">
										<br/><br/>
										<div class="col-sm-12">
											<button type="submit" name="editPrOption" class="btn btn-primary btn-lg">Submit</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>';
			}
			foreach ($pk_options as $pk_option) {
				echo '<div class="modal fade editPkFish'.$pk_option->id.'" tabindex="-1" role="dialog" aria-labelledby="editPkFish" aria-hidden="true">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div style="padding-left: 10px;padding-bottom: 10px;">
								<div class="center">
									<h2>Edit Packing Option Of Id: '.$pk_option->id.'</h2>
									<form role="form" action="actions/fish_action.php" method="post">
										<div class="form-group">
											<label for="pk_option" class="col-sm-4">Edit Packing Option</label>
											<div class="col-sm-8">
												<input type="text" class="form-control" name="pk_option" maxlength="25" placeholder="Enter A New Packing Option">
											</div>
										</div>
										<input type="hidden" class="form-control" name="tab" value="'.$tab.'">
										<input type="hidden" class="form-control" name="fsh_id" value="'.$fish_id.'">
										<input type="hidden" class="form-control" name="pk_id" value="'.$pk_option->id.'">
										<br/><br/>
										<div class="col-sm-12">
											<button type="submit" name="editPkOption" class="btn btn-primary btn-lg">Submit</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>';
			}
			echo '<div class="modal fade addClFish" tabindex="-1" role="dialog" aria-labelledby="addClFish" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div style="padding-left: 10px;padding-bottom: 10px;">
							<div class="center">
								<h2>Add New Cleaning Style</h2>
								<form role="form" action="actions/fish_action.php" method="post">
									<div class="form-group">
										<label for="cl_style" class="col-sm-4"><span style="color:red;">*</span> Cleaning Style</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="cl_style" maxlength="20" placeholder="Enter A New Cleaning Style">
										</div>
									</div>
									<div class="form-group">
			                        	<label for="isPrm" class="col-sm-4"><span style="color:red;">*</span> Choose A Style Type</label>
			                        	<label class="checkbox-inline">
			                        		Regular <input type="radio" name="isPrm" value="0">
			                        	</label>
			                        	<label class="checkbox-inline">
			                        		Premium <input type="radio" name="isPrm" value="1">
			                        	</label>
			                        </div>
									<input type="hidden" class="form-control" name="tab" value="'.$tab.'">
									<input type="hidden" class="form-control" name="fsh_id" value="'.$fish_id.'">
									<div class="col-sm-12">
										<button type="submit" name="addClStyle" class="btn btn-primary btn-lg">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>';
			echo '<div class="modal fade addChFish" tabindex="-1" role="dialog" aria-labelledby="addChFish" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div style="padding-left: 10px;padding-bottom: 10px;">
							<div class="center">
								<h2>Add New Chopping Style</h2>
								<form role="form" action="actions/fish_action.php" method="post">
									<div class="form-group">
										<label for="ch_style" class="col-sm-4"><span style="color:red;">*</span> Chopping Style</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="ch_style" maxlength="20" placeholder="Enter A New Chopping Style">
										</div>
									</div>
									<div class="form-group">
			                        	<label for="isPrm" class="col-sm-4"><span style="color:red;">*</span> Choose A Style Type</label>
			                        	<label class="checkbox-inline">
			                        		Regular <input type="radio" name="isPrm" value="0">
			                        	</label>
			                        	<label class="checkbox-inline">
			                        		Premium <input type="radio" name="isPrm" value="1">
			                        	</label>
			                        </div>
									<input type="hidden" class="form-control" name="tab" value="'.$tab.'">
									<input type="hidden" class="form-control" name="fsh_id" value="'.$fish_id.'">
									<div class="col-sm-12">
										<button type="submit" name="addChStyle" class="btn btn-primary btn-lg">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>';
			echo '<div class="modal fade addPrFish" tabindex="-1" role="dialog" aria-labelledby="addPrFish" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div style="padding-left: 10px;padding-bottom: 10px;">
							<div class="center">
								<h2>Add New Pricing Option</h2>
								<form role="form" action="actions/fish_action.php" method="post">
									<div class="form-group">
										<label for="pr_option" class="col-sm-4"><span style="color:red;">*</span> Pricing Option Name</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="pr_option" maxlength="25" placeholder="Enter A New Pricing Option Name">
										</div>
									</div><br/><br/>
			                        <div class="form-group">
										<label for="price" class="col-sm-4"><span style="color:red;">*</span> Price</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="price" maxlength="10" placeholder="Enter A Price For This Option">
										</div>
									</div>
									<div class="form-group">
			                        	<label for="isPrm" class="col-sm-5"><span style="color:red;">*</span> Choose A Option Type</label>
			                        	<label class="checkbox-inline">
			                        		Regular <input type="radio" name="isPrm" value="0">
			                        	</label>
			                        	<label class="checkbox-inline">
			                        		Premium <input type="radio" name="isPrm" value="1">
			                        	</label>
			                        </div>
									<input type="hidden" class="form-control" name="tab" value="'.$tab.'">
									<input type="hidden" class="form-control" name="fsh_id" value="'.$fish_id.'">
									<div class="col-sm-12">
										<button type="submit" name="addPrOption" class="btn btn-primary btn-lg">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>';
			echo '<div class="modal fade addPkFish" tabindex="-1" role="dialog" aria-labelledby="addPkFish" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div style="padding-left: 10px;padding-bottom: 10px;">
							<div class="center">
								<h2>Add New Packing Option</h2>
								<form role="form" action="actions/fish_action.php" method="post">
									<div class="form-group">
										<label for="pk_option" class="col-sm-4"><span style="color:red;">*</span> Packing Option</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="pk_option" maxlength="25" placeholder="Enter A New Packing Option">
										</div>
									</div>
									<div class="form-group">
			                        	<label for="isPrm" class="col-sm-5"><span style="color:red;">*</span> Choose A Option Type</label>
			                        	<label class="checkbox-inline">
			                        		Regular <input type="radio" name="isPrm" value="0">
			                        	</label>
			                        	<label class="checkbox-inline">
			                        		Premium <input type="radio" name="isPrm" value="1">
			                        	</label>
			                        </div>
									<input type="hidden" class="form-control" name="tab" value="'.$tab.'">
									<input type="hidden" class="form-control" name="fsh_id" value="'.$fish_id.'">
									<div class="col-sm-12">
										<button type="submit" name="addPkOption" class="btn btn-primary btn-lg">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>';
		}
    }
    if ($tab == 5) {
    	$users = User::find_all();
    	foreach ($users as $user) {
    		$bldng = Building::find_by_id($user->bld_id);
    		echo '<div class="modal fade editUser'.$user->id.'" tabindex="-1" role="dialog" aria-labelledby="EditUser" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div style="padding-left: 10px;padding-bottom: 10px;">
							<div class="center">
								<h2>'.convert_to_camel_case($user->full_name()).'</h2>
								<form role="form" action="actions/user_action.php" method="post">
									<div class="form-group">
										<label for="phone" class="col-sm-4">Mobile Number</label>
										<div class="col-sm-8">
											<input type="text" class="form-control" name="phone" maxlength="9" placeholder="Enter The New Mobile Number">
										</div>
									</div>
									<br/><br/>
									<div class="form-group">
										<label for="isActvd" class="col-sm-4">Activation Status</label>
										<div class="col-sm-8">
											<select class="form-control" name="isActvd">
												<option value="">Select An Account Status</option>
	                                    		<option value="0">Pending</option>
	                                    		<option value="1">Verified</option>
	                                    		<option value="2">Blocked</option>
	                                    	</select>
                                    	</div>
									</div>
									<input type="hidden" class="form-control" name="tab" value="'.$tab.'">
									<input type="hidden" class="form-control" name="usr_id" value="'.$user->id.'">
									<br/><br/>
									<div class="col-sm-12">
										<button type="submit" name="editUser" class="btn btn-primary btn-lg">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>';
			echo '<div class="modal fade userBldng'.$user->id.'" tabindex="-1" role="dialog" aria-labelledby="UserBuilding" aria-hidden="true">	                            		
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div style="padding-left: 10px;padding-bottom: 10px;">
							<div class="center">
								<h2>'.convert_to_camel_case($user->full_name()).' - Building Details</h2>
							</div>
							<strong>Area Name:&nbsp;</strong>
							<p>'.$bldng->area_name.'</p>
							<strong>Sub Area Name:&nbsp;</strong>
							<p>'.$bldng->sarea_name.'</p>
							<strong>Street Name:&nbsp;</strong>
							<p>'.$bldng->street_name.'</p>
							<strong>Building Name:&nbsp;</strong>
							<p>'.$bldng->bldng_name.'</p>
						</div>
					</div>
				</div>
			</div>';
    	}
    }
    if ($tab == 6) {
    	$feedbacks = Feedback::find_all();
    	foreach ($feedbacks as $feedback) {
    		if (!empty($feedback->usr_id)) {
    			$user = User::find_by_id($feedback->usr_id);
    			$bldng = Building::find_by_id($user->bld_id);
    		} else {
    			$user = 0;
    		}
			if ($user) {
				echo '<div class="modal fade writtenUser'.$feedback->id.'" tabindex="-1" role="dialog" aria-labelledby="WrittenUser" aria-hidden="true">	                            		
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<div style="padding-left: 10px;padding-bottom: 10px;">
								<div class="center">
									<h2>'.convert_to_camel_case($user->full_name()).'</h2>
								</div>
								<strong>Building Details:&nbsp;</strong>
								<p>
									Area Name: '.$bldng->area_name.', Sub Area Name: '.$bldng->sarea_name.'<br/>
									Street Name: '.$bldng->street_name.', Building Name: '.$bldng->bldng_name.'<br/>
								</p>
								<strong>Address:&nbsp;</strong>
								<p>
									Landmark: '.convert_to_camel_case($user->landmark).', Building Popular Name: '.convert_to_camel_case($user->build_pop_name).',<br />
									Flat Number: '.$user->flat_num.', Family Number: '.$user->fam_num.'<br />
								</p>
								<strong>Mobile Number:&nbsp;</strong>
								<span>'.$user->phone.'</span><br/>
								<strong>Email:&nbsp;</strong>
								<span>'.$user->email.'</span>
							</div>
						</div>
					</div>
				</div>';
			}
    	}
    }
    if ($tab == 7) {
    	$areas = Building::getAllAreas();
		echo '<div class="modal fade addBldng" tabindex="-1" role="dialog" aria-labelledby="Add Building" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div style="padding-left: 10px;padding-bottom: 10px;">
						<div class="center">
							<h2>Add Building</h2>
							<form role="form" action="actions/bld_action.php" method="post">
								<div class="form-group">
									<label for="area" class="col-sm-4">Area Name</label>
									<div class="col-sm-8">
										<select class="form-control" id="area" onchange="get_sarea();">
											<option value="">Select An Area</option>';
											foreach ($areas as $area) {
	                                            echo '<option value="'.$area.'">'.$area.'</option>';
	                                        }
											echo '<option value="@add@">-- Enter A New Area --</option>
                                    	</select>
                                    	<input type="text" name="area" class="form-control" id="area_input" style="display: none;" placeholder="Enter An Area Name">
                                	</div>
                                	<br/><br/>
								</div>
								<div class="form-group">
									<label for="sarea" class="col-sm-4">SubArea Name</label>
									<div class="col-sm-8">
										<select class="form-control" id="sarea" onchange="get_street();">
											<option value="">Select A Sub Area</option>
                                    	</select>
                                    	<input type="text" name="sarea" class="form-control" id="sarea_input" style="display: none;" placeholder="Enter A Sub Area Name">
                                	</div>
                                	<br/><br/>
								</div>
								<div class="form-group">
									<label for="street" class="col-sm-4">Street Name</label>
									<div class="col-sm-8">
										<select class="form-control" id="street" onchange="get_bldng();">
											<option value="">Select A Street Name</option>
                                    	</select>
                                    	<input type="text" name="street" class="form-control" id="street_input" style="display: none;" placeholder="Enter A Street Name">
                                	</div>
                                	<br/><br/>
								</div>
								<div class="form-group">
									<label for="bldng" class="col-sm-4">Building Name</label>
									<div class="col-sm-8">
										<input type="text" name="bldng" class="form-control" placeholder="Enter A Building Name">
                                	</div>
                                	<br/><br/>
								</div>
								<input type="hidden" id="addNewBldng" value="@add@">
								<input type="hidden" class="form-control" name="tab" value="'.$tab.'">
								<div class="col-sm-12">
									<button type="submit" name="addBldng" class="btn btn-primary btn-lg">Submit</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>';
    }
?>
<div class="panel panel-default">
    <br/><br/><br/>
    <div class="panel-body">
        <div class="navbar navbar-default">
        	<br/><br/>
        	<div class="center">
        	<?php
        		if(isset($_GET['err']) && $_GET['err'] == 1) {
                    echo '<div class="alert alert-danger">Data Processing Error</div>';
                }
                if(isset($_GET['ed_ord_suc']) && $_GET['ed_ord_suc'] == 1) {
                    echo '<div class="alert alert-success">Order Details Successfully Updated</div>';
                }
                if(isset($_GET['del_ord_suc']) && $_GET['del_ord_suc'] == 1) {
                    echo '<div class="alert alert-success">Order Deleted Successfully</div>';
                }
                if(isset($_GET['ed_usr_suc']) && $_GET['ed_usr_suc'] == 1) {
                    echo '<div class="alert alert-success">User Details Successfully Updated</div>';
                }
                if(isset($_GET['del_usr_suc']) && $_GET['del_usr_suc'] == 1) {
                    echo '<div class="alert alert-success">User Deleted Successfully</div>';
                }
                if(isset($_GET['del_fsh_suc']) && $_GET['del_fsh_suc'] == 1) {
                    echo '<div class="alert alert-success">Fish And All It\'s Chopping, Cleaning Styles and Pricing, Packing Options Were Deleted Successfully</div>';
                }
                if(isset($_GET['del_fb_suc']) && $_GET['del_fb_suc'] == 1) {
                    echo '<div class="alert alert-success">Feedback Deleted Successfully</div>';
                }
                if(isset($_GET['del_ch_suc']) && $_GET['del_ch_suc'] == 1) {
                    echo '<div class="alert alert-success">Chopping Style Deleted Successfully</div>';
                }
                if(isset($_GET['del_cl_suc']) && $_GET['del_cl_suc'] == 1) {
                    echo '<div class="alert alert-success">Cleaning Style Deleted Successfully</div>';
                }
                if(isset($_GET['del_pr_suc']) && $_GET['del_pr_suc'] == 1) {
                    echo '<div class="alert alert-success">Pricing Option Deleted Successfully</div>';
                }
                if(isset($_GET['del_pk_suc']) && $_GET['del_pk_suc'] == 1) {
                    echo '<div class="alert alert-success">Packing Option Deleted Successfully</div>';
                }
                if(isset($_GET['edit_cl_suc']) && $_GET['edit_cl_suc'] == 1) {
                    echo '<div class="alert alert-success">Cleaning Style Updated Successfully</div>';
                }
                if(isset($_GET['edit_ch_suc']) && $_GET['edit_ch_suc'] == 1) {
                    echo '<div class="alert alert-success">Chopping Style Updated Successfully</div>';
                }
                if(isset($_GET['edit_pr_suc']) && $_GET['edit_pr_suc'] == 1) {
                    echo '<div class="alert alert-success">Pricing Option Updated Successfully</div>';
                }
                if(isset($_GET['edit_pk_suc']) && $_GET['edit_pk_suc'] == 1) {
                    echo '<div class="alert alert-success">Packing Option Updated Successfully</div>';
                }
                if(isset($_GET['add_cl_suc']) && $_GET['add_cl_suc'] == 1) {
                    echo '<div class="alert alert-success">Cleaning Style Added Successfully</div>';
                }
                if(isset($_GET['add_ch_suc']) && $_GET['add_ch_suc'] == 1) {
                    echo '<div class="alert alert-success">Chopping Style Added Successfully</div>';
                }
                if(isset($_GET['add_bldng_suc']) && $_GET['add_bldng_suc'] == 1) {
                    echo '<div class="alert alert-success">New Building Added Successfully</div>';
                }
                if(isset($_GET['add_pr_suc']) && $_GET['add_pr_suc'] == 1) {
                    echo '<div class="alert alert-success">Pricing Option Added Successfully</div>';
                }
                if(isset($_GET['add_pk_suc']) && $_GET['add_pk_suc'] == 1) {
                    echo '<div class="alert alert-success">Packing Option Added Successfully</div>';
                }
                if(isset($_GET['del_bldng_suc']) && $_GET['del_bldng_suc'] == 1) {
                    echo '<div class="alert alert-success">Building Deleted Successfully</div>';
                }
                if(isset($_GET['fsh_add']) && $_GET['fsh_add'] == 1) {
                    echo '<div class="alert alert-success">Fish Details Updated Successfully</div>';
                }
                if(isset($_GET['add_err']) && $_GET['add_err'] == 1) {
                    echo '<div class="alert alert-danger">Enter All Details And Make Sure They Are Valid.</div>';
                }
                if(isset($_GET['edit_ch_err']) && $_GET['edit_ch_err'] == 1) {
                    echo '<div class="alert alert-danger">Enter A Chopping Style To Update</div>';
                }
                if(isset($_GET['edit_cl_err']) && $_GET['edit_cl_err'] == 1) {
                    echo '<div class="alert alert-danger">Enter A Cleaning Style To Update</div>';
                }
                if(isset($_GET['edit_pr_err']) && $_GET['edit_pr_err'] == 1) {
                    echo '<div class="alert alert-danger">Enter Pricing Option Name / Valid Price To Update</div>';
                }
                if(isset($_GET['edit_pk_err']) && $_GET['edit_pk_err'] == 1) {
                    echo '<div class="alert alert-danger">Enter A Packing Option To Update</div>';
                }
                if(isset($_GET['frm_epty_err']) && $_GET['frm_epty_err'] == 1) {
                    echo '<div class="alert alert-danger">Enter All Compulsory Fields And Check Whether The Entered Price Is Valid</div>';
                }
                if(isset($_GET['img_type_err']) && $_GET['img_type_err'] == 1) {
                    echo '<div class="alert alert-danger">Size Of HQ Image Should Be Less Than 5 MB And The Size Of Thumbnail Should Be Less Than 256 KB</div>';
                }
                if(isset($_GET['add_bldng_err']) && $_GET['add_bldng_err'] == 1) {
                    echo '<div class="alert alert-danger">Choose Proper Area / SubArea / Street Or Add Proper Area / SubArea / Street</div>';
                }
                if(isset($_GET['img_err']) && $_GET['img_err'] == 1) {
                    echo '<div class="alert alert-danger">Enter Both The Images To Add A New Fish</div>';
                }
        	?>
        	</div>
    		<div class="panel-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<ul class="nav nav-tabs">
					<li role="presentation" <?php if($tab==1) {echo 'class="active"';} ?>><a href="index.php?tab=1">Dashboard</a></li>
					<li role="presentation" <?php if($tab==2) {echo 'class="active"';} ?>><a href="index.php?tab=2">View Items</a></li>
                    <li role="presentation" <?php if($tab==3) {echo 'class="active"';} ?>><a href="index.php?tab=3"><?php if (!empty($fish_id)) { echo 'Edit Items'; } else { echo 'Add Items'; } ?></a></li>
                    <li role="presentation" <?php if($tab==4) {echo 'class="active"';} ?>><a href="index.php?tab=4">Check Orders</a></li>
                    <li role="presentation" <?php if($tab==5) {echo 'class="active"';} ?>><a href="index.php?tab=5">Customers</a></li>
                    <li role="presentation" <?php if($tab==6) {echo 'class="active"';} ?>><a href="index.php?tab=6">User Feedbacks</a></li>
                    <li role="presentation" <?php if($tab==7) {echo 'class="active"';} ?>><a href="index.php?tab=7">Building Details</a></li>
				</ul>
				<br/><br/>
    			<div class="col-md-12 col-lg-12">
    				<?php if ($tab == 1) { ?>
						<div class="center">
			        		<h2>Dashboard Statistics</h2>
			        	</div>
                    <?php } ?>
                    <?php if ($tab == 2) { ?>
                        <div class="center">
			        		<h2>Fishes Details</h2></br>			        	
							<div class="table-responsive" style="overflow-x: auto;">
	                            <table class="table table-bordered">
	                            	<thead>
	                            		<tr>
	                            			<th class="th-align">Id</th>
	                            			<th class="th-align">Fish Image</th>
	                            			<th class="th-align">Fish Type</th>
	                            			<th class="th-align">Fish Breed</th>
	                            			<th class="th-align">Fish Quality</th>
	                            			<th class="th-align">Fish Pricing Options</th>
	                            			<th class="th-align">Fish Chopping Styles</th>
	                            			<th class="th-align">Fish Cutting Styles</th>
	                            			<th class="th-align">Fish Packing Options</th>
	                            			<th class="th-align">Action</th>
	                            		</tr>
	                            	</thead>
	                            	<tbody>
	                            		<?php
							        		$fishes = Fish::find_all();
							        		foreach ($fishes as $fish) {
							        	?>
	                            		<tr>
	                            			<td class="td-align"><?php echo $fish->id; ?></td>
	                            			<td class="td-align"><?php echo '<a href="../images/portfolio/full/'.$fish->img_ful.'" target="_blank"><img src="../images/portfolio/thumb/'.$fish->img_tmb.'" class="img-thumbnail" width="80" height="60"></a>'; ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($fish->type); ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($fish->breed); ?></td>
	                            			<td class="td-align"><?php if ($fish->hasPrm == 1) {echo 'Premium';} elseif ($fish->hasPrm == 0) {echo 'Regular';} else {echo 'Premium & Regular';} ?></td>
	                            			<td class="td-align">
	                            				<?php if ($fish->hasPrm == 0 || $fish->hasPrm == 2) {echo '<strong>Regular</strong>';} ?>
	                            				<ul class="list-group" style="margin-bottom: auto;">
		                            				<?php
			                            				$pr_reg_opts = PriceOption::getRegPriceCumOption($fish->id);
			                            				$pr_prm_opts = PriceOption::getPrmPriceCumOption($fish->id);
			                            				foreach ($pr_reg_opts as $pr_reg_opt) {
			                            			?>
					            					<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;"><?php echo convert_to_camel_case($pr_reg_opt); ?></li>
			                            			<?php
			                            				}
			                            				echo '</ul>';
			                            				if ($fish->hasPrm == 1 || $fish->hasPrm == 2) {echo '<strong>Premium</strong>';}
			                            				echo '<ul class="list-group" style="margin-bottom: auto;">';
			                            				foreach ($pr_prm_opts as $pr_prm_opt) {
			                            			?>
			                            				<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;"><?php echo convert_to_camel_case($pr_prm_opt); ?></li>
			                            			<?php } ?>
		                            			</ul>
	                            			</td>
	                            			<td class="td-align">
	                            				<?php if ($fish->hasPrm == 0 || $fish->hasPrm == 2) {echo '<strong>Regular</strong>';} ?>
	                            				<ul class="list-group" style="margin-bottom: auto;">
		                            				<?php
			                            				$ch_reg_styles = ChopStyle::getChRegStyleByFishId($fish->id);
			                            				$ch_prm_styles = ChopStyle::getChPrmStyleByFishId($fish->id);
			                            				foreach ($ch_reg_styles as $ch_reg_style) {
			                            			?>
					            					<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;"><?php echo convert_to_camel_case($ch_reg_style); ?></li>
			                            			<?php
			                            				}
			                            				echo '</ul>';
			                            				if ($fish->hasPrm == 1 || $fish->hasPrm == 2) {echo '<strong>Premium</strong>';}
			                            				echo '<ul class="list-group" style="margin-bottom: auto;">';
			                            				foreach ($ch_prm_styles as $ch_prm_style) {
			                            			?>
			                            				<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;"><?php echo convert_to_camel_case($ch_prm_style); ?></li>
			                            			<?php } ?>
		                            			</ul>
	                            			</td>
	                            			<td class="td-align">
	                            				<?php if ($fish->hasPrm == 0 || $fish->hasPrm == 2) {echo '<strong>Regular</strong>';} ?>
	                            				<ul class="list-group" style="margin-bottom: auto;">
		                            				<?php
			                            				$cl_reg_styles = CleanStyle::getClRegStyleByFishId($fish->id);
			                            				$cl_prm_styles = CleanStyle::getClPrmStyleByFishId($fish->id);
			                            				foreach ($cl_reg_styles as $cl_reg_style) {
			                            			?>
					            					<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;"><?php echo convert_to_camel_case($cl_reg_style); ?></li>
			                            			<?php
			                            				}
			                            				echo '</ul>';
			                            				if ($fish->hasPrm == 1 || $fish->hasPrm == 2) {echo '<strong>Premium</strong>';}
			                            				echo '<ul class="list-group" style="margin-bottom: auto;">';
			                            				foreach ($cl_prm_styles as $cl_prm_style) {
			                            			?>
			                            				<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;"><?php echo convert_to_camel_case($cl_prm_style); ?></li>
			                            			<?php } ?>
		                            			</ul>
	                            			</td>
	                            			<td class="td-align">
	                            				<?php
	                            					$pk_reg_opts = PackOption::getPkRegOptByFishId($fish->id);
			                            			$pk_prm_opts = PackOption::getPkPrmOptByFishId($fish->id);
	                            					if ($fish->hasPrm == 0 || $fish->hasPrm == 2) {
	                            						echo '<strong>Regular</strong>';
	                            						if (count($pk_reg_opts) < 1) {echo '<br/>None';}
	                            					}
	                            				?>
	                            				<ul class="list-group" style="margin-bottom: auto;">
		                            				<?php
			                            				
			                            				foreach ($pk_reg_opts as $pk_reg_opt) {
			                            			?>
					            					<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;"><?php echo convert_to_camel_case($pk_reg_opt); ?></li>
			                            			<?php
			                            				}
			                            				echo '</ul>';
			                            				if ($fish->hasPrm == 1 || $fish->hasPrm == 2) {
			                            					echo '<strong>Premium</strong>';
			                            					if (count($pk_prm_opts) < 1) {echo '<br/>None';}
			                            				}			                            				
			                            				echo '<ul class="list-group" style="margin-bottom: auto;">';
			                            				foreach ($pk_prm_opts as $pk_prm_opt) {
			                            			?>
			                            				<li class="list-group-item" style="padding-top:5px;padding-bottom:5px;"><?php echo convert_to_camel_case($pk_prm_opt); ?></li>
			                            			<?php } ?>
		                            			</ul>
	                            			</td>
	                            			<td class="td-align">
	                            				<a href="index.php?tab=<?php echo '3&fsh_id='.$fish->id; ?>"><button type="button" class="btn btn-success">&nbsp;Edit&nbsp;</button></a><br/><br/>
	                            				<a href="actions/fish_action.php?tab=<?php echo $tab.'&fsh_id='.$fish->id; ?>&delFish" id="confirmDelete"><button type="button" class="btn btn-danger">Delete</button></a>
	                            			</td>
	                            		</tr>
	                            		<?php } ?>
	                            	</tbody>
	                            </table>
	                    	</div>
	                    </div>
                    <?php } ?>
                    <?php if ($tab == 3) { ?>
                        <div class="center">
                        	<?php
                        		if (!empty($_GET['fsh_id'])) {
                        			$fish_id = (int)trim($_GET['fsh_id']);
                        			echo '<h2>Edit Fish</h2></br>';
                        			$fish = Fish::find_by_id($fish_id);
                        		} else {
                        			$fish = new Fish();
                        			echo '<h2>Add New Fish</h2></br>';
                        		}
                        	 ?>
                        	</br>
			        		<form class="form-horizontal" role="form" action="actions/fish_action.php" method="post" enctype="multipart/form-data">
		                        <div class="form-group">
		                            <label for="type" class="col-sm-3 control-label"><span style="color:red;">*</span> Fish Type</label>
		                            <div class="col-sm-4">
		                                <input type="text" class="form-control" name="type" maxlength="20" value="<?php echo $fish->type; ?>" placeholder="Enter First Type">
		                            </div>
		                            <label for="breed" class="col-sm-1 control-label"><span style="color:red;">*</span> Fish Breed</label>
		                            <div class="col-sm-4">
		                                <input type="text" class="form-control" name="breed" maxlength="20" value="<?php echo $fish->breed; ?>" placeholder="Enter Fish Breed">
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label for="img_ful" class="col-sm-3 control-label"><span style="color:red;">*</span> Upload HQ Image Of The Fish</label>
		                            <div class="col-sm-4">
		                                <input type="file" class="form-control" name="img_ful">
		                                <?php if(!empty($fish_id)) { echo '<p>Upload A New Image To Replace The Existing One</p>'; } ?>
		                            </div>
		                            <div class="col-sm-2">
		                            	<?php
				                        	if (!empty($fish_id)) {
				                        		echo '<a href="../images/portfolio/full/'.$fish->img_ful.'" target="_blank"><img src="../images/portfolio/full/'.$fish->img_ful.'" class="img-thumbnail" width="80" height="60"></a>';
				                        	}	                      
				                        ?>
		                            </div>
		                        </div>
		                        <div class="form-group">
		                            <label for="img_tmb" class="col-sm-3 control-label"><span style="color:red;">*</span> Upload Thumbnail Image Of The Fish</label>
		                            <div class="col-sm-4">
		                                <input type="file" class="form-control" name="img_tmb">
		                                <?php if(!empty($fish_id)) { echo '<p>Upload A New Image To Replace The Existing One</p>'; } ?>
		                            </div>
		                            <div class="col-sm-2">
		                            	<?php
				                        	if (!empty($fish_id)) {
				                        		echo '<a href="../images/portfolio/thumb/'.$fish->img_tmb.'" target="_blank"><img src="../images/portfolio/thumb/'.$fish->img_tmb.'" class="img-thumbnail" width="80" height="60"></a>';
				                        	}
				                        ?>
		                            </div>
		                        </div>
		                        <?php if (!empty($fish_id)) { ?>
		                        	<div class="form-group">
			                        	<label for="hasPrmEdit"> Edit Fish Option</label><br/>
			                        	<label class="checkbox-inline">
			                        		Regular <input type="radio" name="hasPrmEdit" value="0" <?php if ($fish->hasPrm == 0) {echo "checked";} ?>>
			                        	</label>
			                        	<label class="checkbox-inline">
			                        		Premium <input type="radio" name="hasPrmEdit" value="1" <?php if ($fish->hasPrm == 1) {echo "checked";} ?>>
			                        	</label>
			                        	<label class="checkbox-inline">
			                        		Both Regular &#38; Premium <input type="radio" name="hasPrmEdit" value="2" <?php if ($fish->hasPrm == 2) {echo "checked";} ?>>
			                        	</label>
			                        </div>
		                        <?php } ?>
		                        <?php if (empty($fish_id)) { ?>
		                        <div class="form-group">
		                        	<label for="hasPrm"><span style="color:red;">*</span> Choose A Fish Option</label><br/>
		                        	<label class="checkbox-inline">
		                        		Regular <input type="radio" name="hasPrm" value="0">
		                        	</label>
		                        	<label class="checkbox-inline">
		                        		Premium <input type="radio" name="hasPrm" value="1">
		                        	</label>
		                        	<label class="checkbox-inline">
		                        		Both Regular &#38; Premium <input type="radio" name="hasPrm" value="2">
		                        	</label>
		                        </div>
		                        <div style="display:none;" id="fish-options">
			                        <div class="form-group">
			                            <label for="ch_style" class="col-sm-2 control-label"><span style="color:red;">*</span> Chopping Style</label>
			                            <div class="col-sm-5" id="rchopping-styles">
			                                <input type="text" class="form-control" name="rch_style" maxlength="20" placeholder="Enter A Default Regular Chopping Style">
			                            </div>
			                            <div class="col-sm-5" id="pchopping-styles">
			                                <input type="text" class="form-control" name="pch_style" maxlength="20" placeholder="Enter A Default Premium Chopping Style">
			                            </div>
			                        </div>
			                        <div class="form-group">
			                        	<label for="cl_style" class="col-sm-2 control-label"><span style="color:red;">*</span> Cleaning Style</label>
			                            <div class="col-sm-5" id="rcleaning-styles">
			                                <input type="text" class="form-control" name="rcl_style" maxlength="20" placeholder="Enter A Default Regular Cleaning Style">
			                            </div>
			                            <div class="col-sm-5" id="pcleaning-styles">
			                                <input type="text" class="form-control" name="pcl_style" maxlength="20" placeholder="Enter A Default Premium Cleaning Style">
			                            </div>
			                        </div>
			                        <div class="form-group">
			                        	<label for="price" class="col-sm-2 control-label"><span style="color:red;">*</span> Price Per Half Kg Pack</label>
			                            <div class="col-sm-5" id="rbaseprice-option">
			                                <input type="text" class="form-control" name="r_price" maxlength="10" placeholder="Enter The Price Per Regular Pack">
			                            </div>
			                            <div class="col-sm-5" id="pbaseprice-option">
			                                <input type="text" class="form-control" name="p_price" maxlength="10" placeholder="Enter The Price Per Premium Pack">
			                            </div>
			                        </div>
			                        <div class="form-group">
			                        	<label for="cl_style" class="col-sm-2 control-label"> Packing Option</label>
			                            <div class="col-sm-5" id="rdefaultpacking-option">
			                                <input type="text" class="form-control" name="rpk_option" maxlength="25" placeholder="Enter A Regular Packing Option (Optional)">
			                            </div>
			                            <div class="col-sm-5" id="pdefaultpacking-option">
			                                <input type="text" class="form-control" name="ppk_option" maxlength="25" placeholder="Enter A Premium Packing Option (Optional)">
			                            </div>
			                        </div>
		                    	</div>
		                        <?php } ?>
		                        <?php echo '<input type="hidden" class="form-control" name="fsh_id" value="'.$fish->id.'">'; ?><br/>
		                        <div class="form-group">
		                            <div class="col-sm-offset-4 col-sm-5">
		                                <button type="submit" name="<?php if (!empty($fish_id)) { echo 'updateFish'; } else { echo 'addFish'; } ?>" class="btn btn-primary btn-lg"><?php if (!empty($fish_id)) { echo 'Edit Fish'; } else {echo 'Add New Fish';} ?></button>
		                            </div>
		                        </div>
		                    </form>
		                    <?php
			                    if (!empty($fish_id)) {
				                    $ch_styles = ChopStyle::getByFishId($fish->id);
									$cl_styles = CleanStyle::getByFishId($fish->id);
									$pr_options = PriceOption::getByFishId($fish->id);
									$pk_options = PackOption::getByFishId($fish->id);
							?>
							<div class="row">
			                    <div class="col-sm-6">
			                    	<h2>Chopping Styles&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".addChFish">&nbsp;Add New&nbsp;</button>'; ?></h2></br>
			                    	<div class="table-responsive" style="overflow-x: auto;">
			                            <table class="table table-bordered">
			                            	<thead>
			                            		<tr>
			                            			<th class="th-align">Style Id</th>
			                            			<th class="th-align">Fish Id</th>
			                            			<th class="th-align">Type</th>
			                            			<th class="th-align">Style Name</th>
			                            			<th class="th-align">Action</th>
			                            			</tr>
			                            	</thead>
			                            	<tbody>
			                            		<?php
									        		foreach ($ch_styles as $ch_style) {
									        	?>
			                            		<tr>
			                            			<td class="td-align"><?php echo $ch_style->id; ?></td>
			                            			<td class="td-align"><?php echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target=".chclFish">'.$ch_style->fsh_id.'</button>'; ?></td>
			                            			<td class="td-align"><?php if ($ch_style->isPrm) {echo 'Premium';} else {echo 'Regular';} ?></td>
			                            			<td class="td-align"><?php echo $ch_style->style; ?></td>
			                            			<td class="td-align">
			                            				<?php echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".editChFish'.$ch_style->id.'">&nbsp;Edit&nbsp;</button>'; ?>&nbsp;&nbsp;&nbsp;
			                            				<a href="actions/fish_action.php?tab=<?php echo $tab.'&ch_id='.$ch_style->id; ?>" id="confirmDelete"><button type="button" class="btn btn-danger">Delete</button></a>
			                            			</td>
			                            		</tr>
			                            		<?php } ?>
			                            	</tbody>
			                            </table>
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-6">
		                    		<h2>Cleaning Styles&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".addClFish">&nbsp;Add New&nbsp;</button>'; ?></h2></br>
			                    	<div class="table-responsive" style="overflow-x: auto;">
			                            <table class="table table-bordered">
			                            	<thead>
			                            		<tr>
			                            			<th class="th-align">Style Id</th>
			                            			<th class="th-align">Fish Id</th>
			                            			<th class="th-align">Type</th>
			                            			<th class="th-align">Style Name</th>
			                            			<th class="th-align">Action</th>
			                            			</tr>
			                            	</thead>
			                            	<tbody>
			                            		<?php
									        		foreach ($cl_styles as $cl_style) {
									        	?>
			                            		<tr>
			                            			<td class="td-align"><?php echo $cl_style->id; ?></td>
			                            			<td class="td-align"><?php echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target=".chclFish">'.$cl_style->fsh_id.'</button>'; ?></td>
			                            			<td class="td-align"><?php if ($cl_style->isPrm) {echo 'Premium';} else {echo 'Regular';} ?></td>
			                            			<td class="td-align"><?php echo $cl_style->style; ?></td>
			                            			<td class="td-align">
			                            				<?php echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".editClFish'.$cl_style->id.'">&nbsp;Edit&nbsp;</button>'; ?>&nbsp;&nbsp;&nbsp;
			                            				<a href="actions/fish_action.php?tab=<?php echo $tab.'&cl_id='.$cl_style->id; ?>" id="confirmDelete"><button type="button" class="btn btn-danger">Delete</button></a>
			                            			</td>
			                            		</tr>
			                            		<?php } ?>
			                            	</tbody>
			                            </table>
		                    		</div>
		                    	</div>
	                    	</div>
	                    	<div class="row">
	                    		<div class="col-sm-6">
			                    	<h2>Pricing Options&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".addPrFish">&nbsp;Add New&nbsp;</button>'; ?></h2></br>
			                    	<div class="table-responsive" style="overflow-x: auto;">
			                            <table class="table table-bordered">
			                            	<thead>
			                            		<tr>
			                            			<th class="th-align">Option Id</th>
			                            			<th class="th-align">Fish Id</th>
			                            			<th class="th-align">Type</th>
			                            			<th class="th-align">Option Name</th>
			                            			<th class="th-align">Price</th>
			                            			<th class="th-align">Action</th>
			                            			</tr>
			                            	</thead>
			                            	<tbody>
			                            		<?php
									        		foreach ($pr_options as $pr_option) {
									        	?>
			                            		<tr>
			                            			<td class="td-align"><?php echo $pr_option->id; ?></td>
			                            			<td class="td-align"><?php echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target=".chclFish">'.$pr_option->fsh_id.'</button>'; ?></td>
			                            			<td class="td-align"><?php if ($pr_option->isPrm) {echo 'Premium';} else {echo 'Regular';} ?></td>
			                            			<td class="td-align"><?php echo $pr_option->opt_name; ?></td>
			                            			<td class="td-align"><?php echo $pr_option->price.' <i class="icon-rupee"></i>'; ?></td>
			                            			<td class="td-align">
			                            				<?php echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".editPrFish'.$pr_option->id.'">&nbsp;Edit&nbsp;</button>'; ?>&nbsp;&nbsp;&nbsp;
			                            				<a href="actions/fish_action.php?tab=<?php echo $tab.'&pr_id='.$pr_option->id; ?>" id="confirmDelete"><button type="button" class="btn btn-danger">Delete</button></a>
			                            			</td>
			                            		</tr>
			                            		<?php } ?>
			                            	</tbody>
			                            </table>
		                    		</div>
		                    	</div>
		                    	<div class="col-sm-6">
		                    		<h2>Packing Options&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".addPkFish">&nbsp;Add New&nbsp;</button>'; ?></h2></br>
			                    	<div class="table-responsive" style="overflow-x: auto;">
			                            <table class="table table-bordered">
			                            	<thead>
			                            		<tr>
			                            			<th class="th-align">Option Id</th>
			                            			<th class="th-align">Fish Id</th>
			                            			<th class="th-align">Type</th>
			                            			<th class="th-align">Option Name</th>
			                            			<th class="th-align">Action</th>
			                            			</tr>
			                            	</thead>
			                            	<tbody>
			                            		<?php
									        		foreach ($pk_options as $pk_option) {
									        	?>
			                            		<tr>
			                            			<td class="td-align"><?php echo $pk_option->id; ?></td>
			                            			<td class="td-align"><?php echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target=".chclFish">'.$pk_option->fsh_id.'</button>'; ?></td>
			                            			<td class="td-align"><?php if ($pk_option->isPrm) {echo 'Premium';} else {echo 'Regular';} ?></td>
			                            			<td class="td-align"><?php echo $pk_option->opt_name; ?></td>
			                            			<td class="td-align">
			                            				<?php echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".editPkFish'.$pk_option->id.'">&nbsp;Edit&nbsp;</button>'; ?>&nbsp;&nbsp;&nbsp;
			                            				<a href="actions/fish_action.php?tab=<?php echo $tab.'&pk_id='.$pk_option->id; ?>" id="confirmDelete"><button type="button" class="btn btn-danger">Delete</button></a>
			                            			</td>
			                            		</tr>
			                            		<?php } ?>
			                            	</tbody>
			                            </table>
		                    		</div>
		                    	</div>
	                    	</div>
		                    <?php } ?>
			        	</div>
                    <?php } ?>
                    <?php if ($tab == 4) { ?>
                        <div class="center">
			        		<h2>Order Details</h2>			        	
							<div class="table-responsive" style="overflow-x: auto;">
	                            <table class="table table-bordered">
	                            	<thead>
	                            		<tr>
	                            			<th class="th-align">Order Id</th>
	                            			<th class="th-align">User Id</th>
	                            			<th class="th-align">Fish Id</th>
	                            			<th class="th-align">Type</th>
	                            			<th class="th-align">Chopping Style</th>
	                            			<th class="th-align">Cleaning Style</th>
	                            			<th class="th-align">Pricing Option</th>
	                            			<th class="th-align">Packing Option</th>
	                            			<th class="th-align">Quantity</th>
	                            			<th class="th-align">Amount</th>
	                            			<th class="th-align">Status</th>
	                            			<th class="th-align">Tracking Details</th>
	                            			<th class="th-align">Remarks</th>
	                            			<th class="th-align">TimeStamp</th>
	                            			<th class="th-align">Action</th>
	                            		</tr>
	                            	</thead>
	                            	<tbody>
	                            		<?php
							        		$orders = Order::find_all_by_time();
							        		foreach ($orders as $order) {
							        	?>
	                            		<tr>
	                            			<td class="td-align"><?php echo getOrderId($order->id); ?></td>
	                            			<td class="td-align"><?php echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target=".ordereduser'.$order->id.'">'.$order->usr_id.'</button>'; ?></td>
	                            			<td class="td-align"><?php echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target=".orderedfish'.$order->id.'">'.$order->fsh_id.'</button>'; ?></td>
	                            			<td class="td-align"><?php if ($order->isPrm) {echo 'Premium';} else {echo 'Regular';} ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($order->ch_style); ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($order->cl_style); ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($order->pr_opt); ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($order->pk_opt); ?></td>
	                            			<td class="td-align"><?php echo $order->qtty; ?></td>
	                            			<td class="td-align"><?php echo $order->amount.' <i class="icon-rupee"></i>';; ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($order->status); ?></td>
	                            			<td class="td-align"><?php echo $order->tracking; ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($order->remarks); ?></td>
	                            			<td class="td-align"><?php echo $order->timestamp; ?></td>
	                            			<td class="td-align">
	                            				<?php echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".editOrder'.$order->id.'">&nbsp;Edit&nbsp;</button>'; ?><br/><br/>
	                            				<a href="actions/order_action.php?tab=<?php echo $tab.'&ord_id='.$order->id; ?>&delOrder" id="confirmDelete"><button type="button" class="btn btn-danger">Delete</button></a>
	                            			</td>
	                            		</tr>
	                            		<?php } ?>
	                            	</tbody>
	                            </table>
	                    	</div>
                    	</div>
                    <?php } ?>
                    <?php if ($tab == 5) { ?>
                    	<div class="center">
			        		<h2>Registered Users</h2>			        	
							<div class="table-responsive" style="overflow-x: auto; font-size: 13px;">
	                            <table class="table table-bordered">
	                            	<thead>
	                            		<tr>
	                            			<th class="th-align">Id</th>
	                            			<th class="th-align">Bldng</th>
		                        			<th class="th-align">First Name</th>
		                        			<th class="th-align">Last Name</th>
		                        			<th class="th-align">Nationality</th>
		                        			<th class="th-align">National Id</th>
		                        			<th class="th-align">Landmark</th>
		                        			<th class="th-align">Building Popular Name</th>
		                        			<th class="th-align">Flat Number</th>
		                        			<th class="th-align">Family Number</th>
		                        			<th class="th-align">Phone</th>
		                        			<th class="th-align">Email</th>
		                        			<th class="th-align">Password</th>
		                        			<th class="th-align">Activation Status</th>
		                        			<th class="th-align">Action</th>
	                            		</tr>
	                            	</thead>
	                            	<tbody>
	                            		<?php
							        		$users = User::find_all();
							        		foreach ($users as $user) {
							        	?>
	                            		<tr>
	                            			<td class="td-align"><?php echo $user->id; ?></td>
	                            			<td class="td-align"><?php echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target=".userBldng'.$user->id.'">'.$user->bld_id.'</button>'; ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($user->fname); ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($user->lname); ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($user->nationality); ?></td>
	                            			<td class="td-align"><?php echo $user->national_id; ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($user->landmark); ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($user->build_pop_name); ?></td>
	                            			<td class="td-align"><?php echo $user->flat_num; ?></td>
	                            			<td class="td-align"><?php echo $user->fam_num; ?></td>
	                            			<td class="td-align"><?php echo $user->phone; ?></td>
	                            			<td class="td-align"><?php echo $user->email; ?></td>
	                            			<td class="td-align"><?php echo $user->password; ?></td>
	                            			<td class="td-align"><?php if ($user->isActvd == 1) echo "Verified"; elseif ($user->isActvd == 2) echo "Blocked"; else echo "Pending"; ?></td>
	                            			<td class="td-align">
	                            				<?php echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".editUser'.$user->id.'">&nbsp;Edit&nbsp;</button>'; ?>&nbsp;&nbsp;&nbsp;
	                            				<a href="actions/user_action.php?tab=<?php echo $tab.'&usr_id='.$user->id; ?>&delUser" id="confirmDelete"><button type="button" class="btn btn-danger">Delete</button></a>
	                            			</td>
	                            		</tr>
	                            		<?php } ?>
	                            	</tbody>
	                            </table>
	                    	</div>
                    	</div>
                    <?php } ?>
                    <?php if ($tab == 6) { ?>
                        <div class="center">
			        		<h2>User Feedbacks</h2>
			        		<div class="table-responsive" style="overflow-x: auto;">
	                            <table class="table table-bordered">
	                            	<thead>
	                            		<tr>
	                            			<th class="th-align">Feedback Id</th>
		                        			<th class="th-align">User Id</th>
		                        			<th class="th-align">Subject</th>
		                        			<th class="th-align">Message</th>
		                        			<th class="th-align">Action</th>
		                        		</tr>
	                            	</thead>
	                            	<tbody>
	                            		<?php
							        		$feedbacks = Feedback::find_all();
							        		foreach ($feedbacks as $feedback) {
							        	?>
	                            		<tr>
	                            			<td class="td-align"><?php echo convert_to_camel_case($feedback->id); ?></td>
	                            			<td class="td-align"><?php echo '<button type="button" class="btn btn-default" data-toggle="modal" data-target=".writtenUser'.$feedback->id.'">'.$feedback->usr_id.'</button>'; ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($feedback->subject); ?></td>
	                            			<td class="td-align" style="text-align:left;"><?php echo $feedback->message; ?></td>
	                            			<td class="td-align">
	                            				<a href="actions/fb_action.php?tab=<?php echo $tab.'&fb_id='.$feedback->id; ?>&delFb" id="confirmDelete"><button type="button" class="btn btn-danger">Delete</button></a>
	                            			</td>
	                            		</tr>
	                            		<?php } ?>
	                            	</tbody>
	                            </table>
	                    	</div>
                    	</div>
                    <?php } ?>
                    <?php if ($tab == 7) { ?>
                        <div class="center">
			        		<h2>Building Details&nbsp;&nbsp;&nbsp;&nbsp;<?php echo '<button type="button" class="btn btn-success" data-toggle="modal" data-target=".addBldng">&nbsp;Add New Building&nbsp;</button>'; ?></h2>
			        		<div class="table-responsive" style="overflow-x: auto;">
	                            <table class="table table-bordered">
	                            	<thead>
	                            		<tr>
	                            			<th class="th-align">Id</th>
		                        			<th class="th-align">Building Name</th>
		                        			<th class="th-align">Street Name</th>
		                        			<th class="th-align">SubArea Name</th>
		                        			<th class="th-align">Area Name</th>
		                        			<th class="th-align">Actions</th>
		                        		</tr>
	                            	</thead>
	                            	<tbody>
	                            		<?php
							        		$bldngs = Building::find_all();
							        		foreach ($bldngs as $bldng) {
							        	?>
	                            		<tr>
	                            			<td class="td-align"><?php echo $bldng->id; ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($bldng->bldng_name); ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($bldng->street_name); ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($bldng->sarea_name); ?></td>
	                            			<td class="td-align"><?php echo convert_to_camel_case($bldng->area_name); ?></td>
	                            			<td class="td-align">
	                            				<a href="actions/bld_action.php?tab=<?php echo $tab.'&bldng='.$bldng->id; ?>&delBldng" id="confirmDelete"><button type="button" class="btn btn-danger">Delete</button></a>
	                            			</td>
	                            		</tr>
	                            		<?php } ?>
	                            	</tbody>
                            	</table>
	                    	</div>
                    	</div>
                    <?php } ?>
    			</div>
    			<br/><br/><br/>
        	</div>
        </div>
    </div>
</div>
<?php
    include "footer.php";
    if(isset($database)) { $database->close_connection(); }
?>