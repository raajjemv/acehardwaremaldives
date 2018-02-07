<?php
if ($_POST['login'])
{
	$username = sanitize($_POST['email'], SQL);
	$password = sanitize($_POST['password'], SQL);
	 
	$qry = "SELECT * FROM customer WHERE email_address='$username' AND password='$password' AND status = 1"; 
	$result = mysql_query($qry);
	if(mysql_num_rows($result) > 0) {
		//session_regenerate_id();
		$user = mysql_fetch_assoc($result);
		$_SESSION['SESS_CUS_AUTH']	= true;	
		$_SESSION['SESS_CUS_ID']	= $user['id'];
		$_SESSION['SESS_CUS_NAME'] 	= $user['contact_person'];
		session_write_close();
		$redirect_url = $wwwroot . '/index.php';
		$success_login = '<meta http-equiv="refresh" content="3;url=' . $redirect_url .'"><div class="alert alert-success alert-login">Login Successful. Please wait...</div>';
	}else{
		$_SESSION['SESS_CUS_NAME'] 	= "";
		$_SESSION['SESS_CUS_ID'] 	= "";
		$_SESSION['SESS_CUS_AUTH'] 	= false;
		$error_login = '<div class="alert alert-error alert-login">Username and password do not match.</div>';
	}	
}

if ($_GET['logout'])
{
	$_SESSION['SESS_CUS_NAME'] 	= "";
	$_SESSION['SESS_CUS_ID'] 	= "";
	$_SESSION['SESS_CUS_AUTH'] 	= false;
	$success_login = '<div class="alert alert-success alert-login">Logout Successful. </div>';
}

if ($_POST['register'])
{
//	fullname emailaddress company contact
	$fullname 		= sanitize($_POST['fullname'], SQL);
	$emailaddress 	= sanitize($_POST['emailaddress'], SQL);
	$company 		= sanitize($_POST['company'], SQL);
	$contact 		= sanitize($_POST['contact'], SQL);
	$password		= randomPassword();
	if (empty($_SESSION['captcha']) || strtolower(trim($_REQUEST['captcha'])) != $_SESSION['captcha']) {
		$invalid_captcha = '<div class="alert alert-error alert-login">Invalid Captcha.</div>';
	}else{
		if (filter_var($emailaddress, FILTER_VALIDATE_EMAIL) && $fullname && $company && $contact) {
			$qry = "SELECT email_address FROM customer WHERE email_address='$emailaddress'"; 
			$result = mysql_query($qry);
			if(mysql_num_rows($result) > 0) {
				$error_register = '<div class="alert alert-error alert-login">The email address is registered with us already.</div>';	
			}else{
				$insert = "INSERT INTO customer (email_address, password, contact_person, contact_no, company, status) VALUES ('$emailaddress', '$password', '$fullname',	'$contact',	'$company',	2)";
				if(mysql_query($insert)){
					$success_register = '<div class="alert alert-success">Thank you for registering with our online store. An activation link will be emailed to you within 24 hours.</div>';
					//NOTFICATION MAILER
					$mail_subject 	= "Website Notification : $fullname, registered at www.acehardwaremaldives.com";
					$mail_body 		= "$fullname / $company, registered at acehardwaremaldives.com, this account requires activation from the CMS. For activation, please login at acehardwaremaldives.com";
					notification_mailer("admin@acemaldives.com.mv", $mail_subject, $mail_body);
					welcome_mailer($emailaddress);
				}else{
					$error_register = '<div class="alert alert-error alert-login">There was an unexpected error during registration. Please contact info@acehardware.com.mv or try again later.</div>';	
				}
			}
		}else{
			$invalid_email = (!filter_var($emailaddress, FILTER_VALIDATE_EMAIL)) ? "Invalid Email address and " : " ";
			$error_register = '<div class="alert alert-error alert-login"> ' . $invalid_email . ' Please fill all the fields in this form.</div>';
		}
	}
}

if ($_POST['send_feedback'])
{
//	name email message captcha
	$name 		= sanitize($_POST['name'], SQL);
	$email 		= sanitize($_POST['email'], SQL);
	$message 	= sanitize($_POST['message'], SQL);
	
	if (empty($_SESSION['captcha']) || strtolower(trim($_REQUEST['captcha'])) != $_SESSION['captcha']) {
		$invalid_captcha = '<div class="alert alert-error alert-login">Invalid Captcha.</div>';
	}else{
		if (filter_var($email, FILTER_VALIDATE_EMAIL) && $name && $message) {
			$mail_subject 	= "Website Feedback : $name, just sent a message";
			$mail_body		= $message;
			notification_mailer("admin@acemaldives.com.mv", $mail_subject, $mail_body);
			$success_register = '<div class="alert alert-success">Thank you. We will get back to you as soon as possible</div>';
		}else{
			$invalid_email = (!filter_var($emailaddress, FILTER_VALIDATE_EMAIL)) ? "Invalid Email address and " : " ";
			$error_register = '<div class="alert alert-error alert-login"> ' . $invalid_email . ' Please fill all the fields in this form.</div>';
		}
	}
}

