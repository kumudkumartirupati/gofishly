<?php
    if (!isset($logged_in) || empty($logged_in)) {
        $logged_in = false;
    }
    $current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php if (isset($user)) { echo $title.' - '.$user_name; } else { echo $title; } ?></title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/prettyPhoto.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <link href="/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <link href="/css/cart.css" rel="stylesheet">
    <link rel="shortcut icon" href="/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->
<style type="text/css">
.navbar-default .navbar-nav > li {
    margin-left: -10px;
    margin-right: -10px;
}
.navbar {
    z-index: 998;
}
</style>
<body data-spy="scroll" data-target="#navbar" data-offset="0">
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="login">Login</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form" action="/actions/user_action.php" method="post">
                        <div id="form_messages"></div>
                        <div class="form-group">
                            <label for="uname" class="col-sm-6 control-label">Username (Mobile Number)</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="uname" id="login_uname" maxlength="9" placeholder="Enter Your 10 digit Mobile Number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pwd" class="col-sm-6 control-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" name="pwd" id="login_pwd" maxlength="40" placeholder="Enter Your Password">
                            </div>
                        </div>
                        <input type="hidden" class="form-control" name="return_url" value="<?php echo $current_url; ?>">
                        <div class="form-group">
                            <div class="col-sm-offset-12 col-sm-12">
                                <button type="button" class="btn btn-primary col-sm-4" data-dismiss="modal">Close</button>
                                <div class="col-sm-4"></div>
                                <div class="center">
                                    <button type="submit" name="login" id="user_login" class="btn btn-primary col-sm-4">Login</button>
                                    <img id="user_login_loading" style="display:none;" src="/images/prettyPhoto/default/loader.gif">
                                </div>                            
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <header id="header" role="banner">
        <div class="container">
            <div id="navbar" class="navbar navbar-default" style="margin-bottom:0px;border-radius:0;overflow:visible;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <i class="icon-picture icon-md icon-color2" style="float: left; margin-left: 15px; margin-top: 15px;"></i>
                    <a class="navbar-brand" href="/" style="background:none;padding-top: 25px;
                        padding-bottom: 25px;
                        font-size: 21px;
                        text-shadow: -1px -1px 1px #fff, 1px 1px 1px #000;
                        color: #066599;
                        opacity: 0.7;
                        font: 45px 'Museo700';width:auto;margin-right: 0px;">Go Fishly<i style="font-size:17pt;color:#3290C3">&nbsp;..The only online fish retailer..</i>
                    </a>
                </div>
                <div id="navbar" class="navbar navbar-default" style="height:60px;width:400px;float:right;margin-right:10px;margin-top:20px;padding-top:10px;padding-bottom:5px;overflow:visible;">                       
                    <ul class="nav nav-pills" role="tablist">
                        <li role="presentation"><a href="#"><i class="glyphicon glyphicon-earphone"></i><span style="margin-left:5px">080-42296199</span></a></li>
                        <li role="presentation"><a href="#"><i class="icon-info-sign"></i><span style="margin-left:5px">Info</span></a></li>
                        <li role="presentation"><a href="#"><i class="icon-question-sign"></i><span style="margin-left:5px">Help</span></a></li>
                        <?php
                            if (!$logged_in) {
                                echo '<li role="presentation"><a href="#login" data-toggle="modal" data-target="#login">Login</a></li>';
                            } else {
                                echo '<li role="presentation" class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                            <i class="icon-user"></i> <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li role="presentation"><a href="#">'.$user_name.'</a></li>
                                            <li role="presentation" class="divider"></li>
                                            <li role="presentation"><a href="/views/order_history.php">Order History</a></li>
                                            <li role="presentation"><a href="/views/ac_stngs.php">Account Settings</a></li>
                                            <li role="presentation" class="divider"></li>
                                            <li role="presentaion"><a href="/actions/user_action.php?lo=1&return_url='.$current_url.'">Logout</a></li>
                                        </ul>
                                    </li>';
                            }
                        ?>
                        <!--  -->
                    </ul>
                </div>    
            </div>
        </div>
    </header><!--/#header-->