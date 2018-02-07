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

if($_POST['addPage']){
	// Check required fields
	include_once("../mod.resize.class.php");
	if($_POST['title']){		
		// list all fields
		$title 				= GetSQLValueString($_POST['title'], "text");
		$alias				= GetSQLValueString(generate_seo_link($_POST['title'], '-', true, ''), "text");
		$subtitle 			= GetSQLValueString($_POST['subtitle'], "text");
		$body 				= GetSQLValueString($_POST['body'], "text");	
		$submenu 			= GetSQLValueString($_POST['submenu'], "text");	
		$status 			= GetSQLValueString($_POST['status'], "int");	
		$seo_title 			= GetSQLValueString($_POST['seo_title'], "text");
		$seo_keywords 		= GetSQLValueString($_POST['seo_keywords'], "text");
		$seo_description 	= GetSQLValueString($_POST['seo_description'], "text");
		$image_name			= generate_seo_link($_POST['title'], '-', true, '');
		$submenu			= GetSQLValueString($_POST['submenu'], "text");
		//
		$insert_qry = "INSERT INTO pages (alias, title, subtitle, body, submenu, status, seo_title, seo_keywords, seo_description) 
								VALUES ($alias, $title, $subtitle, $body, $submenu, $status, $seo_title, $seo_keywords, $seo_description)";						
		// Lets upload the product image now
		$upload_errors = "";
		$directory = "../../core/images/pages/";
		// Now uploading begins						
		if($_FILES['page_image']['name']) {
			chmod($directory ,0777);
			$maxsize    = 409600;
			$acceptable = array('image/jpeg', 'image/jpg', 'image/png');
			$filetmpname = $_FILES["page_image"]["tmp_name"];
			
			if(($_FILES['page_image']['size'] >= $maxsize) || ($_FILES["page_image"]["size"] == 0)) {
				$upload_errors .= 'Image file size must be less than 400 Kb. ';
			}
			if(!in_array($_FILES['page_image']['type'], $acceptable) && !empty($_FILES["page_image"]["type"])) {
				$upload_errors .= 'Invalid file type. Please use jpg image.';
			}
			if(!$upload_errors){
				$target  = 	$directory . "/" . $image_name . ".jpg";
				// upload the large file
				move_uploaded_file($_FILES['page_image']['tmp_name'], $target);
				//
				chmod($directory ,0755);
			}
		}
		
		if(!$upload_errors){
			if(mysql_query($insert_qry)){
				$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>New page added to CMS.</div>';
				activityMonitor($global_user_id, $_POST['title'], "add", "pages");
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

if($_POST['updatePage']){
	include_once("../mod.resize.class.php");
	if($_POST['title']){
		$p_id		 		= GetSQLValueString($_POST['p_id'], "int");
		// list all fields
		$title 				= GetSQLValueString($_POST['title'], "text");
		$alias				= GetSQLValueString(generate_seo_link($_POST['title'], '-', true, ''), "text");
		$subtitle 			= GetSQLValueString($_POST['subtitle'], "text");
		$body 				= GetSQLValueString($_POST['body'], "text");	
		$submenu 			= GetSQLValueString($_POST['submenu'], "text");	
		$status 			= GetSQLValueString($_POST['status'], "int");	
		$seo_title 			= GetSQLValueString($_POST['seo_title'], "text");
		$seo_keywords 		= GetSQLValueString($_POST['seo_keywords'], "text");
		$seo_description 	= GetSQLValueString($_POST['seo_description'], "text");
		$image_name			= generate_seo_link($_POST['title'], '-', true, '');
		$submenu			= GetSQLValueString($_POST['submenu'], "text");
		
		$qry = "UPDATE pages SET 	alias 				= $alias,
									title 				= $title,
									subtitle 			= $subtitle,
									body 				= $body,
									submenu 			= $submenu,
									status 				= $status,
									seo_title			= $seo_title,
									seo_keywords		= $seo_keywords,
									seo_description		= $seo_description
									WHERE id 			= $p_id";
		//						
		// Lets upload the product image now
		$upload_errors = "";
		$directory = "../../core/images/pages/";
		// Now uploading begins						
		if($_FILES['page_image']['name']) {
			chmod($directory ,0777);
			$maxsize    = 409600;
			$acceptable = array('image/jpeg', 'image/jpg', 'image/png');
			$filetmpname = $_FILES["page_image"]["tmp_name"];
			
			if(($_FILES['page_image']['size'] >= $maxsize) || ($_FILES["page_image"]["size"] == 0)) {
				$upload_errors .= 'Image file size must be less than 400 Kb. ';
			}
			if(!in_array($_FILES['page_image']['type'], $acceptable) && !empty($_FILES["page_image"]["type"])) {
				$upload_errors .= 'Invalid file type. Please use jpg image.';
			}
			if(!$upload_errors){
				$target  = 	$directory . "/" . $image_name . ".jpg";
				// upload the large file
				move_uploaded_file($_FILES['page_image']['tmp_name'], $target);
				//
				chmod($directory ,0755);
			}
		}
		
		if(!$upload_errors){
			if(mysql_query($qry)){
				$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Page Updated.</div>';
				activityMonitor($global_user_id, $_POST['title'], "update", "store-products");
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
$form_submit_button = 'addPage';
if($_GET['action'] == "edit" && $_GET['id']){
	$form_submit_button = 'updatePage';
	$sql = 'SELECT * FROM pages WHERE id = "' . sanitize($_GET['id'], INT). '" ORDER BY title ASC';
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
$main_page = 'page';
$sub_page  = 'page.add';
?>
<?php include('../inc.topnav.php'); ?>
<?php include('../inc.sidenav.php'); ?>
<div class="content">
	 <div class="container-fluid">
	 	<form method="post" action="page.php" enctype="multipart/form-data">
		<div id="pad-wrapper" class="form-page">
			<div class="row-fluid form-wrapper">
				<div class="span8 column">
					<?php
					if($feedback_success){ echo $feedback_success; }
					if($feedback_error){ echo $feedback_error; }
					?>
					<input type="hidden" name="p_id" value="<?php echo $row_editor['id']; ?>" />
					<div class="field-box"><label>Title:</label><input name="title" class="span8" type="text" value="<?php echo stripcslashes($row_editor['title']); ?>" /></div>
					<div class="field-box">
						<label>Subtitle:</label>
						<input name="subtitle" class="span8" type="text" value="<?php echo stripcslashes($row_editor['subtitle']); ?>" />
					</div>
					<div class="field-box">
						<label>Body:</label>
 
						<div class="wysi-column"><textarea id="wysi" name="body" class="span12 wysihtml5" rows="14"><?php echo stripcslashes($row_editor['body']); ?></textarea></div>
					</div>
					<div class="field-box"><label>Sub Menu:</label><input name="submenu" class="span8" type="text" value="<?php echo stripcslashes($row_editor['submenu']); ?>" /></div>
					
					<h4 style="margin-bottom: 15px; margin-left: 0px; border-bottom: 1px solid #EEE; padding-bottom: 15px; color: #696d73;">SEO Settings</h4>
					
					<div class="field-box"><label>Title:</label><input name="seo_title" class="span8" type="text" value="<?php echo stripcslashes($row_editor['seo_title']); ?>" /></div>
					<div class="field-box"><label>Keywords:</label><input name="seo_keywords" class="span8" type="text" value="<?php echo stripcslashes($row_editor['seo_keywords']); ?>" /></div>
					<div class="field-box"><label>Description:</label><input name="seo_description" class="span8" type="text" value="<?php echo stripcslashes($row_editor['seo_description']); ?>" /></div>
					
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
					
					<div class="field-box"><label>Image:</label><input class="span8" name="page_image" type="file" /></div>
					
					<?php
					if($_GET['action'] == "edit" && $row_editor['id']){
						$directory = "../../core/images/pages/" . $row_editor['alias'] . '.jpg';
						if (file_exists($directory)) { 
							echo '<div class="field-box"><label>Existing Image:</label><img width="300" src="'. $directory .'"></div>';
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