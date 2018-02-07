<?php
/* ini_set('display_errors',1);
ini_set('display_startup_errors',1); */
error_reporting(0);
// WEBSITE URLS
$host = explode(':',$_SERVER['HTTP_HOST']);
if($host[1] == '8888'){
	$db_hostname 	 = "localhost";
	$db_port 		 = "";
	$db_username 	 = "root";
	$db_password 	 = "12345678";
	$db_name 		 = "acehardware";
	$wwwroot		 = "http://localhost:8888/acehardware/box";
	$wwwroot_website = "http://localhost:8888/acehardware";
}else{
	$db_hostname 	= "198.1.118.47";
	$db_port 		= "";
	$db_username 	= "codemald_ace";
	$db_password 	= "Ace@9283838";
	$db_name 		= "codemald_acehardwaremaldives";
	$wwwroot 		 = "http://acehardwaremaldives.com/box";
	$wwwroot_website = "http://acehardwaremaldives.com";




}
$wwwroot_core = $wwwroot . "/core";
$wwwroot_css = $wwwroot_core . "/css";
$wwwroot_img = $wwwroot_core . "/img";
$wwwroot_js  = $wwwroot_core . "/js";
//
//
// TIME CONFIGURATION
date_default_timezone_set('Asia/Karachi');
$curtime=getdate();
//
// DEFAULT SEO SETTINGS
$default_seo_title 	 = "BOX CMS - MeemoInc - the Design Company";
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
// PREDEFINED VARIABLES
$category_status_array 			= array("", "Publish", "Pending", "Hidden");
$category_status_colors_array 	= array("", "label-success", "label-info", " ");
//
$product_status_array 			= array("", "Publish", "Pending", "Hidden");
$product_status_colors_array 	= array("", "label-success", "label-info", " ");
//
$page_status_array 				= array("", "Publish", "Pending", "Hidden");
$page_status_colors_array 		= array("", "label-success", "label-info", " ");
//
$news_status_array 				= array("", "Publish", "Pending", "Hidden");
$news_status_colors_array 		= array("", "label-success", "label-info", " ");
//
$users_status_array 			= array("", "Active", "Pending", "Deactivate");
$users_status_colors_array 		= array("", "label-success", "label-info", " ");
$users_type_array 				= array("", "Admin", "Data Entry", "Quotation Access", "Data Entry + Quotation Access");
//
$customer_status_array 			= array("", "Active", "Pending", "Suspended");
$customer_status_colors_array 	= array("", "label-success", "label-info", " ");
//
$banner_status_array 			= array("", "Active", "Pending", "Suspended");
$banner_status_colors_array 	= array("", "label-success", "label-info", " ");
//
$promotions_types_array 		= array("", "Red Hot Offers", "Featured Products");
$promotions_status_array 		= array("", "Active", "Pending", "Deactivate");
$promotions_status_colors_array = array("", "label-success", "label-info", " ");
//
$quo_status_colors_array = array("", "default", "label-info", "label-success", "label-cancel");
$quo_status_msg_array = array("", "Received", "In-progress", "Completed", "Cancelled");
?>