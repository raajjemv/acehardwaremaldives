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
					<a href="<?php echo $myaccount_download; ?>" class="entypo-download active">Downloads <span>brochures, guides and offers</span></a>
					<a href="<?php echo $myaccount_myaccount; ?>" class="entypo-user">My Account <span>update your info, login details</span></a>
				</div>
			</div><!-- /sidebar-->
			
			<div class="col-xs-8 contents">
				<?php if($error_process_quo) { echo $error_process_quo; } ?>
				<?php if($success_process_quo) { echo $success_process_quo; } ?>
				<div class="quo">
					<h2 style="margin-bottom: 10px;">Downloads</h2>
					<table class="table table-hover">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Date</th>
								<th>&nbsp;</th>
							</tr>
						</thead>
						
						<tbody>
							
							<?php
							$i = 1;
							$sql_quo_requests = "SELECT * FROM promotions_monthly WHERE status = 1 ORDER BY date DESC LIMIT 50";
							if (!($result_quo_requests = mysql_query ($sql_quo_requests))){exit ('<b>Error:</b>' . mysql_error ());}
							$count_quo_requests = mysql_num_rows($result_quo_requests);
							
							while($r_quo_requests = mysql_fetch_assoc($result_quo_requests)) {
							?>
							<tr>
								<td><?php echo $i++; ?></td>
								<td>Monthly Circular - <?php echo $r_quo_requests['title']; ?></td>
								<td><?php echo $r_quo_requests['date']; ?></td>
								<td class="table-nav">
									<a href="<?php echo $wwwroot; ?>/core/downloads/<?php echo $r_quo_requests['attachment']; ?>" class="download"><span class="entypo-download"></span></a>
								</td>
							</tr>
							<?php } ?>
							
							<?php if($count_quo_requests == 0){ ?>
							<tr><td colspan="6" style="background-color: #E47073; color: #FFF;">No quotation requests.</td></tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div><!-- /contents-->
		</div><!-- /row -->
	</div><!-- /myaccount -->
</div>
<?php } //if(!$_SESSION['SESS_AUTH']){ ?>