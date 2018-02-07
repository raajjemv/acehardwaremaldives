<?php session_start();  ?>
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

if($_POST['addProducts']){
	// Check required fields
	include_once("../mod.resize.class.php");
	if($_POST['product_id'] && $_POST['product_name'] && $_POST['product_description'] && $_POST['parent_category'] && $_POST['sub_category_1'] && $_POST['sub_category_2'] && $_POST['product_status']){		
		// list all fields
		$product_id 			= GetSQLValueString($_POST['product_id'], "double");
		$product_name 			= GetSQLValueString($_POST['product_name'], "text");
		$product_description 	= GetSQLValueString($_POST['product_description'], "text");	
		$parent_category 		= GetSQLValueString($_POST['parent_category'], "text");	
		$sub_category_1 		= GetSQLValueString($_POST['sub_category_1'], "text");	
		$sub_category_2 		= GetSQLValueString($_POST['sub_category_2'], "text");
		$product_status 		= GetSQLValueString($_POST['product_status'], "int");
		$product_price 			= GetSQLValueString($_POST['product_price'], "text");
		$product_brand 			= GetSQLValueString($_POST['brand'], "text");
		$product_brand_alias 	= GetSQLValueString(generate_seo_link($_POST['brand'], '-', true, ''), "text");
		//
		$insert_qry = "INSERT INTO products (product_id, name, description, price, status, parent_category, child_category_1, child_category_2, brand) 
								VALUES ($product_id, $product_name, $product_description, $product_price, $product_status, $parent_category, $sub_category_1, $sub_category_2, $product_brand_alias)";				
		//checkIfBrandExists
		if($_POST['brand']){
			$checkbrand = checkIfBrandExists($_POST['brand']);
			if(!$checkbrand){
				$insert_brand = "INSERT INTO brand (name, alias) VALUES ($product_brand, $product_brand_alias);";
				mysql_query($insert_brand);
			}
		}
		//						
		// Lets upload the product image now
		$upload_errors = "";
		$directory = "../../core/images/products/" . $product_id;
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
			
			if(($_FILES['product_image']['size'] >= $maxsize) || ($_FILES["product_image"]["size"] == 0)) {
				$upload_errors .= 'Product image file size must be less than 400 Kb. ';
			}
			if(!in_array($_FILES['product_image']['type'], $acceptable) && !empty($_FILES["product_image"]["type"])) {
				$upload_errors .= 'Invalid file type. Please use jpg or png image.';
			}
			if(!$upload_errors){
				$target  = 	$directory . "/" . "large.jpg";
				$target2 = 	$directory . "/" . "thumb.jpg";
				// upload the large file
				move_uploaded_file($_FILES['product_image']['tmp_name'],$target);
				// lets resize the image now
				$resizeObj = new resize($target);
				$resizeObj -> resizeImage(200, 200, 'exact');
				$resizeObj -> saveImage($target2, 100);
				//
				chmod($directory ,0755);
			}
		}
		if(!$upload_errors){
			if(mysql_query($insert_qry)){
				$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Store updated with new product.</div>';
				activityMonitor($global_user_id, $_POST['product_name'], "add", "store-products");
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

if($_POST['updateProducts']){
	include_once("../mod.resize.class.php");
	if($_POST['product_id'] && $_POST['product_name'] && $_POST['product_description'] && $_POST['parent_category'] && $_POST['sub_category_1'] && $_POST['sub_category_2'] && $_POST['product_status']){
		$p_id		 			= GetSQLValueString($_POST['p_id'], "int");
		$product_id 			= GetSQLValueString($_POST['product_id'], "double");
		$product_name 			= GetSQLValueString($_POST['product_name'], "text");
		$product_description 	= GetSQLValueString($_POST['product_description'], "text");	
		$parent_category 		= GetSQLValueString($_POST['parent_category'], "text");	
		$sub_category_1 		= GetSQLValueString($_POST['sub_category_1'], "text");	
		$sub_category_2 		= GetSQLValueString($_POST['sub_category_2'], "text");
		$product_status 		= GetSQLValueString($_POST['product_status'], "int");
		$product_price 			= GetSQLValueString($_POST['product_price'], "text");
		$product_brand 			= GetSQLValueString($_POST['brand'], "text");
		$product_brand_alias 	= GetSQLValueString(generate_seo_link($_POST['brand'], '-', true, ''), "text");
		
		$qry = "UPDATE products SET product_id 			= $product_id,
									name 				= $product_name,
									description 		= $product_description,
									price 				= $product_price,
									status 				= $product_status,
									parent_category 	= $parent_category,
									child_category_1	= $sub_category_1,
									child_category_2	= $sub_category_2,
									brand				= $product_brand_alias
									WHERE id 			= $p_id";
		//checkIfBrandExists
		if($_POST['brand']){
			$checkbrand = checkIfBrandExists($_POST['brand']);
			if(!$checkbrand){
				$insert_brand = "INSERT INTO brand (name, alias) VALUES ($product_brand, $product_brand_alias);";
				mysql_query($insert_brand);
			}
		}
		//						
		// Lets upload the product image now
		$upload_errors = "";
		$directory = "../../core/images/products/" . $product_id;
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
			
			if(($_FILES['product_image']['size'] >= $maxsize) || ($_FILES["product_image"]["size"] == 0)) {
				$upload_errors .= 'Product image file size must be less than 400 Kb. ';
			}
			if(!in_array($_FILES['product_image']['type'], $acceptable) && !empty($_FILES["product_image"]["type"])) {
				$upload_errors .= 'Invalid file type. Please use jpg or png image.';
			}
			if(!$upload_errors){
				$target  = 	$directory . "/" . "large.jpg";
				$target2 = 	$directory . "/" . "thumb.jpg";
				// upload the large file
				move_uploaded_file($_FILES['product_image']['tmp_name'],$target);
				// lets resize the image now
				$resizeObj = new resize($target);
				$resizeObj -> resizeImage(200, 200, 'exact');
				$resizeObj -> saveImage($target2, 100);
				//
				chmod($directory ,0755);
			}
		}
		if(!$upload_errors){
			if(mysql_query($qry)){
				$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Store updated with new product.</div>';
				activityMonitor($global_user_id, $_POST['product_name'], "update", "store-products");
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
$form_submit_button = 'addProducts';
if($_GET['action'] == "edit" && $_GET['id']){
	$form_submit_button = 'updateProducts';
	$sql = 'SELECT * FROM products WHERE id = "' . sanitize($_GET['id'], INT). '" ORDER BY name ASC';
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
$sub_page  = 'products.add';
?>
<?php include('../inc.topnav.php'); ?>
<?php include('../inc.sidenav.php'); ?>
<div class="content">
	 <div class="container-fluid">
	 	<form method="post" action="products.php" enctype="multipart/form-data">
		<div id="pad-wrapper" class="form-page">
			<div class="row-fluid form-wrapper">
				<div class="span8 column">
					<?php
					if($feedback_success){ echo $feedback_success; }
					if($feedback_error){ echo $feedback_error; }
					?>
					<input type="hidden" name="p_id" value="<?php echo $row_editor['id']; ?>" />
					<div class="field-box"><label>Product ID:</label><input name="product_id" class="span8" type="text" value="<?php echo $row_editor['product_id']; ?>" /></div>
					<div class="field-box"><label>Product Name:</label><input name="product_name" class="span8" type="text" value="<?php echo trim(stripcslashes($row_editor['name'])); ?>" /></div>
					<div class="field-box">
						<label>Brand:</label>
						<input name="brand" class="span8" type="text" value="<?php echo stripcslashes($row_editor['brand']); ?>" />
					</div>
					<div class="field-box">
						<label>Product Description:</label>
						<div class="wysi-column"><textarea id="wysi" name="product_description" class="span12 wysihtml5" rows="14"><?php echo stripcslashes($row_editor['description']); ?></textarea></div>
					</div>
					<div class="field-box"><label>Image:</label><input class="span8" name="product_image" type="file" /></div>
					
					<div class="field-box"><label></label><input type="submit" class="btn-flat primary" name="<?php echo $form_submit_button; ?>" value="Save Changes" /></div>
				</div>
				
				
				<div class="span4 column form-sidebar  pull-right">
					<div class="field-box">
						<label>Parent Category:</label>
						<div class="ui-select">
						<select id="parent_category" name="parent_category">
							<option value="00">Select Category</option>
							<?php
							$sql = 'SELECT * FROM category WHERE parent_a = "000" ORDER BY order_no ASC';
							if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
							while($row = mysql_fetch_assoc($result)) {
							?><option value="<?php echo $row['id']; ?>" <?php echo ($row_editor['parent_category'] == $row['id'] ? "selected" : ""); ?>><?php echo $row['name']; ?></option><?php } ?>
						</select>
						</div>
					</div>
					<div class="field-box">
						<label>Sub Category 1:</label>
						<div class="ui-select">
							<select id="sub_category_1" name="sub_category_1">
								<?php
								if($_GET['action'] == "edit" && $row_editor['child_category_1']){
									$sql = 'SELECT * FROM category WHERE parent_a = "' . $row_editor['parent_category'] . '" OR parent_b = "' . $row_editor['parent_category'] . '" OR parent_c = "' . $row_editor['parent_category'] . '"  ORDER BY order_no ASC';
									if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
									while($row = mysql_fetch_assoc($result)) {
									?>
									<option value="<?php echo $row['id']; ?>" <?php echo ($row_editor['child_category_1'] == $row['id'] ? "selected" : ""); ?>><?php echo $row['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="field-box">
						<label>Sub Category 2:</label>
						<div class="ui-select">
							<select id="sub_category_2" name="sub_category_2">
								<?php
								if($_GET['action'] == "edit" && $row_editor['child_category_2']){
									$sql = 'SELECT * FROM category WHERE parent_a = "' . $row_editor['child_category_1'] . '" OR parent_b = "' . $row_editor['child_category_1'] . '" OR parent_c = "' . $row_editor['child_category_1'] . '"  ORDER BY order_no ASC';
									if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
									while($row = mysql_fetch_assoc($result)) {
									?>
									<option value="<?php echo $row['id']; ?>" <?php echo ($row_editor['child_category_2'] == $row['id'] ? "selected" : ""); ?>><?php echo $row['name']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					
					<div class="field-box">
						<label>Status:</label>
						<div class="ui-select">
							<select name="product_status">
								<option value="1" <?php echo ($row_editor['status'] == 1 ? "selected" : ""); ?>>Publish</option>
								<option value="2" <?php echo ($row_editor['status'] == 2 ? "selected" : ""); ?>>Pending</option>
								<option value="3" <?php echo ($row_editor['status'] == 3 ? "selected" : ""); ?>>Hidden</option>
							</select>
						</div>
					</div>
					
					<?php
					if($_GET['action'] == "edit" && $row_editor['product_id']){
						$directory = "../../core/images/products/" . $row_editor['product_id'] . '/thumb.jpg';
						if (file_exists($directory)) { 
							echo '<div class="field-box"><label>Existing Image:</label><img src="'. $directory .'"></div>';
						}
					}
					?>
					<p style="border-bottom: 1px solid #EEE; width: 250px;">&nbsp;</p>
					<div class="field-box"><label>Optional Field</label></div>
					<div class="field-box"><label>Price:</label><input class="span8" name="product_price" type="text" value="<?php echo $row_editor['price']; ?>" /></div>
					
				</div><!-- /span4 column -->
				
			</div><!-- /form-wrapper -->
		</div><!-- /form-page -->
		</form>
	 </div><!-- /container-fluid -->
</div><!-- /content -->
<?php include('../inc.footer.php'); ?>
<script type="text/javascript">
$(function () {
	<?php if($_GET['action'] != "edit" && !$row_editor['child_category_1']){ ?>$("#sub_category_1").attr("disabled", true);<?php } ?>
	<?php if($_GET['action'] != "edit" && !$row_editor['child_category_2']){ ?> $("#sub_category_2").attr("disabled", true);<?php } ?>
    // wysihtml5 plugin on textarea
    $(".wysihtml5").wysihtml5({
        "font-styles": false
    });
    
    $( "#parent_category" ).change(function() {
    	get_parent_id = $(this).val();
    	data = '&parent_id=' + get_parent_id;
    	if(get_parent_id != "00"){
    		$(".loading-indicator").show();
    		$("#sub_category_2").attr("disabled", true);
    		$("#sub_category_2").html("");	
    		
        	$.get('<?php echo $wwwroot; ?>/ajax.php?action=getSubCategory' + data , function(data) {
        		$(".loading-indicator").hide();
        		var json = $.parseJSON(data);
        		options = '<option value="00">None</option>';
        		for (var i = 0; i < json.length; i++) {
        			options += '<option value="' + json[i].id +'">' + json[i].name + '</option>';
        		}
        		console.log(options);
        		$("#sub_category_1").attr("disabled", false);
        		$("#sub_category_1").html(options);	
        	});
    	}else{
    		$("#sub_category_1").attr("disabled", true);
    		$("#sub_category_1").html("");
    		$("#sub_category_2").attr("disabled", true);	
    		$("#sub_category_2").html("");
    	}
    });
    
    $( "#sub_category_1" ).change(function() {
    	get_parent_id = $(this).val();
    	data = '&parent_id=' + get_parent_id;
    	if(get_parent_id != "00"){
    		$(".loading-indicator").show();
    		$("#sub_category_2").attr("disabled", true);
    		$("#sub_category_2").html("");	
    		
        	$.get('<?php echo $wwwroot; ?>/ajax.php?action=getSubCategory' + data , function(data) {
        		$(".loading-indicator").hide();
        		var json = $.parseJSON(data);
        		options = '<option value="00">None</option>';
        		for (var i = 0; i < json.length; i++) {
        			options += '<option value="' + json[i].id +'">' + json[i].name + '</option>';
        		}
        		console.log(options);
        		$("#sub_category_2").attr("disabled", false);
        		$("#sub_category_2").html(options);	
        	});
    	}else{
    		$("#sub_category_2").attr("disabled", true);
    		$("#sub_category_2").html("");	
    	}
    });
});
</script>
</body>
</html>