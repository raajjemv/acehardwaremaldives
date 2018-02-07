<?php session_start(); ?>
<?php $execution_start_time = microtime(true); ?>
<?php 
header('content-type:text/html;charset=utf-8');
include_once('inc.config.php'); 
include_once('inc.functions.php');
include_once('inc.sanitize.php');
include_once('inc.forms.php'); 
if(!$_SESSION['SESS_AUTH']){
	$website_status = get_web_settings("website_status");
	if($website_status == 2){
		header('Location: ' . $wwwroot . '/maintenance.php');
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<?php include('inc.head.php'); ?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-90454661-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<?php
$skin = "home";
if($_GET['tpl']){ $skin = $_GET['tpl']; }

$locationTPL = 'core/tpl/' . $skin . '.tpl';
//
include_once 'core/tpl/inc.header.tpl';
if (file_exists($locationTPL)) {
	include_once 'core/tpl/' . $skin . '.tpl';
}else{
	include_once 'core/tpl/home.tpl';
}
//
include_once 'core/tpl/inc.footer.tpl';
?>
<?php include('inc.footer.php'); ?>

<?php 
$execution_end_time = microtime(true); 
$execution_time = $execution_end_time - $execution_start_time;
echo "<!--/ $execution_time seconds -->";
?>

<?php include('inc.statistics.php'); ?>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47809423-1', 'acehardwaremaldives.com');
  ga('require', 'linkid', 'linkid.js');
  ga('send', 'pageview');

</script>

</body>
</html>
