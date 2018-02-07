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
?>
<?php
if($_POST['saveSettings']){
	// Check required fields
	if($_POST['website_status']){		
		// list all fields
		$website_status 		= GetSQLValueString($_POST['website_status'], "int");
		$maintenance_message 	= GetSQLValueString($_POST['maintenance_message'], "text");
		//
		$qry = "UPDATE settings SET website_status 		= $website_status,
									maintenance_message = $maintenance_message
									WHERE id = 1"; 
		//echo $qry;																	
		if(mysql_query($qry)){
			$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Website Updated.</div>';
			activityMonitor($global_user_id, "Website Maintenance", "update", "settings");
		}else{
			$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . $qry . '</div>' ;
		}
	}else{
		$feedback_error = '<div class="alert"><i class="icon-warning-sign"></i>Please fill all the fields in the form.</div>';
	}
}
?>
<?php
$sql = 'SELECT * FROM settings WHERE id = 1';
if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
$row_editor = mysql_fetch_assoc($result);
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
$main_page = 'settings';
$sub_page  = 'settings.maintenance';
?>
<?php include('../inc.topnav.php'); ?>
<?php include('../inc.sidenav.php'); ?>
<div class="content">
	<div class="container-fluid">
		<div id="pad-wrapper" class="form-page">
		
			<div class="table-wrapper products-table " style="margin-bottom: 0;">
				<div class="row-fluid head">
				    <div class="span12">
				        <h4>Website Maintenance</h4>
				    </div>
				</div><!-- /row-fluid head -->
			</div><!-- /table-wrapper products-table -->
			
			<div class="row-fluid form-wrapper" style="margin-left: 20px; margin-top: 20px;">
				<div class="span12 column">
					<?php
					if($feedback_success){ echo $feedback_success; }
					if($feedback_error){ echo $feedback_error; }
					?>
					
					<form method="post" action="index.php">
						<div class="field-box">
							<label>Website Status:</label>
							<div class="ui-select">
								<select name="website_status">
									<option value="1" <?php echo ($row_editor['website_status'] == 1 ? "selected" : ""); ?>>Online</option>
									<option value="2" <?php echo ($row_editor['website_status'] == 2 ? "selected" : ""); ?>>Offline</option>
								</select>
							</div>
						</div>
						
						<div class="field-box">
							<label>Maintenance:</label>
							<div class="wysi-column"><textarea id="wysi" name="maintenance_message" class="span12 wysihtml5" rows="6"><?php echo stripcslashes($row_editor['maintenance_message']); ?></textarea></div>
						</div>
						
						<div class="field-box"><label></label><input type="submit" class="btn-flat primary" name="saveSettings" value="Save Changes" /></div>
					</form>
				</div>
			</div><!-- /row-fluid form-wrapper -->
			
		</div><!-- /pad-wrapper -->
	</div><!-- /container-fluid -->
</div><!-- /content -->
<?php include('../inc.footer.php'); ?>
<script type="text/javascript">
$(".wysihtml5").wysihtml5({
    "font-styles": false
});
</script>
</body>
</html>