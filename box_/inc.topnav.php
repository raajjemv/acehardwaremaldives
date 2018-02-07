<div class="navbar navbar-inverse">
	<div class="navbar-inner">
		<button type="button" class="btn btn-navbar visible-phone" id="menu-toggler">
		    <span class="icon-bar"></span>
		    <span class="icon-bar"></span>
		    <span class="icon-bar"></span>
		</button>
		 <a class="brand" href="<?php echo $wwwroot; ?>"><img src="<?php echo $wwwroot_img; ?>/logo.png" /></a>
		 <ul class="nav pull-right">
		 	<li class="settings loading-indicator"><a href="#" role="button" class="rotate" style="border: none;"><i class="icon-spinner"></i></a></li>
		 	
		 	<?php if($global_user_type == 10 || $global_user_type == 10){ ?>
		 	<li class="notification-dropdown hidden-phone">
		 		<a href="#" class="trigger"><i class="icon-warning-sign"></i><span class="count">8</span></a>
		 		<div class="pop-dialog">
		 			<div class="pointer right">
		 			    <div class="arrow"></div>
		 			    <div class="arrow_border"></div>
		 			</div><!-- /pointer right -->
					<div class="body">
						<a href="#" class="close-icon"><i class="icon-remove-sign"></i></a>
						<div class="notifications">
							<h3>You have 6 new notifications</h3>
							<a href="#" class="item">
							    <i class="icon-signin"></i> New user registration
							    <span class="time"><i class="icon-time"></i> 13 min.</span>
							</a>
						</div><!-- /notifications -->
					</div><!-- /body -->
		 		</div><!-- /pop-dialog -->
		 	</li><!-- /notification-dropdown hidden-phone -->
		 	<?php } ?>
		 	
		 	<li class="dropdown">
		 		<a href="#" class="dropdown-toggle hidden-phone" data-toggle="dropdown">
		 		    Welcome, <?php echo $global_user_name; ?> (<?php echo $users_type_array[$global_user_type]; ?>)
		 		    <b class="caret"></b>
		 		</a>
		 		<ul class="dropdown-menu">
		 		    <li><a href="#">My Profile</a></li>
		 		</ul>
		 	</li>
		 	
		 	<?php if($global_user_type == 1){ ?>
		 	<li class="settings hidden-phone">
		 	    <a href="<?php echo $wwwroot; ?>/settings/" role="button">
		 	        <i class="icon-cog"></i>
		 	    </a>
		 	</li>
		 	<?php } ?>
		 	
		 	<li class="settings hidden-phone">
		 	    <a href="<?php echo $wwwroot; ?>/login.php?logout=true" role="button">
		 	        <i class="icon-signout"></i>
		 	    </a>
		 	</li>
		 </ul><!-- /nav pull-right -->
	</div><!-- /navbar-inner -->
</div><!-- /navbar navbar-invers -->