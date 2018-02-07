<?php session_start(); ?>
<?php include_once('inc.config.php'); ?>
<?php include_once('inc.sanitize.php'); ?>
<?php include_once('inc.functions.php'); ?>
<?php
if ($_POST['login'])
{
	$username = sanitize($_POST['username'], SQL);
	$password = sanitize($_POST['password'], SQL);
	
	$qry = "SELECT * FROM users WHERE username='$username' AND password='$password' AND status = 1"; 
	$result = mysql_query($qry);
	if(mysql_num_rows($result) > 0) {
		session_regenerate_id();
		$user = mysql_fetch_assoc($result);
		$_SESSION['SESS_AUTH'] 	  		  	= true;	
		$_SESSION['SESS_USER_ID'] 	  		= $user['id'];
		$_SESSION['SESS_USER_USERNAME'] 	= $user['username'];
		$_SESSION['SESS_USER_TYPE'] 		= $user['type'];
		$_SESSION['SESS_LAST_ACTIVITY'] 	= time();
		session_write_close();
		activityMonitor($user['id'], $user['username'], "login", "login");
		header("location: " . $wwwroot . "/index.php");
		$redirect_url = $wwwroot . '/index.php';
		$success_login = '<meta http-equiv="refresh" content="0;url=' . $redirect_url .'"><div class="alert alert-success" style="text-align:left"><i class="icon-ok-sign"></i>Login Successful. Redirecting to CMS...</div>';
		//$success_login = '<meta http-equiv="refresh" content="0;url=' . $redirect_url .'"><script type="text/javascript">timeleft = 4; setInterval(function(){ timeleft--; document.getElementById("timeleft").innerHTML = timeleft; }, 1000); </script><div class="alert alert-success" style="text-align:left"><i class="icon-ok-sign"></i>Login Successful. Redirecting in <span id="timeleft">4</span> secs</div>';
	}else{
		$_SESSION['SESS_USER_ID'] 		= "";
		$_SESSION['SESS_USER_USERNAME'] = "";
		$_SESSION['SESS_USER_TYPE'] 	= "";
		$_SESSION['SESS_AUTH'] 			= false;
		$error_login = '<div class="alert alert-error" style="text-align:left"><i class="icon-remove-sign"></i>Username and password do not match.</div>';
	}
	
}

if($_GET['logout']){
	activityMonitor($_SESSION['SESS_USER_ID'], $_SESSION['SESS_USER_USERNAME'], "logout", "login");
	$_SESSION['SESS_USER_ID'] 		= "";
	$_SESSION['SESS_USER_USERNAME'] = "";
	$_SESSION['SESS_USER_TYPE'] 	= "";
	$_SESSION['SESS_AUTH'] 			= false;
	session_unset();
	session_destroy();
	$success_login = '<div class="alert alert-success" style="text-align:left"><i class="icon-ok-sign"></i>Logout Successful.</div>';
}

if($_GET['session'] == 'expired'){
	$error_login = '<div class="alert alert-error" style="text-align:left"><i class="icon-remove-sign"></i>Session expired. Please login again.</div>';
}
?>
<!DOCTYPE html>
<html class="login-bg">
<head>
<?php include('inc.header.php'); ?>
<link rel="stylesheet" href="<?php echo $wwwroot_css; ?>/compiled/signin.css" type="text/css" media="screen" />
</head>
<body>

<div class="row-fluid login-wrapper">
    <a href="index.php">
        <img class="logo" src="<?php echo $wwwroot_img; ?>/logo-white.png" />
    </a>

    <div class="span4 box">
    	<form method="post" action="login.php">
        <div class="content-wrap">
            <h6>ACE HARDWARE</h6>
            <?php 
            if($success_login){ echo $success_login; }
            if($error_login){ echo $error_login; } 
            ?>
            <input class="span12" type="text" name="username" placeholder="Username" autocomplete="off"/>
            <input class="span12" type="password" name="password" placeholder="Password" />
            <!--
            <a href="#" class="forgot">Forgot password?</a>
            <div class="remember">
                <input id="remember-me" type="checkbox" />
                <label for="remember-me">Remember me</label>
            </div>
            -->
            <input type="submit" class="btn-glow primary login" name="login" value="LOG IN" />
        </div>
        </form>
    </div>

    <div class="span4 no-account">
        <p>&copy; 2013 box cms by Meemoinc Pvt Ltd. Version 1.0</p>
    </div>
</div>
	
</body>
</html>