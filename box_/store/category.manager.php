<?php session_start(); ?>
<?php include_once('../inc.config.php'); ?>
<?php include_once('../inc.auth.php'); ?>
<?php include_once('../inc.sanitize.php'); ?>
<?php include_once('../inc.functions.php'); ?>
<?php
if($_GET['sort'] == "up"){
	$success = 0;
	$category_id 	= sanitize($_GET['id'], INT);
	$current_pos 	= sanitize($_GET['current_pos'], INT);
	$new_pos 		= $current_pos - 1;
	$qry1 = "UPDATE category SET order_no = $new_pos WHERE id = $category_id";
	$qry2 = "UPDATE category SET order_no = $current_pos WHERE order_no = $new_pos";  
	//echo $qry1 . '<br>';
	//echo $qry2;
	if (mysql_query ($qry2)){ $success++; }
	if (mysql_query ($qry1)){ $success++; }
	
	if($success > 0){
		activityMonitor($global_user_id, getCategoryDetails($category_id, "name"), "sort-up", "store-category");
		$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Category order updated successfully.</div>';
	}else{
		$feedback_error	  = '<div class="alert alert-error"><i class="icon-ok-sign"></i>Error sorting category.</div>';
	}
	
}
if($_GET['sort'] == "down"){
	$success = 0;
	$category_id 	= sanitize($_GET['id'], INT);
	$current_pos 	= sanitize($_GET['current_pos'], INT);
	$new_pos 		= $current_pos + 1;
	$qry1  = "UPDATE category SET order_no = $new_pos WHERE id = $category_id";
	
	$qry2 = "UPDATE category SET order_no = $current_pos WHERE order_no = $new_pos";  
	//echo $qry1 . '<br>';
	//echo $qry2;
	if (mysql_query ($qry2)){ $success++; }
	if (mysql_query ($qry1)){ $success++; }
	
	if($success > 0){
		activityMonitor($global_user_id, getCategoryDetails($category_id, "name"), "sort-down", "store-category");
		$feedback_success = '<div class="alert alert-success"><i class="icon-ok-sign"></i>Category order updated successfully.</div>';
	}else{
		$feedback_error	  = '<div class="alert alert-error"><i class="icon-ok-sign"></i>Error sorting category.</div>';
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
$main_page = 'store';
$sub_page  = 'category.manager';
?>
<?php include('../inc.topnav.php'); ?>
<?php include('../inc.sidenav.php'); ?>

<style>

</style>
<div class="content">
	 <div class="container-fluid">
		<?php include('main.stats.php'); ?>
		<div id="pad-wrapper">
		 	<div class="table-wrapper products-table " style="margin-bottom: 0;">
		 		<?php
		 		if($feedback_success){ echo $feedback_success; }
		 		if($feedback_error){ echo $feedback_error; }
		 		?>	
				<div class="row-fluid head">
				    <div class="span12">
				        <h4 class="fontawesome-ok">Category</h4>
				    </div>
				</div> 
				
				<div class="row-fluid filter-block">
				     <div class="pull-right">
				         <div class="btn-group pull-right">
				             <a href="?display=open"><button class="glow left large <?php echo ($_GET['display'] == "open") ? "active" : ""; ?>">Show All</button></a>
				             <a href="?display=close"><button class="glow right large <?php echo ($_GET['display'] == "close") ? "active" : ""; ?>">Close All</button></a>
				         </div>
				         <!--<input type="text" class="search order-search" placeholder="Search ..." />-->
				     </div>
				 </div>
				 
			 	 <div class="row-fluid">
				 	 <table class="table table-hover">
						<thead>
						   <tr>
						       <th class="span1" style="text-align: center;">ID</th>
						       <th class="span5">Name</th>
						       <th class="span2" style="text-align: center;">No. Sub Category</th>
						       <th class="span2" style="text-align: center;">No. Products</th>
						       <th class="span1">Status</th>
						       <th class="span3">&nbsp;</th>
						   </tr>
						</thead>
						<tbody>
							<?php
							$i = 0;
							$sql = 'SELECT * FROM category WHERE parent_a = "00" ORDER BY order_no ASC';
							if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
							$count_categories = mysql_num_rows($result);
							?>
							<?php 
							while($row = mysql_fetch_assoc($result)) { 
							$i++;
							?>
								<tr class=" <?php if($i == 1){ echo 'first'; } ?>">
									<td style="text-align: center;"><?php echo $i; ?></td>
									<td><strong><?php echo $row['name']; ?></strong></td>
									<td style="text-align: center;"><span class="bubble"><?php echo categorySubCount($row['id']); ?></span></td>
									<td style="text-align: center;"><strong><?php echo parent_category_products_list($row['id'], '', '', 1, 1, true); ?></strong></td>
									<td><span class="label <?php echo $category_status_colors_array[$row['status']]; ?>"><?php echo $category_status_array[$row['status']]; ?></span></td>
									<td>
										<div class="btn-group pull-right">
											<button class="glow left view-sub-categories" id="<?php echo $row['alias']; ?>"><i class="icon-<?php echo (categorySubCount($row['id']) > 0) ? "folder-open" : "folder-open-alt"; ?>"></i></button>
											<a href="category.php?action=edit&id=<?php echo $row['id']; ?>"><button class="glow right"><i class="icon-pencil"></i></button></a>
											<!--<button class="glow right"><i class="icon-remove"></i></button>-->
										</div>
										
										<div class="btn-group pull-right" style="margin-right: 15px;">
											<?php if($row['order_no'] != 1){ ?>
											<a href="category.manager.php?current_pos=<?php echo $row['order_no']; ?>&sort=up&id=<?php echo $row['id']; ?>"><button class="glow left"><i class="icon-arrow-up"></i></button></a>
											<?php }else{ ?>
											<button class="glow left"><i class="icon-circle-blank"></i></button>
											<?php } ?>
											
											<?php if($row['order_no'] != $count_categories){ ?>
											<a href="category.manager.php?current_pos=<?php echo $row['order_no']; ?>&sort=down&id=<?php echo $row['id']; ?>"><button class="glow right"><i class="icon-arrow-down"></i></button></a>
											<?php }else{ ?>
											<button class="glow right"><i class="icon-circle-blank"></i></button>
											<?php } ?>
										</div>
										<!--<span class="pull-right"><?php echo $row['order_no']; ?></span>-->
									</td>
								</tr>
								<?php
								$j = 0;
								$sql2 = 'SELECT * FROM category WHERE parent_a = "' . $row['id'] .'" OR parent_b = "' . $row['id'] .'" OR parent_c = "' . $row['id'] .'" ORDER BY name ASC';
								if (!($result2 = mysql_query ($sql2))){exit ('<b>Error:</b>' . mysql_error ());}
								?>
								<?php while($row2 = mysql_fetch_assoc($result2)) { $j++; ?>
									<tr class="small sub-categories <?php echo $row['alias']; ?>">
										<td style="text-align: center;">&nbsp;</td>
										<td><i class="icon-chevron-<?php echo (categorySubCount($row2['id']) > 0) ? "down" : "right"; ?>"></i> &nbsp;&nbsp;&nbsp;<?php echo $row2['name']; ?></td>
										<td style="text-align: center;"><span class="bubble"><?php echo categorySubCount($row2['id']); ?></span></td>
										<td style="text-align: center;"><?php echo parent_category_products_list($row['id'], $row2['id'], '', 1, 1, true); ?></td>
										<td><span class="label <?php echo $category_status_colors_array[$row2['status']]; ?>"><?php echo $category_status_array[$row2['status']]; ?></span></td>
										<td>
											<div class="btn-group pull-right">
												<button class="glow left view-sub-categories" id="<?php echo $row['alias']; ?>-<?php echo $row2['alias']; ?>"><i class="icon-<?php echo (categorySubCount($row2['id']) > 0) ? "folder-open" : "folder-open-alt"; ?>"></i></button>
												<a href="category.php?action=edit&id=<?php echo $row2['id']; ?>"><button class="glow right"><i class="icon-pencil"></i></button></a>
												<!--<button class="glow right"><i class="icon-circle-blank"></i></button>-->
											</div>
										</td>
									</tr>
									<?php
									$sql3 = 'SELECT * FROM category WHERE parent_a = "' . $row2['id'] .'" OR parent_b = "' . $row2['id'] .'" OR parent_c = "' . $row2['id'] .'" ORDER BY name ASC';
									if (!($result3 = mysql_query ($sql3))){exit ('<b>Error:</b>' . mysql_error ());}
									?>
									<?php while($row3 = mysql_fetch_assoc($result3)) { ?>
										<tr class="small sub-categories <?php echo $row['alias']; ?>">
											<td style="text-align: center;">&nbsp;</td>
											<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="icon-chevron-right"></i> &nbsp;&nbsp;&nbsp;<?php echo $row3['name']; ?></td>
											<td style="text-align: center;">&nbsp;</td>
											<td style="text-align: center;"><?php echo parent_category_products_list($row['id'], $row2['id'], $row3['id'], 1, 1, true); ?></td>
											<td><span class="label <?php echo $category_status_colors_array[$row3['status']]; ?>"><?php echo $category_status_array[$row3['status']]; ?></span></td>
											<td>
												<div class="btn-group pull-right">
													<button class="glow left"><i class="icon-circle-blank"></i></button>
													<a href="category.php?action=edit&id=<?php echo $row3['id']; ?>"><button class="glow right"><i class="icon-pencil"></i></button></a>
												</div>
											</td>
										</tr>
									<?php } ?>
								<?php } ?>
							<?php } ?>
						</tbody>
					</table>
			 	 </div><!-- /row-fluid -->
		 	 </div><!-- /table-wrapper orders-table section-->
	 	 </div><!-- /pad-wrapper-->
	 </div><!-- /container-fluid -->
</div><!-- /content -->
<?php include('../inc.footer.php'); ?>
<script type="text/javascript">
$(function () {
	<?php 
	if($_GET['display'] == 'open'){
		echo '$(".sub-categories").show();';
	}elseif($_GET['display'] == 'close'){
		echo '$(".sub-categories").hide();';
	}else{
		echo '$(".sub-categories").hide();';
	}
	?>
	
	
	$( ".view-sub-categories" ).click(function() {
		//$(".sub-categories").hide();
		getID = '.' + $(this).attr("id");
		console.log(getID);
		$(getID).toggle();
	});
});
</script>
</body>
</html>