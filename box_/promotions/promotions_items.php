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
if($_POST['addPromotionItems']){		
	$promotion_id = sanitize($_REQUEST['promotion_id'], INT);
	$promotion_type = sanitize($_REQUEST['promotion_type'], INT);
	$promotion_name = sanitize($_REQUEST['promotion_name'], SQL);
	$promotion_items = $_REQUEST['promotion_items'];
	$insert = '';
	if($promotion_items){
		$sql = 'INSERT INTO promotion_items ( promotion_id, product_id, type ) VALUES ';
		//print_r($promotion_items);
		for ($i = 0; $i < count($promotion_items); $i++) {
			if(checkIfProductExists($promotion_items[$i])){
				$product_id = $promotion_items[$i];
				$insert .= " ($promotion_id, $product_id, $promotion_type)";
				if($i != count($promotion_items)-1){
					$insert .= ", ";
				}
			}
		}
		
		
		if(mysql_query($sql . $insert)){
			$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Promotion Updated</div>';
			activityMonitor($global_user_id, $promotion_name, "update", "promotions-items");
		}else{
			$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . '</div>' ;
		}
	}
	//echo($sql . $insert);
	$_REQUEST['id'] = $promotion_id;
}
?>

<?php
$sql = 'SELECT * FROM promotions WHERE id = "' . sanitize($_REQUEST['id'], INT). '" ORDER BY title ASC';
if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
$row_promotion_info = mysql_fetch_assoc($result);
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
$sub_page  = 'promotions.add.items';
?>
<?php
if($_GET['action'] == "delete"){
	$delete_button_link = "promotions_items.php?action=delete_confirm&id=" . $_GET['id'] . "&delete_id=" . $_GET['delete_id'] . "&name=" . $_GET['name'];
	$delete_confirm = '<div class="alert"><i class="icon-warning-sign pull-left"></i><a href="index.php" class="btn-flat white pull-right" style="margin-right: -20px; margin-top: 5px">Cancel</a> <a href="' . $delete_button_link . '" class="btn-flat white pull-right" style="margin-right: 10px; margin-top: 5px">Delete</a>  Are you sure you want to permanently delete the product: <strong>' . $_GET['name'] .'</strong> . <br> You cant undo this action. </div>';
}

if ($_GET['action'] == "delete_confirm"){
	$get_id 			= sanitize($_GET['delete_id'], INT);
	$get_promotion_id 	= sanitize($_GET['id'], INT);
	
	$sql = "DELETE FROM promotion_items WHERE promotion_id = $get_promotion_id AND product_id = $get_id";
	if(mysql_query($sql)){
		$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Product <strong>' . $_GET['name'] . '</strong> deleted from the promotion.</div>';
		activityMonitor($global_user_id, $_POST['title'], "update", "promotions");
	}else{
		$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. </div>' ;
	}
}
?>
<?php include('../inc.topnav.php'); ?>
<?php include('../inc.sidenav.php'); ?>
<div class="content">
	<div class="container-fluid">
		<div id="pad-wrapper" class="form-page">
		
			<div class="table-wrapper products-table " style="margin-bottom: 0;">
				<div class="row-fluid head">
				    <div class="span12">
				        <h4>Promotion / <?php echo $row_promotion_info['title']; ?> / Add Items</h4>
				    </div>
				</div><!-- /row-fluid head -->
			</div><!-- /table-wrapper products-table -->
			
			<div class="row-fluid form-wrapper" style="margin-left: 20px; margin-top: 20px;">
				<div class="span4 column">
					<div class="field-box"><label>Search Product:</label><input name="product_search" id="product_search" class="span8" type="text" value="" placeholder="by name or SKU" /></div>
				</div>
				
				<div class="span8 column">
					<?php
					if($delete_confirm){ echo $delete_confirm; }
					if($feedback_success){ echo $feedback_success; }
					if($feedback_error){ echo $feedback_error; }
					?>
					<div class="field-box"><label>Items to Add:</label></div>
					<form method="post" action="promotions_items.php">
						<input type="hidden" name="promotion_id" value="<?php echo $row_promotion_info['id']; ?>" />
						<input type="hidden" name="promotion_type" value="<?php echo $row_promotion_info['type']; ?>" />
						<input type="hidden" name="promotion_name" value="<?php echo $row_promotion_info['title']; ?>" />
						<div id="selected_products" class="selected_products">
							<?php
							$sql_product_items = 'SELECT * FROM promotion_items WHERE promotion_id = ' .  sanitize($_REQUEST['id'], INT) . ' ORDER BY product_id ASC';
							if (!($result_product_items = mysql_query ($sql_product_items))){exit ('<b>Error:</b>' . mysql_error ());}
							?>
							<?php while($row = mysql_fetch_assoc($result_product_items)) { ?>
							<label class="checkbox" id="<?php echo $row['product_id']; ?>">
								<a href="promotions_items.php?id=<?php echo $_GET['id']; ?>&delete_id=<?php echo $row['product_id']; ?>&action=delete&name=<?php echo getProductDetails($row['product_id'], "name"); ?>" class="icon-remove pull-right"></a>
								<?php echo getProductDetails($row['product_id'], "name"); ?> (<?php echo $row['product_id']; ?>)
							</label>
							<?php } ?>
						</div>
						<div class="field-box"><input type="submit" class="btn-flat primary" name="addPromotionItems" value="Save Changes" /></div>
					</form>
				</div>
			</div><!-- /row-fluid form-wrapper -->
			
		</div><!-- /pad-wrapper -->
	</div><!-- /container-fluid -->
</div><!-- /content -->
<?php include('../inc.footer.php'); ?>
</body>
</html>