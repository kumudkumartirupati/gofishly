<?php
    $current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    if($admin_session->is_logged_in()) {
        $admin = Admin::find_by_id($admin_session->adm_id);
        $adm_name = convert_to_camel_case($admin->name);
        $adm_role = '('.convert_to_camel_case($admin->role).')';
    } else {
        redirect_to("/".basename(__DIR__)."/login.php"."?return_url=".$current_url);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php if (isset($admin)) { echo $title.' - '.$adm_name; } else { echo $title; } ?></title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/prettyPhoto.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">
    <link href="/css/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
    <link href="/css/cms.css" rel="stylesheet">
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
                <div id="navbar" class="navbar navbar-default" style="height:60px;width:75px;float:right;margin-top:20px; margin-right:20px;padding-top:10px;padding-bottom:5px;overflow:visible;">                       
                    <ul class="nav nav-pills" role="tablist">
                        <?php
                            echo '<li role="presentation" class="dropdown" style="margin-left:10px">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <i class="icon-user"></i> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li role="presentation"><a href="#">'.$adm_name.'</a></li>
                                    <li role="presentation"><a href="#">'.$adm_role.'</a></li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation"><a href="">Account Settings</a></li>
                                    <li role="presentaion"><a href="/'.basename(__DIR__).'/actions/admin_action.php?lo=1&return_url='.$current_url.'">Logout</a></li>
                                </ul>
                            </li>';
                        ?>
                    </ul>
                </div>    
            </div>
        </div>
    </header>