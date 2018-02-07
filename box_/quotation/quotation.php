<?php session_start(); ?>
<?php include_once('../inc.config.php'); ?>
<?php include_once('../inc.auth.php'); ?>
<?php include_once('../inc.sanitize.php'); ?>
<?php include_once('../inc.functions.php'); ?>
<?php
if($_POST['updateQuo']){
	$q_id 	= GetSQLValueString($_POST['q_id'], "int");
	$status = GetSQLValueString($_POST['status'], "int");
	
		$qry = "UPDATE quotation_request SET status 			= $status
								WHERE 	 quotation_request_no 	= $q_id";
		$document_name = "ACE-QR-" .$q_id;
		$upload_errors = "";
		$directory = "../../core/private/quotation/";
		if($_FILES['attachment']['name']) {
			chmod($directory ,0777);
			$maxsize    = 409600;
			$acceptable = array('application/pdf');
			$filetmpname = $_FILES["attachment"]["tmp_name"];
			
			if(($_FILES['attachment']['size'] >= $maxsize) || ($_FILES["attachment"]["size"] == 0)) {
				$upload_errors .= 'Image file size must be less than 400 Kb. ';
			}
			if(!in_array($_FILES['attachment']['type'], $acceptable) && !empty($_FILES["attachment"]["type"])) {
				$upload_errors .= 'Invalid file type. Please use pdf document.';
			}
			if(!$upload_errors){
				$target  = 	$directory . "/" . $document_name . ".pdf";
				move_uploaded_file($_FILES['attachment']['tmp_name'], $target);
				chmod($directory ,0755);
			}
		}
		if(!$upload_errors){
			if(mysql_query($qry)){
				$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Quotation Request Updated.</div>';
				//activityMonitor($global_user_id, $_POST['title'], "update", "news-events");
			}else{
				$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . '</div>' ;
			}
		}else{
			$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error! ' . $upload_errors . '</div>' ;
		}
								
//		if(mysql_query($qry)){
//			$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Quotation Request Updated.</div>';
//			//activityMonitor($global_user_id, $_POST['title'], "update", "news-events");
//		}else{
//			$feedback_error = '<div class="alert alert-error"><i class="icon-remove-sign"></i>Error in updating database. Please contact developer. ' . mysql_error() . '</div>' ;
//		}					
}
if($_GET['action'] == "view" && $_GET['id']){
	$sql = 'SELECT * FROM quotation_request WHERE quotation_request_no = "' . sanitize($_GET['id'], INT). '" ORDER BY quotation_request_no ASC';
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	$row_qr = mysql_fetch_assoc($result);
}
?>
<!DOCTYPE html>
<html class="login-bg">
<head>
<?php include('../inc.header.php'); ?>
<link rel="stylesheet" href="<?php echo $wwwroot_css; ?>/compiled/index.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $wwwroot_css; ?>/compiled/tables.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $wwwroot_css; ?>/compiled/form-showcase.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $wwwroot_css; ?>/compiled/new-user.css" type="text/css" media="screen" />
</head>
<body>
<?php
$main_page = 'quotation';
$sub_page  = 'quotation.manager';
?>
<?php include('../inc.topnav.php'); ?>
<?php include('../inc.sidenav.php'); ?>
<div class="content">
	 <div class="container-fluid">
		<?php include('main.stats.php'); ?>
		<div id="pad-wrapper">
		 	<div class="table-wrapper products-table " style="margin-bottom: 0;">	
				<div class="row-fluid head">
					 <h4 style="margin-bottom: 15px;">Quotation Request No. ACE/QR/<?php echo $row_qr['quotation_request_no']; ?></h4>
				    <div class="span6">
				        <h4 style="font-size: 14px;"><?php echo getCustomerDetails($row_qr['customer_id'], "contact_person"); ?></h4>
				        <h4 style="font-size: 12px; color: #999;"><?php echo getCustomerDetails($row_qr['customer_id'], "company"); ?></h4>
				        <h4 style="font-size: 12px; color: #999;">
				        	<?php echo getCustomerDetails($row_qr['customer_id'], "email_address"); ?> / 
				        	<?php echo getCustomerDetails($row_qr['customer_id'], "contact_no"); ?>
				        </h4>
				    </div>
				    
				    <div class="span4">
				    	<h4 style="font-size: 12px;">Shipping Address</h4>
				        <h4 style="font-size: 12px; color: #999;"><?php echo $row_qr['shipping_address']; ?></h4>
				    </div>
				</div> 
		
				<div class="row-fluid filter-block"></div>
				 <style>
				 .field-box {
				 	margin-bottom: 15px;
				 	margin-left: 20px;
				 }
				 .field-box label{
				 	font-size: 12px;
				 }
				 </style>
			 	 <div class="row-fluid form-wrapper">
			 	 	<div class="span4">
			 	 		<?php
			 	 		if($feedback_success){ echo $feedback_success; }
			 	 		if($feedback_error){ echo $feedback_error; }
			 	 		?>
			 	 		<form method="post" action="quotation.php?action=view&id=<?php echo $row_qr['quotation_request_no']; ?>" enctype="multipart/form-data">
				 	 		<h4 style="margin-bottom: 15px;">Update Quotation</h4>
				 	 		<input type="hidden" name="q_id" value="<?php echo $row_qr['quotation_request_no']; ?>" />
				 	 		<div class="field-box">
				 	 			<label>Status:</label>
				 	 			<div class="ui-select">
				 	 				<select id="status" name="status">
				 	 					<option value="0">All</option>
				 	 					<option value="1" <?php echo ($row_qr['status'] == 1) ? "SELECTED" : "" ?>>Received</option>
				 	 					<option value="2" <?php echo ($row_qr['status'] == 2) ? "SELECTED" : "" ?>>In-progress</option>
				 	 					<option value="3" <?php echo ($row_qr['status'] == 3) ? "SELECTED" : "" ?>>Completed</option>
				 	 					<option value="4" <?php echo ($row_qr['status'] == 4) ? "SELECTED" : "" ?>>Cancelled</option>
				 	 				</select>
				 	 			</div>
				 	 		</div>
			 	 			<div class="field-box"><label>PDF Document</label><input class="span8" name="attachment" type="file" /></div>
			 	 			<div class="field-box">
			 	 				<label>Currently attached Qoutation</label>
			 	 				<label>
			 	 				<?php
			 	 				$document_name = "ACE-QR-" . GetSQLValueString($row_qr['quotation_request_no'], "int");
			 	 				$directory = "../../core/private/quotation/" . $document_name . ".pdf";
			 	 				if(file_exists($directory)){
			 	 				?>
			 	 				<a href="downloader.php?qr_id=<?php echo $row_qr['quotation_request_no']; ?>" target="_blank"><?php echo $document_name; ?>.pdf</a>
			 	 				<?php }else{ ?>
			 	 				No file attached.
			 	 				<?php } ?>
			 	 				</label>
			 	 			</div>
			 	 			<div class="field-box"><label></label><input type="submit" class="btn-flat primary" name="updateQuo" value="Save" /></div>
			 	 		</form>
			 	 	</div><!-- span4 -->
				 	<table class="table table-hover span8">
						<thead>
						   <tr>
						       <th class="span1" style="text-align: center;">#</th>
						       <th class="span1">SKU</th>
						       <th class="span8">Product Name</th>
						       <th class="span2">&nbsp;</th>
						   </tr>
						</thead>
						<tbody>
							<?php
							$sql = 'SELECT * FROM quotation_requested_items WHERE quotation_request_no = ' . $row_qr['quotation_request_no'] . ' ORDER BY id ASC';
							$i = 0;
							//$sql = 'SELECT * FROM quotation_request ORDER BY date_time DESC';
							if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
							?>
							<?php 
							while($row = mysql_fetch_assoc($result)) { 
							$i++;
							?>
							<tr <?php if($i == 1){ echo 'class="first"'; } ?>>
								<td style="text-align: center;"><?php echo $i; ?></td>
								<td><strong><?php echo $row['product_id']; ?></strong></td>
								<td><?php echo getProductDetails($row['product_id'], "name"); ?></td>			
								<td>
									<div class="btn-group pull-right">
										<a href="<?php echo $wwwroot_website; ?>/product/preview/<?php echo $row['product_id']; ?>/" target="_blank"><button class="glow left"><i class="icon-desktop"></i></button></a>
										<button class="glow right disabled"><i class="icon-circle-blank"></i></button>
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