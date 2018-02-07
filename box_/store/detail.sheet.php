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
<?php
if($delete_confirm){ echo $delete_confirm; }
if($feedback_success){ echo $feedback_success; }
if($feedback_error){ echo $feedback_error; }
?>
<style>
.key-icons{
	color: #7E91AA;
	display: inline-block;
	margin-right: 10px;
}
	.key-icons:before{
		margin-right: 5px;
	}
.mark-green,
.mark-red{
	display: inline-block;
	padding: 3px;
	background-color: #CCC;
	-webkit-border-radius: 3px;
			border-radius: 3px;
}
.mark-green{
	color: #FFF;
	background-color: #81BD82;
}
.mark-red{
	color: #FFF;
	background-color: #C82C34;
}
.mark-green:hover,
.mark-red:hover{
	color: #FFF;
	background-color: #333;
}
.filter-block{
	padding-top: 15px;
	padding-right: 15px;
	text-align: right;
}
</style>
<div class="filter-block">
<form method="post" action="detail.sheet.php">
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
	<a href="detail.sheet.php" class="btn-flat gray" style="padding: 4px 10px; margin-top: 2px;">Reset</a>
</form>
</div>
<table class="table table-hover">
	<thead>
	   <tr style="border-bottom: 1px solid #CCC;">
	       <th class="span1" style="text-align: center;">ID</th>
	       <th class="span1">SKU</th>
	       <th class="span6">Name</th>
	       <th class="span6">Category</th>
	       <th class="span2" colspan="2">
	       		<span class="icon-list key-icons">Description</span>
	       		<span class="icon-th-large key-icons">Thumbnail</span>
	       		<span class="icon-picture key-icons">Large</span>
	       </th>     
	   </tr>
	</thead>
	<tbody>
		<?php
		$i = 0;
		$current_page 	= sanitize($_REQUEST['page'], INT);
		$page 			= (!$_REQUEST['page']) ? 1 : sanitize($_REQUEST['page'], INT);
		$limit 			= 50;
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
			<td><span style="color: #7E91AA;"><?php echo $row['product_id']; ?></span></td>
			<td><strong><?php echo stripslashes($row['name']); ?></strong></td>
			<td>
				<?php echo getCategoryDetails($row['parent_category'], 'name'); ?> 	&nbsp;&nbsp;<span class="icon-angle-right" style="color: #7E91AA;"></span>&nbsp;&nbsp;
				<?php echo getCategoryDetails($row['child_category_1'], 'name'); ?> &nbsp;&nbsp;<span class="icon-angle-right" style="color: #7E91AA;"></span>&nbsp;&nbsp;
				<?php echo getCategoryDetails($row['child_category_2'], 'name'); ?>
			</td>
			<td>
				<span class="label <?php echo $product_status_colors_array[$row['status']]; ?>"><?php echo $product_status_array[$row['status']]; ?></span>
				<?php
				if ($row['description']) { 
					echo '<span class="icon-list mark-green" title="Description"></span>';
				}else{
					echo '<span class="icon-list mark-red" title="Description"></span>';
				}
				?>
				<?php
				$directory_thumb = "../../core/images/products/" . $row['product_id'] . '/thumb.jpg';
				$directory_image = "../../core/images/products/" . $row['product_id'] . '/large.jpg';
				if (file_exists($directory_thumb)) { 
					echo '<a href="' . $wwwroot_website . '/core/images/products/' .  $row['product_id'] . '/thumb.jpg" target="_blank" class="icon-th-large mark-green" title="Thumbnail image"></a>';
				}else{
					echo '<span class="icon-th-large mark-red" title="Thumbnail image"></span>';
				}
				?>
				<?php
				if (file_exists($directory_image)) { 
					echo '<a href="' . $wwwroot_website . '/core/images/products/' .  $row['product_id'] . '/large.jpg" target="_blank" class="icon-picture mark-green" title="Large image"></a>';
				}else{
					echo '<span class="icon-picture mark-red" title="Large image"></span>';
				}
				?>
			</td>
			<td>
				<div class="btn-group pull-right">
					<a href="products.php?action=edit&id=<?php echo $row['id']; ?>" target="_blank"><button class="glow left"><i class="icon-pencil"></i></button></a>
					<a href="<?php echo $wwwroot_website; ?>/product/preview/<?php echo $row['product_id']; ?>/" target="_blank"><button class="glow right"><i class="icon-desktop"></i></button></a>
					<!--<a href="index.php?action=delete&id=<?php echo $row['id']; ?>&name=<?php echo $row['name']; ?>"><button class="glow right"><i class="icon-remove"></i></button></a>-->
				</div>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<div class="pagination" style="margin: 0 auto; text-align: center; border-top: 1px solid #EEE; border-bottom: 1px solid #EEE; padding: 15px 15px; background-color: #FDFDFD;">
	<ul style="margin-right: 15px;" ><li><a href="#">&bull;</a></li><li><a href="#">Total <?php echo $getTotal; ?></a></li><li><a href="#">&bull;</a></li></ul>
	<?php if($getTotal > $limit){ ?>
	<ul>
		<!--keyword parent_category status-->
		<?php if($current_page > 1){ ?>
		<li><a href="detail.sheet.php?page=<?php echo $current_page-1; ?>&keyword=<?php echo $filter_keyword; ?>&parent_category=<?php echo $filter_parent_category; ?>&status=<?php echo $filter_status; ?>">&#8249;</a></li>
		<?php }else{ ?>
		<li><a href="#">&#8249;</a></li>
		<?php } ?>
		
		<?php
		$page_url = 'detail.sheet.php?keyword=' . $filter_keyword . '&parent_category=' . $filter_parent_category . '&status=' . $filter_status . '&page=';
		$pages = page_numbers($page, $totalPages, $sep = '<li><a href="#">...</a></li>', $modulus = 8, $leading = 3, $trailing = 3, $page_url);
		echo $pages;
		?>
		
	  	<?php for ($i = 1; $i < 0; $i++) { ?>
	  	<li class="<?php echo ($page == $i) ? "active" : "" ;?>"><a href="detail.sheet.php?page=<?php echo $i; ?>&keyword=<?php echo $filter_keyword; ?>&parent_category=<?php echo $filter_parent_category; ?>&status=<?php echo $filter_status; ?>"><?php echo $i; ?></a></li>
	  	<?php } ?>
	  	
	  	<?php if($current_page != ($totalPages-1)){ ?>
	  	<li><a href="detail.sheet.php?page=<?php echo $current_page + 1; ?>&keyword=<?php echo $filter_keyword; ?>&parent_category=<?php echo $filter_parent_category; ?>&status=<?php echo $filter_status; ?>">&#8250;</a></li>
	  	<?php }else{ ?>
	  	<li><a href="#">&#8250;</a></li>
	  	<?php } ?>
	</ul>
	<?php } ?>
</div><!-- /pagination -->
</body>
</html>