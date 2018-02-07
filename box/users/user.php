<?php session_start(); ?>
<?php include_once('../inc.config.php'); ?>
<?php include_once('../inc.auth.php'); ?>
<?php include_once('../inc.sanitize.php'); ?>
<?php include_once('../inc.functions.php'); ?>
<?php
if (! empty ($_POST))
{
	foreach ($_POST as $key => $value) { 
		$_POST [$key] = sanitize ($value, SQL);
	}
	foreach ($_GET as $key => $value) { 
		$_GET [$key] = sanitize ($value, SQL);
	}
}

if($_POST['addUser']){
	// Check required fields
	if($_POST['username'] && $_POST['password']){		
		// list all fields
		$username = GetSQLValueString($_POST['username'], "text");
		$password = GetSQLValueString($_POST['password'], "text");
		$usertype = GetSQLValueString($_POST['type'], "int");
		$status   = GetSQLValueString($_POST['status'], "int");		

		$insert_qry = "INSERT INTO users (username, password, type, status) 
								VALUES ($username, $password, $usertype, $status)";				
		if(mysql_query($insert_qry)){
			$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>New user added to the system.</div>';
			activityMonitor($global_user_id, $_POST['username'], "add", "users");
		}else{
			$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . '</div>' ;
		}
	}else{
		$feedback_error = '<div class="alert"><i class="icon-warning-sign"></i>Please fill all the fields in the form.</div>';
	}
}

if($_POST['updateUser']){
	// Check required fields
	if($_POST['username'] && $_POST['password']){		
		// list all fields
		$user_id  = GetSQLValueString($_POST['user_id'], "int");
		$username = GetSQLValueString($_POST['username'], "text");
		$password = GetSQLValueString($_POST['password'], "text");
		$usertype = GetSQLValueString($_POST['type'], "int");
		$status   = GetSQLValueString($_POST['status'], "int");
	
		$qry = "UPDATE users SET username 	= $username,
								 password 	= $password,
								 type 		= $usertype,
								 status 	= $status
								 WHERE id 	= $user_id"; 													
		if(mysql_query($qry)){
			$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>User information updated.</div>';
			activityMonitor($global_user_id, $_POST['username'], "update", "users");
		}else{
			$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . '</div>' ;
		}
		$_GET['action'] = "edit";
		$_GET['id'] 	= $user_id;
	}else{
		$feedback_error = '<div class="alert"><i class="icon-warning-sign"></i>Please fill all the fields in the form.</div>';
	}
}
?>

<?php
$form_submit_button = 'addUser';
if($_GET['action'] == "edit" && $_GET['id']){
	$form_submit_button = 'updateUser';
	$sql = 'SELECT * FROM users WHERE id = "' . sanitize($_GET['id'], INT). '" ORDER BY username ASC';
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	$row_editor = mysql_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html class="login-bg">
<head>
<?php include('../inc.header.php'); ?>
<link rel="stylesheet" href="<?php echo $wwwroot_css; ?>/compiled/form-showcase.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $wwwroot_css; ?>/compiled/new-user.css" type="text/css" media="screen" />
</head>
<body>
<?php
$main_page = 'user';
$sub_page  = 'users.add';
?>
<?php include('../inc.topnav.php'); ?>
<?php include('../inc.sidenav.php'); ?>
<div class="content">
	 <div class="container-fluid">
	 	<form method="post" action="user.php" enctype="multipart/form-data">
		<div id="pad-wrapper" class="form-page">
			<div class="row-fluid form-wrapper">
				<div class="span8 column">
					<?php
					if($feedback_success){ echo $feedback_success; }
					if($feedback_error){ echo $feedback_error; }
					?>
					<input type="hidden" name="user_id" value="<?php echo $row_editor['id']; ?>" />
					<div class="field-box"><label>Username:</label><input name="username" class="span8" type="text" value="<?php echo $row_editor['username']; ?>" /></div>
					<div class="field-box"><label>Password:</label><input name="password" class="span8" type="password" value="<?php echo $row_editor['password']; ?>" /></div>
					<div class="field-box">
						<label>User Type:</label>
						<select name="type">
							<option value="1" <?php echo ($row_editor['type'] == 1) ? "SELECTED" : ""; ?>>Admin</option>
							<option value="2" <?php echo ($row_editor['type'] == 2) ? "SELECTED" : ""; ?>>Data Entry</option>
							<option value="3" <?php echo ($row_editor['type'] == 3) ? "SELECTED" : ""; ?>>Quotation Only</option>
							<option value="4" <?php echo ($row_editor['type'] == 4) ? "SELECTED" : ""; ?>>Data Entry + Quotation</option>
						</select>
					</div>
					<div class="field-box">
						<label>Status:</label>
						<select name="status">
							<option value="1" <?php echo ($row_editor['status'] == 1) ? "SELECTED" : ""; ?>>Active</option>
							<option value="2" <?php echo ($row_editor['status'] == 2) ? "SELECTED" : ""; ?>>Pending</option>
							<option value="3" <?php echo ($row_editor['status'] == 3) ? "SELECTED" : ""; ?>>Deactivate</option>
						</select>
					</div>
					<div class="field-box"><label></label><input type="submit" class="btn-flat primary" name="<?php echo $form_submit_button; ?>" value="Save Changes" /></div>
				</div>
				
				<div class="span4 column form-sidebar  pull-right">&nbsp;</div><!-- /span4 column -->
				
			</div><!-- /form-wrapper -->
		</div><!-- /form-page -->
		</form>
	 </div><!-- /container-fluid -->
</div><!-- /content -->
<?php include('../inc.footer.php'); ?>
<script type="text/javascript">
$(function () {
	$("#sub_category").attr("disabled", true);
    // wysihtml5 plugin on textarea
    $(".wysihtml5").wysihtml5({
        "font-styles": false
    });
    
//    $(".select2").select2({
//                   placeholder: "Select a State"
//               });
    
    $( "#parent_category" ).change(function() {
    	get_parent_id = $(this).val();
    	data = '&parent_id=' + get_parent_id;
    	if(get_parent_id != "00"){
    		$(".loading-indicator").show();
	    	$.get('<?php echo $wwwroot; ?>/ajax.php?action=getSubCategory' + data , function(data) {
	    		var json = $.parseJSON(data);
	    		$(".loading-indicator").hide();
	    		options = '<option value="00">None</option>';
	    		for (var i = 0; i < json.length; i++) {
	    			options += '<option value="' + json[i].id +'">' + json[i].name + '</option>';
	    		}
	    		console.log(options);
	    		$("#sub_category").attr("disabled", false);
	    		$("#sub_category").html(options);	
	    	});
    	}else{
    		$("#sub_category").attr("disabled", true);
    		$("#sub_category").html("");	
    	}
    });
});
</script>
</body>
</html>