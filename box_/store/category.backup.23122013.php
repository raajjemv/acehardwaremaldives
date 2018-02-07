<?php include_once('../inc.config.php'); ?>
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

if($_POST['addCategory']){
	// Check required fields
	if($_POST['category_name'] && $_POST['category_status']){		
		// list all fields
		$category_name 			= GetSQLValueString($_POST['category_name'], "text");
		$create_alias			= generate_seo_link($category_name, '-', true, '');
		$category_alias			= GetSQLValueString($create_alias, "text");
		$category_description 	= GetSQLValueString($_POST['category_description'], "text");	
		$category_status 		= GetSQLValueString($_POST['category_status'], "int");	
		$parent_category 		= GetSQLValueString($_POST['parent_category'], "int");
		$sub_category	 		= GetSQLValueString($_POST['sub_category'], "int");
//		if($parent_category == "00"){
//			$parent = "00";
//		}elseif($sub_category == "00"){
//			$parent = $parent_category;
//		}elseif($parent_category != "00"){
//			$parent = $sub_category;
//		}
		//
		$insert_qry = "INSERT INTO category (name, alias, description, status, parent) 
								VALUES ($category_name, $category_alias, $category_description, $category_status, $parent_category)";				
		if(mysql_query($insert_qry)){
			$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Store updated with new category.</div>';
		}else{
			$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . '</div>' ;
		}
	}else{
		$feedback_error = '<div class="alert"><i class="icon-warning-sign"></i>Please fill all the fields in the form.</div>';
	}
}

if($_POST['updateCategory']){
	// Check required fields
	if($_POST['category_name'] && $_POST['category_status']){		
		// list all fields
		$category_id 			= GetSQLValueString($_POST['category_id'], "int");
		$category_name 			= GetSQLValueString($_POST['category_name'], "text");
		$create_alias			= GetSQLValueString(generate_seo_link($category_name, '-', true, ''), "text");
		$category_alias			= GetSQLValueString($create_alias, "text");
		$category_description 	= GetSQLValueString($_POST['category_description'], "text");	
		$category_status 		= GetSQLValueString($_POST['category_status'], "int");	
		$parent_category 		= GetSQLValueString($_POST['parent_category'], "int");
		$sub_category	 		= GetSQLValueString($_POST['sub_category'], "int");
		//
		//$insert_qry = "INSERT INTO category (name, alias, description, status, parent) 
		//						VALUES ($category_name, $category_alias, $category_description, $category_status, $parent)";
		$qry = "UPDATE category SET name 		= $category_name,
									alias 		= $create_alias,
									description = $category_description,
									status 		= $category_status,
									parent 		= $parent_category
									WHERE id 	= $category_id"; 
		//echo $qry;	
																		
		if(mysql_query($qry)){
			$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Store updated.</div>';
		}else{
			$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . '</div>' ;
		}
		$_GET['action'] = "edit";
		$_GET['id'] 	= $category_id;
	}else{
		$feedback_error = '<div class="alert"><i class="icon-warning-sign"></i>Please fill all the fields in the form.</div>';
	}
}
?>

