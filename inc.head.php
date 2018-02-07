<?php
$seo_title = get_web_settings("seo_title");
$seo_keywords = get_web_settings("seo_keywords");
$seo_description = get_web_settings("seo_description");
// GENERATE STATS
if(!$_GET['tpl']){
	$stat_section 		= 'home';
	$stat_identifier 	= 'home';
}elseif ($_GET['tpl'] == "myaccount") {
	$stat_section 		= 'myaccount';
	$stat_identifier 	= 'login-register';
}elseif ($_GET['tpl'] == "myaccount" && $_GET['logout'] == true) {
	$stat_section 		= 'myaccount';
	$stat_identifier 	= 'logout';
}elseif ($_GET['tpl'] == "getQuotationForm") {
	$stat_section 		= 'quotation';
	$stat_identifier 	= 'getQuotation';
}elseif ($_GET['tpl'] == "cart") {
	$stat_section 		= 'cart';
	$stat_identifier 	= 'cart';
}elseif ($_GET['tpl'] == "pages") {
	$stat_section 		= 'pages';
	$stat_identifier 	= $_GET['page_id'];
}elseif ($_GET['tpl'] == "getQuotationForm") {
	$stat_section 		= 'quotation';
	$stat_identifier 	= 'getQuotation';
}elseif ($_GET['tpl'] == "category") {
	$stat_section 		= 'category';
	if($_GET['sub_cat_1'] && !$_GET['sub_cat_2']){
		$stat_identifier = $_GET['parent_cat'] . ',' . $_GET['sub_cat_1'];
	}elseif ($_GET['sub_cat_1'] && $_GET['sub_cat_2']) {
		$stat_identifier = $_GET['parent_cat'] . ',' . $_GET['sub_cat_1'] . ',' . $_GET['sub_cat_2'];
	}else{
		$stat_identifier = $_GET['parent_cat'];
	}
}
// SEO TITLE
if($_GET['product_id']){
	$seo_title = get_product_info($_GET['product_id'], "name") . ' - Ace Hardware & Home Centre, Maldives';
	$seo_keywords = get_product_info($_GET['product_id'], "name") . ', ace hardware, maldives';
	$seo_description = strip_tags(get_product_info($_GET['product_id'], "description"), '<li>');
	
	$seo_description = str_replace("</li>", ", ", $seo_description);
	$seo_description = str_replace("<li>", "", $seo_description);
	$seo_description = str_replace('"', "", $seo_description);
	
	$stat_section 		= 'products';
	$stat_identifier 	= get_product_info($_GET['product_id'], "product_id");
}
?>
<title><?php echo $seo_title; ?></title>
<meta name="keywords" content="<?php echo $seo_keywords; ?>" />
<meta name="description" content="<?php echo $seo_description; ?>" />
<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<link rel="icon" href="<?php echo $wwwroot; ?>/favicon.ico">
<!-- Bootstrap -->
<link href="<?php echo $wwwroot_css; ?>/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $wwwroot_css; ?>/styler.css?v=<?php //echo time(); ?>" rel="stylesheet">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300' rel='stylesheet' type='text/css'>
<link href="<?php echo $wwwroot_css; ?>/jquery.mCustomScrollbar.css" rel="stylesheet" />
<style>
@import url("<?php echo $wwwroot_css; ?>/myaccount.css?v=<?php //echo time(); ?>");
@import url("<?php echo $wwwroot_css; ?>/cart.css?v=<?php //echo time(); ?>");
@import url("<?php echo $wwwroot_css; ?>/product.css?v=<?php //echo time(); ?>");
@import url("<?php echo $wwwroot_css; ?>/category.css?v=<?php //echo time(); ?>");
.container{
	width: 970px !important;
}

</style>
