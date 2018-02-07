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
	if($_POST['seo_title'] && $_POST['seo_keywords'] && $_POST['seo_description']){		
		// list all fields
		$seo_title 			= GetSQLValueString($_POST['seo_title'], "text");
		$seo_keywords 		= GetSQLValueString($_POST['seo_keywords'], "text");
		$seo_description 	= GetSQLValueString($_POST['seo_description'], "text");
		//
		$qry = "UPDATE settings SET seo_title 		= $seo_title,
									seo_keywords 	= $seo_keywords,
									seo_description = $seo_description
									WHERE id = 1"; 
		//echo $qry;																	
		if(mysql_query($qry)){
			$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Website SEO Updated.</div>';
			activityMonitor($global_user_id, "Search Engine Optimization", "update", "settings");
		}else{
			$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . '</div>' ;
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
$sub_page  = 'settings.seo';
?>
<?php include('../inc.topnav.php'); ?>
<?php include('../inc.sidenav.php'); ?>
<div class="content">
	<div class="container-fluid">
		<div id="pad-wrapper" class="form-page">
		
			<div class="table-wrapper products-table " style="margin-bottom: 0;">
				<div class="row-fluid head">
				    <div class="span12">
				        <h4>Search Engine Optimization</h4>
				    </div>
				</div><!-- /row-fluid head -->
			</div><!-- /table-wrapper products-table -->
			
			<div class="row-fluid form-wrapper" style="margin-left: 20px; margin-top: 20px;">
				<div class="span12 column">
					<?php
					if($feedback_success){ echo $feedback_success; }
					if($feedback_error){ echo $feedback_error; }
					?>
					
					<form method="post" action="seo.php">
						<div class="field-box"><label>SEO Title:</label><input name="seo_title" class="span8" type="text" value="<?php echo $row_editor['seo_title']; ?>" /></div>
						<div class="field-box"><label>SEO Keywords:</label><input name="seo_keywords" class="span8" type="text" value="<?php echo $row_editor['seo_keywords']; ?>" /></div>
						<div class="field-box"><label>SEO Description:</label>
							<textarea name="seo_description" class="span8" rows="3"><?php echo $row_editor['seo_description']; ?></textarea>
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