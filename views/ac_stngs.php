<?php
    require_once("../includes/initialize.php");
    $title = "Account Settings - Go Fishly";
    if (!isset($_GET['tab']) && empty($_GET['tab'])) {
        $tab = 1;
    } else {
        $tab = $_GET['tab'];
    }
    if($user_session->is_logged_in()) {
        $user = User::find_by_id($user_session->user_id);
        $logged_in = true;
        $user_name = convert_to_camel_case($user->full_name());
    }
    if(isset($user)) {
    	$fname = $user->fname;
        $lname = $user->lname;
        $nationality = $user->nationality;
        $national_id = $user->national_id;
        $landmark = $user->landmark;
        $bld_id = $user->bld_id;
        $build_pop_name = $user->build_pop_name;
        $flat_num = $user->flat_num;
        $fam_num = $user->fam_num;
        $phone = $user->phone;
        $email = $user->email;
    } else {
        $fname = "";
        $lname = "";
        $nationality = "";
        $national_id = "";
        $landmark = "";
        $bld_id = "";
        $build_pop_name = "";
        $flat_num = "";
        $fam_num = "";
        $phone = "";
        $email = "";
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
        		<h1>Account Settings - <?php echo $user_name; ?></h1>
        		<br/><br/>
                <?php
                    if(isset($_GET['err']) && $_GET['err'] == 1) {
                        echo '<div class="alert alert-danger" role="alert">Data Processing Error</div><br />';
                    }
                    if(isset($_GET['chc_suc']) && $_GET['chc_suc'] == 1) {
                        echo '<div class="alert alert-success" role="alert">Details Successfully Updated</div><br />';
                    }
                    if(isset($_GET['err_pass']) && $_GET['err_pass'] == 1) {
                        echo '<div class="alert alert-danger" role="alert">You Have Entered A Wrong Current Password</div><br />';
                    }
                    if(isset($_GET['err_repass']) && $_GET['err_repass'] == 1) {
                        echo '<div class="alert alert-danger" role="alert">The Two New Password Fields Should Be Same</div><br />';
                    }
                ?>
	        	<div class="panel-group col-xs-12 col-sm-12 col-sm-offset-2 col-sm-offset-2 col-md-8 col-lg-8">
	        		<div class="center">
		        		<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" <?php if($tab==1) {echo 'class="active"';} ?>><a href="ac_stngs.php?tab=1">Change Your Account Password</a></li>
							<li role="presentation" <?php if($tab==2) {echo 'class="active"';} ?>><a href="ac_stngs.php?tab=2">Update Your Contact Details</a></li>
                            <li role="presentation" <?php if($tab==3) {echo 'class="active"';} ?>><a href="ac_stngs.php?tab=3">Give Your Feedback</a></li>
						</ul>
						<div class="col-md-12 col-lg-12">
                            <?php if ($tab == 1) { ?>
                            <div class="center">
                                <h2>Change Your Account Password</h2><br />
                                <form class="form-horizontal" role="form" action="../actions/act_stng_updt.php" method="post">
                                    <div class="form-group">
                                        <label for="c_pass" class="col-sm-4 control-label"><span style="color:red;">*</span> Current Password</label>
                                        <div class="col-sm-4">
                                            <input type="password" class="form-control" name="c_pass" maxlength="40" placeholder="Enter Your Current Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="n_pass" class="col-sm-4 control-label"><span style="color:red;">*</span> New Password</label>
                                        <div class="col-sm-4">
                                            <input type="password" class="form-control" name="n_pass" maxlength="40" placeholder="Enter Your New Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nr_pass" class="col-sm-4 control-label"><span style="color:red;">*</span> Re-Enter New Password</label>
                                        <div class="col-sm-4">
                                            <input type="password" class="form-control" name="nr_pass" maxlength="40" placeholder="Re-Enter Your New Password">
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="tab" value="<?php echo $tab; ?>">
                                    <div class="form-group">
                                        <div class="col-sm-offset-6 col-sm-2">
                                            <button type="submit" name="ch_pass" class="btn btn-primary">Change Password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php } ?>
                        </div>
						<div class="col-md-12 col-lg-12">
                            <?php if ($tab == 2) { ?>
                            <div class="center">
                                <h2>Update Your Contact Details</h2><br />
                                <form class="form-horizontal" role="form" action="../actions/act_stng_updt.php" method="post">
                                    <div class="form-group">
                                        <label for="fullname" class="col-sm-4 control-label"><span style="color:red;">*</span> Full Name</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="fname" maxlength="25" value="<?php echo $fname; ?>" placeholder="Enter First Name">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="lname" maxlength="25" value="<?php echo $lname; ?>" placeholder="Enter Last Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="nationality" class="col-sm-4 control-label"><span style="color:red;">*</span> Nationality / National Id</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="nationality" maxlength="20" value="<?php echo $nationality; ?>" placeholder="Enter Your Nationality">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="national_id" maxlength="15" value="<?php echo $national_id; ?>" placeholder="Enter Your National Id Number">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="building" class="col-sm-4 control-label"><span style="color:red;">*</span> Choose Your Building</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="area" onchange="get_sarea();">
                                                <option value="">Select An Area</option>
                                                <?php
                                                    $building = Building::find_by_id($bld_id);
                                                    $check_area = $building->area_name;
                                                    $areas = Building::getAllAreas();
                                                    foreach ($areas as $area) {
                                                        if ($check_area == $area) {
                                                            echo '<option value="'.$area.'" selected>'.$area.'</option>';
                                                        } else {
                                                            echo '<option value="'.$area.'">'.$area.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control" id="sarea" onchange="get_street();">
                                                <option value="">Select A Sub Area</option>
                                                <?php
                                                    $check_sarea = $building->sarea_name;
                                                    $sareas = Building::getSubAreas($check_area);
                                                    foreach ($sareas as $sarea) {
                                                        if ($check_sarea == $sarea) {
                                                            echo '<option value="'.$sarea.'" selected>'.$sarea.'</option>';
                                                        } else {
                                                            echo '<option value="'.$sarea.'">'.$sarea.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-4">
                                            <select class="form-control" id="street" onchange="get_bldng();">
                                                <option value="">Select A Street Name</option>
                                                <?php
                                                    $check_street = $building->street_name;
                                                    $streets = Building::getStreets($check_sarea, $check_area);
                                                    foreach ($streets as $street) {
                                                        if ($check_street == $street) {
                                                            echo '<option value="'.$street.'" selected>'.$street.'</option>';
                                                        } else {
                                                            echo '<option value="'.$street.'">'.$street.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="bld_id" id="bldng">
                                                <option value="">Select A Building Name</option>
                                                <?php
                                                    $check_bldng = $building->bldng_name;
                                                    $bldngs = Building::getBuildingObjects($check_street, $check_sarea, $check_area);
                                                    foreach ($bldngs as $bldng) {
                                                        if ($check_bldng == $bldng->bldng_name) {
                                                            echo '<option value="'.$bldng->id.'" selected>'.$bldng->bldng_name.'</option>';
                                                        } else {
                                                            echo '<option value="'.$bldng->id.'">'.$bldng->bldng_name.'</option>';
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="landmark" class="col-sm-4 control-label"><span style="color:red;">*</span> Building Popular Name / Landmark</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="build_pop_name" maxlength="30" value="<?php echo $build_pop_name; ?>" placeholder="Building Popular Name">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="landmark" maxlength="25" value="<?php echo $landmark; ?>" placeholder="Landmark">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="flat" class="col-sm-4 control-label"><span style="color:red;">*</span> Flat / Family Number</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="flat_num" maxlength="20" value="<?php echo $flat_num; ?>" placeholder="Enter Your Flat Number">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="fam_num" maxlength="20" value="<?php echo $fam_num; ?>" placeholder="Enter Your Family Number">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-sm-4 control-label"><span style="color:red;">*</span> Email</label>
                                        <div class="col-sm-6">
                                            <input type="email" class="form-control" name="email" maxlength="50" value="<?php echo $email; ?>" placeholder="Enter Your Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone" class="col-sm-4 control-label"><span style="color:red;">*</span> Mobile Number</label>
                                        <div class="col-sm-4">
                                            <input type="text" <?php if ($logged_in) {echo 'readonly';} ?> class="form-control" name="phone" maxlength="9" value="<?php echo $phone; ?>" placeholder="Enter Your Mobile Number">
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" name="tab" value="<?php echo $tab; ?>">
                                    <div class="form-group">
                                        <div class="col-sm-offset-8 col-sm-3">
                                            <button type="submit" name="ch_contact" class="btn btn-primary">Update Contact Details</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-12 col-lg-12">
                            <?php if ($tab == 3) { ?>
                            <div class="center">
                                <h1>Feedback Form</h1>
                                <p>Your suggestions are very valuable to us.</p>
                                <form class="form-horizontal" role="form" action="../actions/act_stng_updt.php" method="post">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" required="required" name="subject" placeholder="Subject">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <textarea name="message" required="required" class="form-control" rows="8" placeholder="Message"></textarea>
                                            </div>
                                            <input type="hidden" class="form-control" name="tab" value="<?php echo $tab; ?>">
                                            <div class="form-group">
                                                <button type="submit" name="feedback" class="btn btn-danger">Send Feedback</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php } ?>
                        </div>
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