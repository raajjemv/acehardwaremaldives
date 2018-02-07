<?php
error_reporting(0);
$host = explode(':',$_SERVER['HTTP_HOST']);
if($host[1] == '8888'){
	$db_hostname 	= "localhost";
	$db_port 		= "";
	$db_username 	= "root";
	$db_password 	= "12345678";
	$db_name 		= "acehardware";
	//
	$wwwroot = "http://localhost:8888/acehardware";
}else{
	$db_hostname 	= "198.1.118.47";
	$db_port 		= "";
	$db_username 	= "codemald_ace";
	$db_password 	= "Ace@9283838";
	$db_name 		= "codemald_acehardwaremaldives";
	//
	$wwwroot = "http://acehardwaremaldives.com";
}
//
$wwwroot_core 	= $wwwroot . "/core";
$wwwroot_css 	= $wwwroot_core . "/css";
$wwwroot_img 	= $wwwroot_core . "/images";
$wwwroot_js  	= $wwwroot_core . "/js";
//
// TIME CONFIGURATION
date_default_timezone_set('Asia/Karachi');
$curtime=getdate();
//
// DEFAULT SEO SETTINGS
$default_seo_title 	 = "Ace Hardware";
//
// DB CONNECTOR
if(empty($db_port))
{
	$db = mysql_connect($db_hostname,$db_username,$db_password) or die("Can't connect to - ".$db_hostname);
}else{
	$db = mysql_connect($db_hostname.":".$db_port,$db_username,$db_password) or mysql_die();
}
mysql_select_db($db_name,$db) or die("Error opening database - ".$db_name);
//
$global_hide = false;
// MAIN URLS
$myaccount_myaccount 	= $wwwroot . '/profile/';
$myaccount_cart 		= $wwwroot . '/cart/';
$myaccount_wishlist		= $wwwroot . '/wishlist/'; 
$myaccount_quotations 	= $wwwroot . '/quotation/requests/';
$myaccount_download		= $wwwroot . '/downloads/';
?>
<?php $status_col = array("", "default", "primary", "success", "danger"); ?>
<?php $status_msg = array("", "QR Received", "In-progress", "Completed", "Cancelled"); ?>