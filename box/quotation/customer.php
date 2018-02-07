<?php session_start(); ?>
<?php include_once('../inc.config.php'); ?>
<?php include_once('../inc.auth.php'); ?>
<?php include_once('../inc.sanitize.php'); ?>
<?php include_once('../inc.functions.php'); ?>
<?php
if($_GET['action'] == "status" && $_GET['status'] && $_GET['id']){
	$customer_id = GetSQLValueString($_GET['id'], "int");
	$status = GetSQLValueString($_GET['status'], "int");
	if($status > 3 || $status < 1){
		$status = 3;
	}
	$qry = "UPDATE customer SET status		= $status
								WHERE id	= $customer_id";
	if(mysql_query($qry)){
		$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Customer Profile Updated.</div>';
		//activityMonitor($global_user_id, $customer_id, "update", "customer");
		if($status == 1){
			$to = getCustomerDetails($customer_id, 'email_address');
			$password = getCustomerDetails($customer_id, 'password');
			activation_mailer($to, $password);
		}
	}else{
		$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . '</div>' ;
	}
}
?>
<!DOCTYPE html>
<html class="login-bg">
<head>
<?php include('../inc.header.php'); ?>
<link rel="stylesheet" href="<?php echo $wwwroot_css; ?>/compiled/index.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $wwwroot_css; ?>/compiled/tables.css" type="text/css" media="screen" />
</head>
<body>
<?php
$main_page = 'quotation';
$sub_page  = 'customer.manager';
?>

<?php
if($_GET['action'] == "delete"){
	$delete_button_link = "customer.php?action=delete_confirm&id=" . $_GET['id'] . "&name=" . $_GET['name'];
	$delete_confirm = '<div class="alert"><i class="icon-warning-sign pull-left"></i><a href="customer.php" class="btn-flat white pull-right" style="margin-right: -20px; margin-top: 5px">Cancel</a> <a href="' . $delete_button_link . '" class="btn-flat white pull-right" style="margin-right: 10px; margin-top: 5px">Delete</a>  Are you sure you want to permanently delete the customer: <strong>' . $_GET['name'] .'</strong> . <br> You cant undo this action. </div>';
}

if ($_GET['action'] == "delete_confirm"){
	$get_id 	= sanitize($_GET['id'], INT);
	$sql = "DELETE FROM customer WHERE id = $get_id";
	if(mysql_query($sql)){
		$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Customer <strong>' . $_GET['name'] . '</strong> deleted from the online store.</div>';
		activityMonitor($global_user_id, $_GET['name'], "delete", "customer");
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
				        <h4>Customers</h4>
				    </div>
				</div> 
				
				<div class="row-fluid filter-block">
					<div class="pull-right">
						<form method="post" action="customer.php">
							<input type="text" class="search" placeholder="search by company name or contact person" value="<?php echo $_POST['keyword']; ?>" name="keyword" style="margin-right: 25px; margin-top: 2px; width: 300px;"/>
							
							<div class="ui-select">
								<select id="status" name="status">
									<option value="0">All</option>
									<option value="1" <?php echo ($_REQUEST['status'] == 1) ? "SELECTED" : "" ?>>Active</option>
									<option value="2" <?php echo ($_REQUEST['status'] == 2) ? "SELECTED" : "" ?>>Pending</option>
									<option value="3" <?php echo ($_REQUEST['status'] == 3) ? "SELECTED" : "" ?>>Suspended</option>
								</select>
							</div>
							
							<input type="submit" class="btn-flat primary" name="filter_results" value="Go" style="padding: 4px 10px; margin-top: 2px;" />
							<?php if($_POST['keyword']){ ?>
							<a href="customer.php" class="btn-flat gray" style="padding: 4px 10px; margin-top: 2px;">Reset</a>
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
						       <th class="span4">Company</th>
						       <th class="span4">Contact Person / Number</th>
						       <th class="span4">Shipping Address</th>
						       <th class="span1">Status</th>
						       <th class="span2">&nbsp;</th>
						   </tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							
							$filter_keyword = sanitize($_POST['keyword'], SQL);
							if($filter_keyword){ $sql_keyword = " AND company LIKE '%$filter_keyword%' OR contact_person LIKE '%$filter_keyword%' "; }
							
							$filter_status = sanitize($_REQUEST['status'], INT);
							if($filter_status){ $sql_status = " AND status = $filter_status"; }
							
							$sql = 'SELECT * FROM customer WHERE id != "" ' . $sql_keyword . $sql_status . ' ORDER BY company ASC';
							if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
							?>
							<?php 
							while($row = mysql_fetch_assoc($result)) { 
							$i++;
							?>
							<tr <?php if($i == 1){ echo 'class="first"'; } ?>>
								<td style="text-align: center;"><?php echo $i; ?></td>
								<td><strong><?php echo $row['company']; ?></strong></td>
								<td><strong><?php echo $row['contact_person']; ?></strong><br><?php echo $row['contact_no']; ?><br><?php echo $row['email_address']; ?></td>
								<td><?php echo ($row['shipping_address']) ? $row['shipping_address'] : "No shipping address available"; ?></td>
								<td><span class="label <?php echo $customer_status_colors_array[$row['status']]; ?>"><?php echo $customer_status_array[$row['status']]; ?></span></td>
								<td>
									<div class="btn-group pull-right">
										<a href="customer.php?action=status&status=1&id=<?php echo $row['id']; ?>" title="Activate"><button class="glow left <?php echo ($row['status'] == 1) ? 'active' : ''; ?>"><i class="icon-ok"></i></button></a>
										<a href="customer.php?action=status&status=2&id=<?php echo $row['id']; ?>" title="Pending"><button class="glow middle <?php echo ($row['status'] == 2) ? 'active' : ''; ?>"><i class="icon-minus"></i></button></a>
										<a href="customer.php?action=status&status=3&id=<?php echo $row['id']; ?>" title="Suspend"><button class="glow middle <?php echo ($row['status'] == 3) ? 'active' : ''; ?>"><i class="icon-remove"></i></button></a>
										<a href="customer.php?action=delete&id=<?php echo $row['id']; ?>&name=<?php echo $row['contact_person']; ?>"><button class="glow right"><i class="icon-trash"></i></button></a>
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