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

if($_POST['addBrands']){
	// Check required fields
	include_once("../mod.resize.class.php");
	if($_POST['name']){		
		// list all fields
		$brand 			= GetSQLValueString($_POST['name'], "text");
		$brand_alias 	= GetSQLValueString(generate_seo_link($brand, '-', true, ''), "text");
		$brand_image 	= generate_seo_link($brand, '-', true, '');
		$status 		= GetSQLValueString($_POST['status'], "int");
		//		
		$insert_qry = "INSERT INTO brand (name, alias, status) 
								VALUES ($brand, $brand_alias, $status)";				
		// Lets upload the product image now
		$upload_errors = "";
		$directory = "../../core/images/brands/";
		if (!file_exists($directory)) { 
			// create directory if its not there
			mkdir($directory); 
		}
		// Now uploading begings						
		if($_FILES['product_image']['name']) {
			chmod($directory ,0777);
			$maxsize    = 409600;
			$acceptable = array('image/jpeg', 'image/jpg', 'image/png');
			$filetmpname = $_FILES["product_image"]["tmp_name"];
			
//			if(($_FILES['product_image']['size'] >= $maxsize) || ($_FILES["product_image"]["size"] == 0)) {
//				$upload_errors .= 'Brand image file size must be less than 400 Kb. ';
//			}
			if(!in_array($_FILES['product_image']['type'], $acceptable) && !empty($_FILES["product_image"]["type"])) {
				$upload_errors .= 'Invalid file type. Please use png image.';
			}
			if(!$upload_errors){
				$target  = 	$directory . "/" . $brand_image . ".png";
				// upload the large file
				move_uploaded_file($_FILES['product_image']['tmp_name'],$target);
				chmod($directory ,0755);
			}
		}
		if(!$upload_errors){
			if(mysql_query($insert_qry)){
				$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Store updated with new brand.</div>';
				activityMonitor($global_user_id, $_POST['name'], "add", "store-brands");
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

if($_POST['updateBrands']){
	include_once("../mod.resize.class.php");
	if($_POST['name']){
		$p_id		 	= GetSQLValueString($_POST['p_id'], "int");
		$brand 			= GetSQLValueString($_POST['name'], "text");
		$brand_alias 	= GetSQLValueString(generate_seo_link($brand, '-', true, ''), "text");
		$brand_image 	= generate_seo_link($brand, '-', true, '');
		$status 		= GetSQLValueString($_POST['status'], "int");
		
		$qry = "UPDATE brand SET 	name 			= $brand,
									alias 			= $brand_alias,
									status			= $status
									WHERE id 		= $p_id";					
		// Lets upload the product image now
		$upload_errors = "";
		$directory = "../../core/images/brands/";
		if (!file_exists($directory)) { 
			// create directory if its not there
			mkdir($directory); 
		}
		// Now uploading begings						
		if($_FILES['product_image']['name']) {
			chmod($directory ,0777);
			$maxsize    = 409600;
			$acceptable = array('image/jpeg', 'image/jpg', 'image/png');
			$filetmpname = $_FILES["product_image"]["tmp_name"];
			
//			if(($_FILES['product_image']['size'] >= $maxsize) || ($_FILES["product_image"]["size"] == 0)) {
//				$upload_errors .= 'Brand image file size must be less than 400 Kb. ';
//			}
			if(!in_array($_FILES['product_image']['type'], $acceptable) && !empty($_FILES["product_image"]["type"])) {
				$upload_errors .= 'Invalid file type. Please use png image.';
			}
			if(!$upload_errors){
				$target  = 	$directory . "/" . $brand_image . ".png";
				// upload the large file
				move_uploaded_file($_FILES['product_image']['tmp_name'],$target);
				chmod($directory ,0755);
			}
		}
		if(!$upload_errors){
			if(mysql_query($qry)){
				$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Brand updated.</div>';
				activityMonitor($global_user_id, $_POST['name'], "update", "store-brands");
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
$form_submit_button = 'addBrands';
if($_GET['action'] == "edit" && $_GET['id']){
	$form_submit_button = 'updateBrands';
	$sql = 'SELECT * FROM brand WHERE id = "' . sanitize($_GET['id'], INT). '" ORDER BY name ASC';
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
$main_page = 'store';
$sub_page  = 'brands.add';
?>
<?php include('../inc.topnav.php'); ?>
<?php include('../inc.sidenav.php'); ?>
<div class="content">
	 <div class="container-fluid">
	 	<form method="post" action="brands.php" enctype="multipart/form-data">
		<div id="pad-wrapper" class="form-page">
			<div class="row-fluid form-wrapper">
				<div class="span8 column">
					<?php
					if($feedback_success){ echo $feedback_success; }
					if($feedback_error){ echo $feedback_error; }
					?>
					<input type="hidden" name="p_id" value="<?php echo $row_editor['id']; ?>" />
					<div class="field-box"><label>Brand Name:</label><input name="name" class="span8" type="text" value="<?php echo htmlentities(stripcslashes($row_editor['name'])); ?>" /></div>
					<div class="field-box"><label>Image:</label><input class="span8" name="product_image" type="file" /></div>
					
					<div class="field-box"><label></label><input type="submit" class="btn-flat primary" name="<?php echo $form_submit_button; ?>" value="Save Changes" /></div>
				</div>
				
				
				<div class="span4 column form-sidebar  pull-right">
					<div class="field-box">
						<label>Status:</label>
						<div class="ui-select">
							<select name="status">
								<option value="1" <?php echo ($row_editor['status'] == 1 ? "selected" : ""); ?>>Publish</option>
								<option value="2" <?php echo ($row_editor['status'] == 2 ? "selected" : ""); ?>>Pending</option>
								<option value="3" <?php echo ($row_editor['status'] == 3 ? "selected" : ""); ?>>Hidden</option>
							</select>
						</div>
					</div>
					
					<?php
					if($_GET['action'] == "edit" && $row_editor['alias']){
						$directory = "../../core/images/brands/" . $row_editor['alias'] . '.png';
						if (file_exists($directory)) { 
							echo '<div class="field-box"><label>Existing Image:</label><img src="'. $directory .'"></div>';
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
</body>
</html>