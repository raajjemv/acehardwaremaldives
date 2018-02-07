<?php session_start(); ?>
<?php include_once('../inc.config.php'); ?>
<?php include_once('../inc.auth.php'); ?>
<?php include_once('../inc.sanitize.php'); ?>
<?php include_once('../inc.functions.php'); ?>
<!DOCTYPE html>
<html class="login-bg">
<head>
<?php include('../inc.header.php'); ?>
<link rel="stylesheet" href="<?php echo $wwwroot_css; ?>/compiled/index.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $wwwroot_css; ?>/compiled/tables.css" type="text/css" media="screen" />
</head>
<body>
<?php
$main_page = 'promotions';
$sub_page  = 'circular.manager';
?>

<?php
if($_GET['action'] == "delete"){
	$delete_button_link = "circular_manager.php?action=delete_confirm&id=" . $_GET['id'] . "&name=" . $_GET['name'];
	$delete_confirm = '<div class="alert"><i class="icon-warning-sign pull-left"></i><a href="circular_manager.php" class="btn-flat white pull-right" style="margin-right: -20px; margin-top: 5px">Cancel</a> <a href="' . $delete_button_link . '" class="btn-flat white pull-right" style="margin-right: 10px; margin-top: 5px">Delete</a>  Are you sure you want to permanently delete the Circular: <strong>' . $_GET['name'] .'</strong> . <br> You cant undo this action. </div>';
}

if ($_GET['action'] == "delete_confirm"){
	$get_id 	= sanitize($_GET['id'], INT);
	$sql = "DELETE FROM banner WHERE id = $get_id";
	if(mysql_query($sql)){
		$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Circular <strong>' . $_GET['name'] . '</strong> deleted from the system.</div>';
		activityMonitor($global_user_id, $_GET['name'], "delete", "store-products");
	}else{
		$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. </div>' ;
	}
}
?>

<?php include('../inc.topnav.php'); ?>
<?php include('../inc.sidenav.php'); ?>
<div class="content">
	 <div class="container-fluid">
		<?php include('main.stats.php'); ?>
		<div id="pad-wrapper">
		 	<div class="table-wrapper products-table " style="margin-bottom: 0;">	
				<div class="row-fluid head">
				    <div class="span12">
				        <h4>Monthly Circular</h4>
				    </div>
				</div> 
				
				<div class="row-fluid filter-block">
					<div class="pull-right">
						<form method="post" action="circular_manager.php">
							<input type="text" class="search" placeholder="search keyword" value="<?php echo $_POST['keyword']; ?>" name="keyword" style="margin-right: 25px; margin-top: 2px;"/>
							
							<div class="ui-select">
								<select id="status" name="status">
									<option value="0">All</option>
									<option value="1" <?php echo ($_POST['status'] == 1) ? "SELECTED" : "" ?>>Publish</option>
									<option value="2" <?php echo ($_POST['status'] == 2) ? "SELECTED" : "" ?>>Pending</option>
									<option value="3" <?php echo ($_POST['status'] == 3) ? "SELECTED" : "" ?>>Hidden</option>
								</select>
							</div>
							
							<input type="submit" class="btn-flat primary" name="filter_results" value="Go" style="padding: 4px 10px; margin-top: 2px;" />
							<?php if($_POST['keyword'] || $_POST['type'] || $_POST['status']){ ?>
							<a href="index.php" class="btn-flat gray" style="padding: 4px 10px; margin-top: 2px;">Reset</a>
							<?php } ?>
				     	</form>
				     </div>
				 </div>
				 
			 	 <div class="row-fluid">
					<?php
					if($delete_confirm){ echo $delete_confirm; }
					if($feedback_success){ echo $feedback_success; }
					if($feedback_error){ echo $feedback_error; }
					?>
				 	 <table class="table table-hover">
						<thead>
						   <tr>
						       <th class="span1" style="text-align: center;">ID</th>
						       <th class="span4">Title</th>
						       <th class="span1">Status</th>
						       <th class="span2">&nbsp;</th>
						   </tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							//keyword parent_category status
							$filter_keyword = sanitize($_POST['keyword'], SQL);
							$filter_status 	= sanitize($_POST['status'], INT);
							//
							if($filter_keyword){ $sql_keyword = " AND title LIKE '%$filter_keyword%' OR title = '$filter_keyword'"; }
							if($filter_status){ $sql_status = " AND status = $filter_status"; }
							
							$sql = 'SELECT * FROM promotions_monthly WHERE title != "" ' . $sql_keyword . $sql_status . ' ORDER BY id DESC';
							if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
							?>
							<?php 
							while($row = mysql_fetch_assoc($result)) { 
							$i++;
							?>
							<tr <?php if($i == 1){ echo 'class="first"'; } ?>>
								<td style="text-align: center;"><?php echo $i; ?></td>
								<td><strong><?php echo $row['title']; ?></strong></td>
								<td><span class="label <?php echo $banner_status_colors_array[$row['status']]; ?>"><?php echo $banner_status_array[$row['status']]; ?></span></td>
								<td>
									<div class="btn-group pull-right">
										<a href="circular.php?action=edit&id=<?php echo $row['id']; ?>"><button class="glow left"><i class="icon-pencil"></i></button></a>
										<a href="circular_manager.php?action=delete&id=<?php echo $row['id']; ?>&name=<?php echo $row['title']; ?>"><button class="glow right"><i class="icon-remove"></i></button></a>
									</div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
			 	 </div><!-- /row-fluid -->
		 	 </div><!-- /table-wrapper orders-table section-->
	 	 </div><!-- /pad-wrapper-->
	 </div><!-- /container-fluid -->
</div><!-- /content -->
<?php include('../inc.footer.php'); ?>
</body>
</html>