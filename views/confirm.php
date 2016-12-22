<?php
    require_once("../includes/initialize.php");
    $title = "Order Confirmation Page - Go Fishly";
    if($user_session->is_logged_in()) {
        $user = User::find_by_id($user_session->user_id);
        $logged_in = true;
        $user_name = convert_to_camel_case($user->full_name());
    }
    include "header.php";
?>
<div class="panel panel-default">
    <br/><br/><br/><br/>
    <div class="panel-body">
        <div class="navbar navbar-default">
            <div class="box">
                <div class="center">
                    <h2>Your order was successfully placed.</h2>
                    <h2>Your login id is your mobile number and password will be sent to your phone</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include "footer.php";
    if(isset($database)) { $database->close_connection(); }
?>