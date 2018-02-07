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

if($_POST['addCircular']){
	// Check required fields
	if($_POST['title']){		
		// list all fields
		$title 				= GetSQLValueString($_POST['title'], "text");
		$date 				= GetSQLValueString($_POST['date'], "text");
		$status 			= GetSQLValueString($_POST['status'], "int");	
		$attachment			= GetSQLValueString($_FILES['attachment']['name'], "text");
		$attachment_name	= $_FILES['attachment']['name'];
		//
		$insert_qry = "INSERT INTO promotions_monthly (date, title, attachment, status) 
								   VALUES ($date, $title, $attachment, $status)";						
		// Lets upload the product image now
		$upload_errors = "";
		$directory = "../../core/downloads/";
		// Now uploading begins						
		if($_FILES['attachment']['name']) {
			//chmod($directory ,0777);
			$maxsize    = 10485760;
			$acceptable = array('application/pdf');
			$filetmpname = $_FILES["attachment"]["tmp_name"];
			
//			if(($_FILES['attachment']['size'] >= $maxsize) || ($_FILES["attachment"]["size"] == 0)) {
//				$upload_errors .= 'Image file size must be less than 5 MB. ';
//			}
			if(!in_array($_FILES['attachment']['type'], $acceptable) && !empty($_FILES["attachment"]["type"])) {
				$upload_errors .= 'Invalid file type. Please use PDF document';
			}
			if(!$upload_errors){
				$target  = 	$directory . "/" . $attachment_name;
				// upload the large file
				move_uploaded_file($_FILES['attachment']['tmp_name'], $target);
				//
				//chmod($directory ,0755);
			}
		}
		
		if(!$upload_errors){
			if(mysql_query($insert_qry)){
				$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>New circular added to promotions.</div>';
				activityMonitor($global_user_id, $_POST['title'], "add", "promotion-monthly");
			}else{
				$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . '</div>' ;
			}
		}else{
			$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error! ' . $upload_errors . '</div>' ;
		}
	}else{
		$feedback_error = '<div class="alert"><i class="icon-warning-sign"></i>Please fill all the fields in the form.</div>';
	}
}

if($_POST['updateCircular']){
	include_once("../mod.resize.class.php");
	if($_POST['title']){
		$p_id		 		= GetSQLValueString($_POST['p_id'], "int");
		// list all fields
		$title 				= GetSQLValueString($_POST['title'], "text");
		$date 				= GetSQLValueString($_POST['date'], "text");
		$status 			= GetSQLValueString($_POST['status'], "int");	

		if($_FILES['attachment']['name']){	
			$attachment_name		= $_FILES['attachment']['name'];
			$attachment				= GetSQLValueString($_FILES['attachment']['name'], "text");
		}else{
			$attachment				= GetSQLValueString($_POST['existing_attachment'], "text");
		}
		
		$qry = "UPDATE promotions_monthly SET 	date 				= $date,
												title 				= $title,
												attachment 			= $attachment,
												status 				= $status
												WHERE id 			= $p_id";
		//						
		// Lets upload the product image now
		$upload_errors = "";
		$directory = "../../core/downloads/";
		// Now uploading begins						
		if($_FILES['attachment']['name']) {
			//chmod($directory ,0777);
			$maxsize    = 10485760;
			$acceptable = array('application/pdf');
			$filetmpname = $_FILES["attachment"]["tmp_name"];
			
//			if(($_FILES['attachment']['size'] >= $maxsize) || ($_FILES["attachment"]["size"] == 0)) {
//				$upload_errors .= 'Image file size must be less than 5 MB. ';
//			}
			if(!in_array($_FILES['attachment']['type'], $acceptable) && !empty($_FILES["attachment"]["type"])) {
				$upload_errors .= 'Invalid file type. Please use PDF document';
			}
			if(!$upload_errors){
				$target  = 	$directory . "/" . $attachment_name;
				// upload the large file
				move_uploaded_file($_FILES['attachment']['tmp_name'], $target);
				//
				//chmod($directory ,0755);
			}
		}
		
		if(!$upload_errors){
			if(mysql_query($qry)){
				$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Promotion Updated.</div>';
				activityMonitor($global_user_id, $_POST['title'], "update", "promotion-monthly");
			}else{
				$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . '</div>' ;
			}
		}else{
			$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error! ' . $upload_errors . '</div>' ;
		}
		$_GET['action'] = "edit";
		$_GET['id'] 	= $p_id;	
	}else{
		$feedback_error = '<div class="alert"><i class="icon-warning-sign"></i>Please fill all the fields in the form.</div>';
	}
}
?>

<?php
$form_submit_button = 'addCircular';
if($_GET['action'] == "edit" && $_GET['id']){
	$form_submit_button = 'updateCircular';
	$sql = 'SELECT * FROM promotions_monthly WHERE id = "' . sanitize($_GET['id'], INT). '" ORDER BY title ASC';
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
$main_page = 'promotions';
$sub_page  = 'circular.add';
?>
<?php include('../inc.topnav.php'); ?>
<?php include('../inc.sidenav.php'); ?>
<div class="content">
	 <div class="container-fluid">
	 	<form method="post" action="circular.php" enctype="multipart/form-data">
		<div id="pad-wrapper" class="form-page">
			<div class="row-fluid form-wrapper">
				<div class="span8 column">
					<?php
					if($feedback_success){ echo $feedback_success; }
					if($feedback_error){ echo $feedback_error; }
					?>
					<input type="hidden" name="p_id" value="<?php echo $row_editor['id']; ?>" />
					<div class="field-box"><label>Title:</label><input name="title" class="span8" type="text" value="<?php echo stripcslashes($row_editor['title']); ?>" /></div>
					<div class="field-box"><label>Date:</label><input name="date" class="span8" type="text" value="<?php echo ($row_editor['date']) ? $row_editor['date'] : date('Y-m-d'); ?>" /></div>
					<div class="field-box"><label>PDF Document</label><input class="span8" name="attachment" type="file" /></div>
					
					<div class="field-box"><label></label><input type="submit" class="btn-flat primary" name="<?php echo $form_submit_button; ?>" value="Save Changes" /></div>
				</div>
				
				
				<div class="span4 column form-sidebar  pull-right">
					
					<div class="field-box">
						<label>Status:</label>
						<div class="ui-select ">
							<select name="status">
								<option value="1" <?php echo ($row_editor['status'] == 1 ? "selected" : ""); ?>>Publish</option>
								<option value="2" <?php echo ($row_editor['status'] == 2 ? "selected" : ""); ?>>Pending</option>
								<option value="3" <?php echo ($row_editor['status'] == 3 ? "selected" : ""); ?>>Hidden</option>
							</select>
						</div>
					</div>
					
					<?php
					if($_GET['action'] == "edit" && $row_editor['attachment']){
						$directory = "../../core/downloads/" . $row_editor['attachment'];
						if (file_exists($directory)) { 
							echo '<div class="field-box"><label>Existing PDF:</label><a href="'. $directory .'" target="_blank">' . $row_editor['attachment'] . '</a></div>';
							echo '<input type="hidden" name="existing_attachment" value="' . $row_editor['attachment'] . '" />';
						}
					}
					?>
				</div><!-- /span4 column -->
				
			</div><!-- /form-wrapper -->
		</div><!-- /form-page -->
		</form>
	 </div><!-- /container-fluid -->
</div><!-- /content -->
<?php include('../inc.footer.php'); ?>
<script type="text/javascript">
$(function () {
    // wysihtml5 plugin on textarea
    $(".wysihtml5").wysihtml5({
        "font-styles": false
    });
    
});
</script>
</body>
</html>