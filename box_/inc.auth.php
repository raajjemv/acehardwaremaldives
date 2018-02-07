<?php 
//$_SESSION['SESS_AUTH'] 	  		= true;	
//$_SESSION['SESS_USER_ID'] 	  	= $user['id'];
//$_SESSION['SESS_USER_USERNAME'] 	= $user['username'];
//$_SESSION['SESS_USER_TYPE'] 		= $user['type'];
//1800 = 30 mins
if (time() - $_SESSION['SESS_LAST_ACTIVITY'] > 1800) {
	// echo 'SESSION EXPIRED';
	session_unset();
	session_destroy();
	header("location: " . $wwwroot . '/login.php?session=expired');
}else{
	$global_time_left = time() - $_SESSION['SESS_LAST_ACTIVITY'];
	// session_regenerate_id();
	$_SESSION['SESS_LAST_ACTIVITY'] = time();
}

if(!$_SESSION['SESS_AUTH']){
	header("location: " . $wwwroot . '/login.php');
}else{
	$global_user_id 	= $_SESSION['SESS_USER_ID'];
	$global_user_name 	= $_SESSION['SESS_USER_USERNAME'];
	$global_user_type 	= $_SESSION['SESS_USER_TYPE'];
	
}
?>