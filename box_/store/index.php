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
$main_page = 'store';
$sub_page  = 'products.manager';
?>

<?php
if($_GET['action'] == "delete"){
	$delete_button_link = "index.php?action=delete_confirm&id=" . $_GET['id'] . "&name=" . $_GET['name'];
	$delete_confirm = '<div class="alert"><i class="icon-warning-sign pull-left"></i><a href="index.php" class="btn-flat white pull-right" style="margin-right: -20px; margin-top: 5px">Cancel</a> <a href="' . $delete_button_link . '" class="btn-flat white pull-right" style="margin-right: 10px; margin-top: 5px">Delete</a>  Are you sure you want to permanently delete the product: <strong>' . $_GET['name'] .'</strong> . <br> You cant undo this action. </div>';
}

if ($_GET['action'] == "delete_confirm"){
	$get_id 	= sanitize($_GET['id'], INT);
	$sql = "DELETE FROM products WHERE id = $get_id";
	if(mysql_query($sql)){
		$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Product <strong>' . $_GET['name'] . '</strong> deleted from the online store.</div>';
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
				        <h4>Products</h4>
				    </div>
				</div> 
				
				<div class="row-fluid filter-block">
					<div class="pull-right">
						<form method="post" action="index.php">
							<input type="text" class="search" placeholder="search keyword or SKU" value="<?php echo $_REQUEST['keyword']; ?>" name="keyword" style="margin-right: 25px; margin-top: 2px;"/>
							
							<div class="ui-select">
								<select name="parent_category">
									<option value="00">All Categories</option>
									<?php
									$sql = 'SELECT * FROM category WHERE parent_a = "000" ORDER BY order_no ASC';
									if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
									while($row = mysql_fetch_assoc($result)) {
									?>
									<option value="<?php echo $row['id']; ?>"  <?php echo ($_REQUEST['parent_category'] == $row['id']) ? "SELECTED" : "" ?>><?php echo $row['name']; ?></option>
									<?php } ?>
								</select>
							</div>
							
							<div class="ui-select">
								<select id="status" name="status">
									<option value="0">All</option>
									<option value="1" <?php echo ($_REQUEST['status'] == 1) ? "SELECTED" : "" ?>>Publish</option>
									<option value="2" <?php echo ($_REQUEST['status'] == 2) ? "SELECTED" : "" ?>>Pending</option>
									<option value="3" <?php echo ($_REQUEST['status'] == 3) ? "SELECTED" : "" ?>>Hidden</option>
								</select>
							</div>
							
							<input type="submit" class="btn-flat primary" name="filter_results" value="Go" style="padding: 4px 10px; margin-top: 2px;" />
							<?php if($_POST['keyword'] || $_POST['parent_category'] || $_POST['status']){ ?>
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
						       <th class="span4">Name</th>
						       <th class="span4">Category</th>
						       <th class="span1">Status</th>
						       <th class="span2">&nbsp;</th>
						   </tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							$current_page 	= sanitize($_REQUEST['page'], INT);
							$page 			= (!$_REQUEST['page']) ? 1 : sanitize($_REQUEST['page'], INT);
							$limit 			= 25;
							if($page == 1){ $offset = 0; }else{ $offset = $limit * $page;}
							//keyword parent_category status
							$filter_keyword 			= sanitize($_REQUEST['keyword'], SQL);
							$filter_parent_category 	= sanitize($_REQUEST['parent_category'], INT);
							$filter_status 				= sanitize($_REQUEST['status'], INT);
							//
							//if($filter_keyword){ $sql_keyword = " AND name LIKE '%$filter_keyword%' OR product_id = '$filter_keyword'"; }
							if($filter_keyword){ $sql_keyword = 'AND name LIKE "%' . $filter_keyword . '%" OR product_id LIKE "%' . $filter_keyword . '%"'; }
							if($filter_parent_category){ $sql_parent_cat = " AND parent_category = $filter_parent_category"; }
							if($filter_status){ $sql_status = " AND status = $filter_status"; }
							
							$sql = 'SELECT * FROM products WHERE name != "" ' . $sql_keyword . $sql_parent_cat . $sql_status . ' ORDER BY name ASC LIMIT ' . $offset .', ' . $limit;
							//echo $sql;
							if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
							
							$sql2 = 'SELECT * FROM products WHERE name != "" ' . $sql_keyword . $sql_parent_cat . $sql_status . ' ';
							if (!($result2 = mysql_query ($sql2))){exit ('<b>Error:</b>' . mysql_error ());}
							
							//PAGINATION
							$getTotal = mysql_num_rows($result2);
							$totalPages = ceil($getTotal / $limit);
							
							if($getTotal == 0){
								echo '<tr><td colspan="5"><div class="alert "><i class="icon-warning-sign"></i>No products found for your selection.</div></td><tr>';
							}
							?>
							<?php 
							while($row = mysql_fetch_assoc($result)) { 
							$i++;
							?>
							<tr <?php if($i == 1){ echo 'class="first"'; } ?>>
								<td style="text-align: center;"><?php echo $i; ?></td>
								<td><strong><?php echo stripslashes($row['name']); ?></strong> <br><span style="color: #7E91AA;">SKU <?php echo $row['product_id']; ?></span></td>
								<td>
									<?php echo getCategoryDetails($row['parent_category'], 'name'); ?> 	&nbsp;&nbsp;<span class="icon-angle-right" style="color: #7E91AA;"></span>&nbsp;&nbsp;
									<?php echo getCategoryDetails($row['child_category_1'], 'name'); ?> &nbsp;&nbsp;<span class="icon-angle-right" style="color: #7E91AA;"></span>&nbsp;&nbsp;
									<?php echo getCategoryDetails($row['child_category_2'], 'name'); ?>
								</td>
								<td><span class="label <?php echo $product_status_colors_array[$row['status']]; ?>"><?php echo $product_status_array[$row['status']]; ?></span></td>
								<td>
									<div class="btn-group pull-right">
										<a href="products.php?action=edit&id=<?php echo $row['id']; ?>"><button class="glow left"><i class="icon-pencil"></i></button></a>
										<a href="<?php echo $wwwroot_website; ?>/product/preview/<?php echo $row['product_id']; ?>/" target="_blank"><button class="glow middle"><i class="icon-desktop"></i></button></a>
										<a href="index.php?action=delete&id=<?php echo $row['id']; ?>&name=<?php echo $row['name']; ?>"><button class="glow right"><i class="icon-remove"></i></button></a>
									</div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<div class="pagination" style="margin: 0 auto; text-align: center; border-top: 1px solid #EEE; border-bottom: 1px solid #EEE; padding: 15px 0; background-color: #FDFDFD;">
						<ul style="margin-right: 15px;" ><li><a href="#">&bull;</a></li><li><a href="#">Total <?php echo $getTotal; ?></a></li><li><a href="#">&bull;</a></li></ul>
						<?php if($getTotal > $limit){ ?>
						<ul>
							<!--keyword parent_category status-->
							<?php if($current_page > 1){ ?>
							<li><a href="index.php?page=<?php echo $current_page-1; ?>&keyword=<?php echo $filter_keyword; ?>&parent_category=<?php echo $filter_parent_category; ?>&status=<?php echo $filter_status; ?>">&#8249;</a></li>
							<?php }else{ ?>
							<li><a href="#">&#8249;</a></li>
							<?php } ?>
							
							<?php
							$page_url = 'index.php?keyword=' . $filter_keyword . '&parent_category=' . $filter_parent_category . '&status=' . $filter_status . '&page=';
							$pages = page_numbers($page, $totalPages, $sep = '<li><a href="#">...</a></li>', $modulus = 8, $leading = 3, $trailing = 3, $page_url);
							echo $pages;
							?>
							
						  	<?php for ($i = 1; $i < 0; $i++) { ?>
						  	<li class="<?php echo ($page == $i) ? "active" : "" ;?>"><a href="index.php?page=<?php echo $i; ?>&keyword=<?php echo $filter_keyword; ?>&parent_category=<?php echo $filter_parent_category; ?>&status=<?php echo $filter_status; ?>"><?php echo $i; ?></a></li>
						  	<?php } ?>
						  	
						  	<?php if($current_page != ($totalPages-1)){ ?>
						  	<li><a href="index.php?page=<?php echo $current_page + 1; ?>&keyword=<?php echo $filter_keyword; ?>&parent_category=<?php echo $filter_parent_category; ?>&status=<?php echo $filter_status; ?>">&#8250;</a></li>
						  	<?php }else{ ?>
						  	<li><a href="#">&#8250;</a></li>
						  	<?php } ?>
						</ul>
						<?php } ?>
					</div><!-- /pagination -->
			 	 </div><!-- /row-fluid -->
		 	 </div><!-- /table-wrapper orders-table section-->
	 	 </div><!-- /pad-wrapper-->
	 </div><!-- /container-fluid -->
</div><!-- /content -->
<?php include('../inc.footer.php'); ?>
</body>
</html>