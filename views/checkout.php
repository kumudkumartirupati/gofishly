<?php
    require_once("../includes/initialize.php");
    $title = "Shipping Details - Go Fishly";    
    if(!$cart_session->isAddedToCart() && isset($_GET['return_url'])) {
        $return_url = base64_decode($_GET["return_url"]);
        redirect_to($return_url);
    } elseif (!$cart_session->isAddedToCart()) {
        redirect_to('../');
    }
    if($user_session->is_logged_in()) {
        $user = User::find_by_id($user_session->user_id);
        $logged_in = true;
        $user_name = convert_to_camel_case($user->full_name());
    }
    if (isset($user)) {
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
    }
    include "header.php";
?>
<div class="panel panel-default">
    <br/><br/><br/>
    <div class="panel-body">
        <div class="navbar navbar-default">
            <div class="box">
                <div class="center">
                    <?php
                        if(isset($user)) {
                            echo '<h2>Update Your Shipping Details</h2>';
                        } else {
                            echo '<h2>Enter Your Shipping Details</h2>';
                        }
                        if(isset($_GET['err']) && $_GET['err'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Data Processing Error</div><br />';
                        }
                        if(isset($_GET['err_fname']) && $_GET['err_fname'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Enter Your First Name</div><br />';
                        }
                        if(isset($_GET['err_lname']) && $_GET['err_lname'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Enter Your Last Name</div><br />';
                        }
                        if(isset($_GET['err_nationality']) && $_GET['err_nationality'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Enter Your Nationality</div><br />';
                        }
                        if(isset($_GET['err_national_id']) && $_GET['err_national_id'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Enter Your National Id</div><br />';
                        }
                        if(isset($_GET['err_landmark']) && $_GET['err_landmark'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Enter A Landmark</div><br />';
                        }
                        if(isset($_GET['err_phone']) && $_GET['err_phone'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Enter Your Mobile Number</div><br />';
                        }
                        if(isset($_GET['err_bld_id']) && $_GET['err_bld_id'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Select Your Building By Choosing Your Area, SubArea And Street</div><br />';
                        }
                        if(isset($_GET['err_reg_phone']) && $_GET['err_reg_phone'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Your Mobile Number Is Already Registered</div><br />';
                        }
                        if(isset($_GET['err_build_pop_name']) && $_GET['err_build_pop_name'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Enter A Popular Name Of Your Building</div><br />';
                        }
                        if(isset($_GET['inv_ph']) && $_GET['inv_ph'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Phone Number Is Invalid</div><br />';
                        }
                        if(isset($_GET['err_flat_num']) && $_GET['err_flat_num'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Enter Your Flat Number</div><br />';
                        }
                        if(isset($_GET['err_fam_num']) && $_GET['err_fam_num'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Enter Your Family Number</div><br />';
                        }
                        if(isset($_GET['err_email']) && $_GET['err_email'] == 1) {
                            echo '<div class="alert alert-danger" role="alert">Enter Your Email</div><br />';
                        }
                    ?>
                    <form class="form-horizontal" role="form" action="../actions/cfrm_chkot.php" method="post">
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
                                        if ($bld_id != '') {
                                            $building = Building::find_by_id($bld_id);
                                            $check_area = $building->area_name;
                                            $check_sarea = $building->sarea_name;
                                            $check_street = $building->street_name;
                                            $check_bldng = $building->bldng_name;
                                        } else {
                                            $check_area = '';
                                            $check_sarea = '';
                                            $check_street = '';
                                            $check_bldng = '';
                                        }
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
                        <div class="form-group">
                            <div class="col-sm-offset-8 col-sm-3">
                                <button type="submit" name="checkout" class="btn btn-primary">Confirm Checkout</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include "footer.php";
    if(isset($database)) { $database->close_connection(); }
?>