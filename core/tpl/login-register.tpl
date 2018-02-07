<div class="container main-container">

	<div class="myaccount">
		<h1>My Account</h1>
		<div class="row">
		
			<div class="col-xs-5">
				<div class="login-register">
					<h2 class="entypo-key">RETURNING CUSTOMER<span>Please log in to continue...</span></h2>
					<?php if($error_login) { echo $error_login; } ?>
					<?php if($success_login) { echo $success_login; } ?>
					<div class="form">
						<form method="post" action="<?php echo $wwwroot; ?>/myaccount/">
							<div class="form-group"><label>Email Address</label><input type="email" name="email" class="form-control" placeholder=""></div>
							<div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" placeholder=""></div>
							<input type="submit"  class="btn btn-default pull-right" name="login" value="LOGIN" />
							<a href="#" class="pull-right">forgot password</a>
						</form>
						<div class="clear"></div>
					</div><!-- /login-register form-->
				</div><!-- /login-register -->
			</div>
			
			<div class="col-xs-2"><div class="or">OR</div></div>
			
			<div class="col-xs-5">
				<div class="login-register">
					<h2 class="entypo-feather">NEW CUSTOMER<span>Get started now. Its simple and easy.</span></h2>
					<p>By creating an account with our store, you will be able to request for quotations online, download product catalogues, view and track your quotations and many more.</p>
					<?php if($invalid_captcha) { echo $invalid_captcha; } ?>
					<?php if($error_register) { echo $error_register; } ?>
					<?php if($success_register) { echo $success_register; } ?>
					<div class="form">
						<form method="post" action="<?php echo $wwwroot; ?>/myaccount/">
							<div class="form-group"><label>Full Name <span>*</span></label><input type="text" name="fullname" class="form-control" value="<?php echo $_POST['fullname']; ?>" placeholder=""></div>
							<div class="form-group"><label>Email Address <span>*</span></label><input type="email" name="emailaddress" class="form-control" value="<?php echo $_POST['emailaddress']; ?>" placeholder=""></div>
							<div class="form-group"><label>Company Name</label><input type="text" name="company" class="form-control" value="<?php echo $_POST['company']; ?>" placeholder=""></div>
							<div class="form-group"><label>Contact / Mobile Number <span>*</span></label><input type="text" name="contact" class="form-control" value="<?php echo $_POST['contact']; ?>" placeholder=""></div>
							<div class="form-group">
								<label>Type the characters you see in the image below <span></span></label>
								<img src="<?php echo $wwwroot; ?>/recaptcha/captcha.php" id="captcha" width="150" style="border: 1px solid #e5e5e5;">
								<input type="text" name="captcha" class="form-control" placeholder="" style="width: 150px; height: 54px; display: inline-block;">
							</div>
							<div class="checkbox"><label><input type="checkbox" name="subscribe_newsletter" value="yes" checked> Subscribe to our newsletter and promotions</label></div>
							<input type="submit"  class="btn btn-default pull-right" name="register" value="REGISTER" />
							<a href="#" class="pull-right">By clicking REGISTER, you agree to<br> our terms and conditions</a>
							<div class="clear"></div>
						</form>
					</div><!-- /login-register form-->
				</div><!-- /login-register -->
			</div>
			
		</div><!-- /row -->
	</div><!-- /myaccount -->
</div>