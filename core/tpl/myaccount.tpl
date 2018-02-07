<?php
if(!$_SESSION['SESS_CUS_AUTH']){
	include("login-register.tpl");
}else{
?>
<div class="container main-container">

	<div class="myaccount">
		<h1>My Account</h1>
		<div class="row">
			<div class="col-xs-4 sidebar">
				<div class="head">
					<h2><?php echo ($_SESSION['SESS_CUS_AUTH']) ? get_customer_info($_SESSION['SESS_CUS_ID'], "company") : "Guest User"; ?><span>Customer</span></h2>
				</div>
				<div class="menu">
					<a href="<?php echo $myaccount_quotations; ?>" class="entypo-archive">Quotations <span>track your quotations</span></a>
					<a href="<?php echo $myaccount_cart; ?>" class="entypo-basket">Cart <span>you have <?php echo count($_SESSION["SHOPPING_CART"]); ?> items</span></a>
					<a href="<?php echo $myaccount_wishlist; ?>" class="entypo-bag">Wish List <span>you have <?php echo count_wishlist(); ?> items</span></a>
					<a href="<?php echo $myaccount_download; ?>" class="entypo-download">Downloads <span>brochures, guides and offers</span></a>
					<a href="<?php echo $myaccount_myaccount; ?>" class="entypo-user">My Account <span>update your info, login details</span></a>
				</div>
			</div><!-- /sidebar-->
			
			<div class="col-xs-8 contents">
				<?php if($error_process_quo) { echo $error_process_quo; } ?>
				<?php if($success_process_quo) { echo $success_process_quo; } ?>
				<div class="quo">
					<h2 style="margin-bottom: 10px;">Get-A-Quote</h2>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Quotation Number</th>
								<th style="text-align: center;">No. of Items</th>
								<th>Date</th>
								<th>Status</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						
						<tbody>
							
							<?php
							$i = 1;
							$customer_id = sanitize($_SESSION['SESS_CUS_ID'], INT);
							$sql_quo_requests = "SELECT * FROM quotation_request WHERE customer_id = $customer_id ORDER BY date_time DESC LIMIT 5";
							if (!($result_quo_requests = mysql_query ($sql_quo_requests))){exit ('<b>Error:</b>' . mysql_error ());}
							$count_quo_requests = mysql_num_rows($result_quo_requests);
							
							while($r_quo_requests = mysql_fetch_assoc($result_quo_requests)) {
							?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td>ACE/QR/<?php echo $r_quo_requests['quotation_request_no']; ?></td>
								<td align="center"><?php echo count_quotation_items($r_quo_requests['quotation_request_no']); ?></td>
								<td><?php echo $r_quo_requests['date']; ?></td>
								<td><span class="label label-<?php echo $status_col[$r_quo_requests['status']]; ?>"><?php echo $status_msg[$r_quo_requests['status']]; ?></span></td>
								<td class="table-nav">
									<?php if($r_quo_requests['status'] == 3){ ?>
									<a href="<?php echo $wwwroot; ?>/download/quo/<?php echo $r_quo_requests['quotation_request_no']; ?>/" class="download"><span class="entypo-download"></span></a>
									<?php }else{ ?>
									<a href="#" class="download" style="background-color: #CCC;"><span class="entypo-download"></span></a>
									<?php } ?>
									
									<a href="<?php echo $wwwroot; ?>/quo.php?id=<?php echo $r_quo_requests['quotation_request_no']; ?>" target="_blank" class="view"><span class="entypo-layout"></span></a>
									<!--<a href="#" class="cancel"><span class="entypo-cancel"></span></a>-->
								</td>
							</tr>
							<?php } ?>
							
							<?php if($count_quo_requests == 0){ ?>
							<tr><td colspan="6" style="background-color: #E47073; color: #FFF;">No quotation requests.</td></tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				
				<div class="row">
					<div class="col-xs-6">
						<div class="small_box">
							<h2>Downloads</h2>
							<p>
								<?php
								$sql_downloads = "SELECT * FROM promotions_monthly WHERE status = 1 ORDER BY date DESC LIMIT 3";
								if (!($result_downloads = mysql_query ($sql_downloads))){exit ('<b>Error:</b>' . mysql_error ());}
								while($r_downloads = mysql_fetch_assoc($result_downloads)) {
								?>
								<a href="<?php echo $wwwroot; ?>/core/downloads/<?php echo $r_downloads['attachment']; ?>" class="links entypo-download">Monthly Circular - <?php echo $r_downloads['title']; ?></a>
								<?php } ?>
								<!--<a href="#" class="links entypo-download">Monthly Circular Jan 2014</a>
								<a href="#" class="links entypo-download">Monthly Circular Feb 2014</a>-->
							</p>
						</div>
					</div>
					
					
					<div class="col-xs-6">
						<div class="small_box">
							<h2>Cart</h2>
							<?php if( count($_SESSION['SHOPPING_CART']) == 0 ){ ?>
							<p>You have no items in your cart</p>
							<?php }else{ ?>
							<p>You have <span class="bubble"><?php echo count($_SESSION['SHOPPING_CART']); ?></span> items in your cart.</p>
							<a href="#" class="btn">Request for a Quotation</a>
							<a href="#" class="btn">Download items as a Catalogue</a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div><!-- /contents-->
		</div><!-- /row -->
	</div><!-- /myaccount -->
</div>
<?php } //if(!$_SESSION['SESS_AUTH']){ ?>