if ($_POST['process_quotation'] && $_SESSION['SESS_CUS_AUTH'] && count($_SESSION['SHOPPING_CART']) != 0)
{
	//quo_req_no quo_date quo_shipping_address
	$error = 0;
	$quo_req_no 			= get_latest_quotation_request_no();
	$quo_cus_id 			= sanitize($_SESSION['SESS_CUS_ID'], INT);
	$quo_date 				= date("Y") . '-' . date("m") . '-' . date("d");
	$quo_date_time 			= date("Y") . '-' . date("m") . '-' . date("d") . ' ' . date("H") . '-' . date("i") . '-' . date("s");
	$quo_shipping_address	= sanitize($_POST['quo_shipping_address'], SQL);
	$status					= 1;
	$insert_quotation 		= "INSERT INTO quotation_request (quotation_request_no, customer_id, date, status, date_time, shipping_address) VALUES ('$quo_req_no', $quo_cus_id, '$quo_date', '$status', '$quo_date_time', '$quo_shipping_address')";
	
	foreach ($_SESSION['SHOPPING_CART'] as $itemNumber => $item) {
		$product_id  = sanitize($item['product_id'], INT); 
		$product_qty = sanitize($item['product_qty'], INT);
		
		$item_insert = "INSERT INTO quotation_requested_items (quotation_request_no, customer_id, product_id, qty) VALUES ('$quo_req_no', '$quo_cus_id', '$product_id', '$product_qty')";
		if(!mysql_query($item_insert)){
			$error++;
		}
	}
	if(!mysql_query($insert_quotation)){
		$error++;
	}
	
	if($error == 0){
		$success_process_quo = '<div class="alert alert-success">Thank you. We will get back to you as soon as possible.</div>';
		//NOTFICATION MAILER
		$mail_customer_name 	= get_customer_info($quo_cus_id, "contact_person");
		$mail_customer_company 	= get_customer_info($quo_cus_id, "company");
		$mail_count_shop_items  = count($_SESSION['SHOPPING_CART']);
		$mail_subject 			= "Website Notification : $mail_customer_name, requested for a quotation";
		$mail_body 				= "$mail_customer_name / $mail_customer_company, requested for a quotation with $mail_count_shop_items items. Quotation No. AC/QR/$quo_req_no. For further details please login at acehardwaremaldives.com";
		notification_mailer("sales@acemaldives.com.mv", $mail_subject, $mail_body);
		notification_mailer("sales2@acemaldives.com.mv", $mail_subject, $mail_body);
		unset($_SESSION['SHOPPING_CART']);
	}else{
		$error_process_quo = '<div class="alert alert-error alert-login">There was an unexpected error processing the quotation. Please contact info@acehardware.com.mv or try again later.</div>';
	}
}

if ($_POST['update_profile'] && $_SESSION['SESS_CUS_AUTH'] && $_SESSION['SESS_CUS_ID'])
{
	$cus_id 			= sanitize($_SESSION['SESS_CUS_ID'], INT);
	$fullname 			= sanitize($_POST['fullname'], SQL);
	$emailaddress 		= sanitize($_POST['emailaddress'], SQL);
	$company 			= sanitize($_POST['company'], SQL);
	$contact 			= sanitize($_POST['contact'], SQL);
	$shipping_address 	= sanitize($_POST['shipping_address'], SQL);
	$new_password 		= sanitize($_POST['new_password'], SQL);
	if($new_password != ""){
		$sql_password = "password = '$new_password',";
	}else{
		$sql_password = "";
	}
	//fullname emailaddress company contact shipping_address new_password $error_process_quo $success_process_quo
	
	if (filter_var($emailaddress, FILTER_VALIDATE_EMAIL) && $fullname && $company && $contact) {
		$qry = "UPDATE customer SET email_address 		= '$emailaddress',
									$sql_password
									contact_person 		= '$fullname',
									contact_no 			= '$contact',
									company 			= '$company',
									shipping_address 	= '$shipping_address'
									WHERE id 			= $cus_id";
		if(mysql_query($qry)){
			$success_process_quo = '<div class="alert alert-success">Your account updated successfully.</div>';
		}else{
			$error_process_quo = '<div class="alert alert-error alert-login">There was an unexpected error. Please contact info@acehardware.com.mv or try again later.</div>';
		}
	}else{
		$invalid_email = (!filter_var($emailaddress, FILTER_VALIDATE_EMAIL)) ? "Invalid Email address and " : " ";
		$error_process_quo = '<div class="alert alert-error alert-login"> ' . $invalid_email . ' Please fill all the fields in this form.</div>';
	}
}
?>