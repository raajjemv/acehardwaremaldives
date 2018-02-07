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

if($_POST['addPromotion']){
	// Check required fields : title start_date end_date type status
	if($_POST['title'] && $_POST['start_date'] && $_POST['end_date'] && $_POST['type'] && $_POST['status']){		
		// list all fields
		$title 			= GetSQLValueString($_POST['title'], "text");
		$description	= GetSQLValueString($_POST['description'], "text");
		$start_date 	= GetSQLValueString($_POST['start_date'], "text");
		$end_date		= GetSQLValueString($_POST['end_date'], "text");
		$type   		= GetSQLValueString($_POST['type'], "int");	
		$status   		= GetSQLValueString($_POST['status'], "int");		

		$insert_qry = "INSERT INTO promotions (title, description, type, start_date, end_date, status) 
								   VALUES     ($title, $description, $type, $start_date, $end_date, $status)";				
		if(mysql_query($insert_qry)){
			$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>New promotion added into system.</div>';
			activityMonitor($global_user_id, $_POST['title'], "add", "promotions");
		}else{
			$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . '</div>' ;
		}
	}else{
		$feedback_error = '<div class="alert"><i class="icon-warning-sign"></i>Please fill all the fields in the form.</div>';
	}
}

if($_POST['updatePromotion']){
	// Check required fields
	if($_POST['title'] && $_POST['start_date'] && $_POST['end_date'] && $_POST['type'] && $_POST['status']){		
		// list all fields
		$promotion_id 	= GetSQLValueString($_POST['p_id'], "int");
		$title 			= GetSQLValueString($_POST['title'], "text");
		$description 	= GetSQLValueString($_POST['description'], "text");
		$start_date 	= GetSQLValueString($_POST['start_date'], "text");
		$end_date		= GetSQLValueString($_POST['end_date'], "text");
		$type   		= GetSQLValueString($_POST['type'], "int");	
		$status   		= GetSQLValueString($_POST['status'], "int");
	
		$qry = "UPDATE promotions SET 	title 		= $title,
										description = $description,
								 		type 		= $type,
								 		start_date 	= $start_date,
								 		end_date 	= $end_date,
								 		status 		= $status
										WHERE id 	= $promotion_id"; 													
		if(mysql_query($qry)){
			$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Promotion updated.</div>';
			activityMonitor($global_user_id, $_POST['title'], "update", "promotions");
		}else{
			$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . '</div>' ;
		}
		$_GET['action'] = "edit";
		$_GET['id'] 	= $promotion_id;
	}else{
		$feedback_error = '<div class="alert"><i class="icon-warning-sign"></i>Please fill all the fields in the form.</div>';
	}
}
?>

<?php
$form_submit_button = 'addPromotion';
if($_GET['action'] == "edit" && $_GET['id']){
	$form_submit_button = 'updatePromotion';
	$sql = 'SELECT * FROM promotions WHERE id = "' . sanitize($_GET['id'], INT). '" ORDER BY title ASC';
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
$sub_page  = 'promotions.add';
?>
<?php include('../inc.topnav.php'); ?>
<?php include('../inc.sidenav.php'); ?>
<div class="content">
	 <div class="container-fluid">
	 	<form method="post" action="promotion.php" enctype="multipart/form-data">
		<div id="pad-wrapper" class="form-page">
			<div class="row-fluid form-wrapper">
				<div class="span8 column">
					<?php
					if($feedback_success){ echo $feedback_success; }
					if($feedback_error){ echo $feedback_error; }
					?>
					<input type="hidden" name="p_id" value="<?php echo $row_editor['id']; ?>" />
					<div class="field-box"><label>Title:</label><input name="title" class="span8" type="text" value="<?php echo stripcslashes($row_editor['title']); ?>" /></div>
					<div class="field-box"><label>Description:</label><input name="description" class="span8" type="text" value="<?php echo stripcslashes($row_editor['description']); ?>" /></div>
					<div class="field-box">
						<label>Start Date:</label>
						<input name="start_date" class="span3 start_date" type="text" value="<?php echo stripcslashes($row_editor['start_date']); ?>" data-date-format="yyyy-mm-dd"/>
					</div>
					<div class="field-box">
						<label>End Date:</label>
						<input name="end_date" class="span3 end_date" type="text" value="<?php echo stripcslashes($row_editor['end_date']); ?>" data-date-format="yyyy-mm-dd"/>
					</div>
					
					<div class="field-box"><label></label><input type="submit" class="btn-flat primary" name="<?php echo $form_submit_button; ?>" value="Save Changes" /></div>
				</div>
				
				
				<div class="span4 column form-sidebar  pull-right">
					<div class="field-box">
						<label>Type:</label>
						<div class="ui-select">
							<select name="type">
								<option value="1" <?php echo ($row_editor['type'] == 1 ? "selected" : ""); ?>>Red Hot Offers</option>
								<option value="2" <?php echo ($row_editor['type'] == 2 ? "selected" : ""); ?>>Featured Products</option>
							</select>
						</div>
					</div>
					
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
				</div><!-- /span4 column -->
			</div><!-- /form-wrapper -->
		</div><!-- /form-page -->
		</form>
	 </div><!-- /container-fluid -->
</div><!-- /content -->
<?php include('../inc.footer.php'); ?>
<script type="text/javascript">
$(function () {
    $('.start_date').datepicker().on('changeDate', function (ev) {
        $(this).datepicker('hide');
    });
    
    $('.end_date').datepicker().on('changeDate', function (ev) {
        $(this).datepicker('hide');
    });
});
</script>
</body>
</html>