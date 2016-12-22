<?php
	defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
	defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'home'.DS.'u944522567'.DS.'public_html');
	defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');
	defined('UPLOAD_PATH') ? null : define('UPLOAD_PATH', SITE_ROOT.DS.'images'.DS.'portfolio');
	require_once(LIB_PATH.DS.'config.php');
	require_once(LIB_PATH.DS.'functions.php');
	require_once(LIB_PATH.DS.'db.php');
	require_once(LIB_PATH.DS.'db_object.php');
	require_once(LIB_PATH.DS.'usersession.php');
	require_once(LIB_PATH.DS.'adminsession.php');
	require_once(LIB_PATH.DS.'cartsession.php');
	require_once(LIB_PATH.DS.'building.php');
	require_once(LIB_PATH.DS.'user.php');
	require_once(LIB_PATH.DS.'admin.php');
	require_once(LIB_PATH.DS.'fish.php');
	require_once(LIB_PATH.DS.'order.php');
	require_once(LIB_PATH.DS.'packoption.php');
	require_once(LIB_PATH.DS.'priceoption.php');
	require_once(LIB_PATH.DS.'chopstyle.php');
	require_once(LIB_PATH.DS.'cleanstyle.php');
	require_once(LIB_PATH.DS.'feedback.php');
?>