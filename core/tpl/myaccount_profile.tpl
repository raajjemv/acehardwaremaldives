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
					<a href="<?php echo $myaccount_myaccount; ?>" class="entypo-user active">My Account <span>update your info, login details</span></a>
				</div>
			</div><!-- /sidebar-->
			
			<div class="col-xs-8 contents">
				<?php if($error_process_quo) { echo $error_process_quo; } ?>
				<?php if($success_process_quo) { echo $success_process_quo; } ?>
				<div class="quo">
					<h2 style="margin-bottom: 20px;">My Account</h2>
					<div class="form" style="padding: 0px;">
						<div class="row">
						<form method="post" action="<?php echo $wwwroot; ?>/profile/">
							<div class="col-xs-7">
								<div class="form-group"><label>Full Name</label><input type="text" name="fullname" class="form-control" value="<?php echo get_customer_info($_SESSION['SESS_CUS_ID'], "contact_person"); ?>" placeholder=""></div>
								<div class="form-group"><label>Email Address</label><input type="email" name="emailaddress" class="form-control" value="<?php echo get_customer_info($_SESSION['SESS_CUS_ID'], "email_address"); ?>" placeholder=""></div>
								<div class="form-group"><label>Company Name</label><input type="text" name="company" class="form-control" value="<?php echo get_customer_info($_SESSION['SESS_CUS_ID'], "company"); ?>" placeholder=""></div>
								<div class="form-group"><label>Contact / Mobile Number</label><input type="text" name="contact" class="form-control" value="<?php echo get_customer_info($_SESSION['SESS_CUS_ID'], "contact_no"); ?>" placeholder=""></div>
								<div class="form-group">
									<label>Shipping Address</label>
									<textarea name="shipping_address" class="form-control" style="height:70px;"><?php echo get_customer_info($_SESSION['SESS_CUS_ID'], "shipping_address"); ?></textarea>
								</div>
								<input type="submit"  class="btn btn-default pull-right" name="update_profile" value="SAVE CHANGES" />
							</div><!-- /col-xs-6-->
							<div class="col-xs-5">
								<div id="password-controller" class="password-controller">
									<div class="form-group"><label>Change Login Password?</label><input type="button" class="btn btn-change" id="change_password" name="change_password" value="Change Password" /></div>
									<div class="password-controller-fields">
										<div class="form-group"><label>New Password</label><input type="text" name="new_password" class="form-control" value="" placeholder=""></div>
									</div>
								</div>
							</div><!-- /col-xs-5-->
						</form>
						</div><!-- /row-->
					</div><!-- /form-->
				</div><!-- /Quo-->
			</div><!-- /contents-->
		</div><!-- /row -->
	</div><!-- /myaccount -->
</div>
<?php } //if(!$_SESSION['SESS_AUTH']){ ?>