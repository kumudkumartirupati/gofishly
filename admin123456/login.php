<?php
    require_once("../includes/initialize.php");
    if (isset($_GET['return_url'])) {
        $current_url = $_GET['return_url'];
    } else {
        $current_url = "";
    }
    $title = "Login - Admin Panel - Go Fishly";
    if($admin_session->is_logged_in()) {
        redirect_to("index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $title; ?></title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/font-awesome.min.css" rel="stylesheet">
    <link href="../css/prettyPhoto.css" rel="stylesheet">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <link href="../css/cart.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->
<style type="text/css">
    .navbar-default .navbar-nav > li {
margin-left: -10px;
margin-right: -10px;
}
</style>
<body data-spy="scroll" data-target="#navbar" data-offset="0">
    <header id="header" role="banner">
        <div class="container">
            <div id="navbar" class="navbar navbar-default" style="margin-bottom:0px;border-radius:0;overflow:visible;">
                <div class="navbar-header col-sm-offset-3" style="margin-bottom:10px;">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <i class="icon-picture icon-md icon-color2" style="float: left; margin-left: 15px; margin-top: 15px;"></i>
                    <a class="navbar-brand" href="../" style="background:none;padding-top: 25px;
                        padding-bottom: 25px;
                        font-size: 21px;
                        text-shadow: -1px -1px 1px #fff, 1px 1px 1px #000;
                        color: #066599;
                        opacity: 0.7;
                        font: 45px 'Museo700';width:auto;margin-right: 0px;">Go Fishly<i style="font-size:17pt;color:#3290C3">&nbsp;..The only online fish retailer..</i>
                    </a>
                </div>  
            </div>
        </div>
    </header>
    <div class="panel panel-default">
        <br/><br/><br/>
        <div class="box">
            <div class="panel-body">
                <div class="navbar navbar-default">
                    <br/><br/>
                    <div class="center">
                        <h1>Administrator Login - Go Fishly</h1><br />
                        <?php
                            if(isset($_GET['err']) && $_GET['err'] == 1) {
                                echo '<div class="alert alert-danger" role="alert">Invalid Email / Password Combination</div><br />';
                            }
                        ?>
                        <form class="form-horizontal col-sm-offset-3 col-sm-9" role="form" action="actions/admin_action.php" method="post">
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label"><span style="color:red;">*</span> Email</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="email" maxlength="50" placeholder="Enter Your Company Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label"><span style="color:red;">*</span> Password</label>
                                <div class="col-sm-4">
                                    <input type="password" class="form-control" name="password" maxlength="40" placeholder="Enter Your Admin Password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <input type="hidden" class="form-control" name="return_url" value="<?php echo $current_url; ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" name="login" class="btn btn-primary col-sm-2"> Login</button>
                                </div>
                            </div>
                            <br /><br />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; 2014 <a target="_blank" href="http://shapebootstrap.net/" title="Free Twitter Bootstrap WordPress Themes and HTML templates">Go Fishly Pvt. Ltd.</a>. All Rights Reserved.
                </div>                
            </div>
        </div>
    </footer>
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.isotope.min.js"></script>
    <script src="../js/jquery.prettyPhoto.js"></script>
    <script src="../js/jquery.bootstrap-touchspin.min.js"></script>
    <script src="../js/main.js"></script>
</body>
</html>
<?php
    if(isset($database)) { $database->close_connection(); }
?>