<?php
$form_submit_button = 'addCategory';
if($_GET['action'] == "edit" && $_GET['id']){
	$form_submit_button = 'updateCategory';
	$sql = 'SELECT * FROM category WHERE id = "' . sanitize($_GET['id'], INT). '" ORDER BY name ASC';
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
$sub_page  = 'category.add';
?>
<?php include('../inc.topnav.php'); ?>
<?php include('../inc.sidenav.php'); ?>
<div class="content">
	 <div class="container-fluid">
	 	<form method="post" action="category.php" enctype="multipart/form-data">
		<div id="pad-wrapper" class="form-page">
			<div class="row-fluid form-wrapper">
				<div class="span8 column">
					<?php
					if($feedback_success){ echo $feedback_success; }
					if($feedback_error){ echo $feedback_error; }
					?>
					<input type="hidden" name="category_id" value="<?php echo $row_editor['id']; ?>" />
					<div class="field-box"><label>Category Name:</label><input name="category_name" class="span8" type="text" value="<?php echo $row_editor['name']; ?>" /></div>
					<div class="field-box">
						<label>Category Description:</label>
						<div class="wysi-column"><textarea id="wysi" name="category_description" class="span12 wysihtml5" rows="14"><?php echo $row_editor['description']; ?></textarea></div>
					</div>
					
					<div class="field-box"><label></label><input type="submit" class="btn-flat primary" name="<?php echo $form_submit_button; ?>" value="Save Changes" /></div>
				</div>
				
				<div class="span4 column form-sidebar  pull-right">
					<?php if($_GET['action'] == "edit"){ ?>
					<div class="field-box">
						<label>Parent Category:</label>
						<div class="ui-select">
							<select id="parent_category" name="parent_category" >
								<option value="00" <?php echo ($row_editor['parent'] == "000") ? 'selected="selected"' : ''; ?>>Main Category</option>
								<?php
								$sql = 'SELECT * FROM category WHERE parent = "000" ORDER BY order_no ASC';
								if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
								while($row = mysql_fetch_assoc($result)) {
								?>
								<option value="<?php echo $row['id']; ?>" <?php echo ($row_editor['parent'] == $row['id']) ? 'selected="selected"' : ''; ?>><?php echo $row['name']; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="field-box">
						<label>Sub Category:</label>
						<div class="ui-select"><select id="sub_category" name="sub_category"></select></div>
					</div>
					<?php }else{ ?>
					<div class="field-box">
						<label>Parent Category:</label>
						<div class="ui-select">
							<select id="parent_category" name="parent_category" class="select2" style="width:250px" >
								<option value="000" <?php echo ($row_editor['parent'] == "000") ? 'selected="selected"' : ''; ?>>Main Category</option>
								<?php
								$sql = 'SELECT * FROM category WHERE parent = "000" ORDER BY order_no ASC';
								if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
								while($row = mysql_fetch_assoc($result)) {
								?>
								<option value="<?php echo $row['id']; ?>" <?php echo ($row_editor['parent'] == $row['id']) ? 'selected="selected"' : ''; ?>>&raquo; <?php echo $row['name']; ?></option>
									<?php
									$sql2 = 'SELECT * FROM category WHERE parent = "' . $row['id'] . '" ORDER BY name ASC';
									if (!($result2 = mysql_query ($sql2))){exit ('<b>Error:</b>' . mysql_error ());}
									while($row2 = mysql_fetch_assoc($result2)) {
									?>
									<option value="<?php echo $row2['id']; ?>" <?php echo ($row_editor['parent'] == $row2['id']) ? 'selected="selected"' : ''; ?>>&nbsp;&nbsp;&nbsp; &bull; <?php echo $row2['name']; ?></option>
										<?php
										$sql3 = 'SELECT * FROM category WHERE parent = "' . $row2['id'] . '" ORDER BY name ASC';
										if (!($result3 = mysql_query ($sql3))){exit ('<b>Error:</b>' . mysql_error ());}
										while($row3 = mysql_fetch_assoc($result3)) {
										?>
										<option value="<?php echo $row3['id']; ?>" <?php echo ($row_editor['parent'] == $row3['id']) ? 'selected="selected"' : ''; ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <?php echo $row3['name']; ?></option>
										<?php } ?>
									<?php } ?>
								<?php } ?>
							</select>
						</div>
					</div>
					<?php } ?>
					<div class="field-box">
						<label>Status:</label>
						<div class="ui-select"><select name="category_status"><option selected="" value="1"/>Publish<option value="2" />Pending<option value="3" />Hidden</select></div>
					</div>
				</div><!-- /span4 column -->
				
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
    
    $(".select2").select2({
                   placeholder: "Select a State"
               });
    
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