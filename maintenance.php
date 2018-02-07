<?php 
header('content-type:text/html;charset=utf-8');
include_once('inc.config.php'); 
include_once('inc.functions.php');
include_once('inc.sanitize.php');
if(!$_SESSION['SESS_AUTH']){
	$website_status = get_web_settings("website_status");
	if($website_status == 1){
		header('Location: ' . $wwwroot . '/');
	}
}
$message = get_web_settings("maintenance_message");
?>
<title>Ace Hardware & Home Centre - Maldives</title>
<link rel="icon" href="<?php echo $wwwroot; ?>/favicon.ico">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300' rel='stylesheet' type='text/css'>
<style>
@import url(http://weloveiconfonts.com/api/?family=entypo);
*{margin: 0; padding: 0; text-decoration: none;}

[class*="entypo-"]:before {
  font-family: 'entypo', sans-serif;
}

body{
	font-family: 'Open Sans', sans-serif;
	font-weight: 300;
	background-color: #efefef;
}

.message_box{
	width: 500px;
	position: absolute;
	left: 50%;
	top: 10%;
	margin-left: -250px;
	color: #FFF;
	padding: 15px;
	text-align: center;
	background-color: #C82C34;
}
.message_box p{
	font-size: 12px;
}
.spiner1{
	font-size: 72px;
	display: inline-block;
	-webkit-animation:	spin 10s linear infinite;
	-moz-animation:		spin 10s linear infinite;
	animation:			spin 10s linear infinite;
}
@-moz-keyframes spin { 100% { -moz-transform: rotate(360deg); } }
@-webkit-keyframes spin { 100% { -webkit-transform: rotate(360deg); } }
@keyframes spin { 100% { -webkit-transform: rotate(360deg); transform:rotate(360deg); } }
</style>

<div class="message_box">
	<span class="entypo-cog spiner1"></span>
	<h1>Website Under Maintenance</h1>
	<p><?php echo $message; ?></p>
</div>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47809423-1', 'acehardwaremaldives.com');
  ga('require', 'linkid', 'linkid.js');
  ga('send', 'pageview');

</script>