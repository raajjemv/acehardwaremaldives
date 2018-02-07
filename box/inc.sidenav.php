<div id="sidebar-nav">
	<ul id="dashboard-menu">
		<li class="<?php if($main_page == "dashboard") { echo 'active'; } ?>" >
			<div class="pointer">
			    <div class="arrow"></div>
			    <div class="arrow_border"></div>
			</div>
			<a href="<?php echo $wwwroot; ?>/index.php">
			    <i class="icon-home"></i>
			    <span>Home</span>
			</a>
		</li>
		
		<?php if($global_user_type == 1 || $global_user_type == 2 || $global_user_type == 4){ ?>
		<li class="<?php if($main_page == "store") { echo 'active'; } ?>">
		    <a class="dropdown-toggle" href="#">
		        <i class="icon-shopping-cart"></i>
		        <span>Store</span>
		        <i class="icon-chevron-down"></i>
		    </a>
		    <ul class="submenu <?php if($main_page == "store") { echo 'active'; } ?>">
		    	<li><a class="<?php if($main_page == "store" && $sub_page == "products.add") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/store/products.php">Add New Product</a></li>
		    	<li><a class="<?php if($main_page == "store" && $sub_page == "brands.add") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/store/brands.php">Add New Brand</a></li>
		    	<li><a class="<?php if($main_page == "store" && $sub_page == "category.add") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/store/category.php">Add New Category</a></li>
		        <li><a class="<?php if($main_page == "store" && $sub_page == "products.manager") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/store/">Products Manager</a></li>
		        <li><a class="<?php if($main_page == "store" && $sub_page == "brands.manager") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/store/brands.manager.php">Brands Manager</a></li>
		        <li><a class="<?php if($main_page == "store" && $sub_page == "category.manager") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/store/category.manager.php">Categories Manager</a></li>
		    </ul>
		</li>
		<?php } ?>
		
		<?php if($global_user_type == 1 || $global_user_type == 3 || $global_user_type == 4){ ?>
		<li>
		    <a class="dropdown-toggle" href="#">
		        <i class="icon-check"></i>
		        <span>Quotation</span>
		        <i class="icon-chevron-down"></i>
		    </a>
		    <ul class="submenu <?php if($main_page == "quotation") { echo 'active'; } ?>">
		    	<li><a class="<?php if($main_page == "quotation" && $sub_page == "customer.manager") { echo 'active'; } ?>"  href="<?php echo $wwwroot; ?>/quotation/customer.php">Manage Customers</a></li>
		    	<li><a class="<?php if($main_page == "quotation" && $sub_page == "quotation.manager") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/quotation/index.php">Manage Quotation Requests</a></li>
		    </ul>
		</li>
		<?php } ?>
		
		<?php if($global_user_type == 1){ ?>
		<li>
		    <a class="dropdown-toggle" href="#">
		        <i class="icon-certificate"></i>
		        <span>Promotions</span>
		        <i class="icon-chevron-down"></i>
		    </a>
		    <ul class="submenu <?php if($main_page == "promotions") { echo 'active'; } ?>">
		    	<li><a class=" <?php if($main_page == "promotions" && $sub_page == "promotions.add") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/promotions/promotion.php">Add New Promotion</a></li>
		    	<li><a class=" <?php if($main_page == "promotions" && $sub_page == "banner.add") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/promotions/banner.php">Add New Banner</a></li>
		    	<li><a class=" <?php if($main_page == "promotions" && $sub_page == "circular.add") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/promotions/circular.php">Add New Circular</a></li>
		        <li><a class=" <?php if($main_page == "promotions" && $sub_page == "promotions.manager" && $_REQUEST['type'] == 1) { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/promotions/index.php?type=1">Red Hot Offers</a></li>
		        <li><a class="<?php if($main_page == "promotions" && $sub_page == "promotions.manager" && $_REQUEST['type'] == 2) { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/promotions/index.php?type=2" >Featured Products</a></li>
		        <li><a class="<?php if($main_page == "promotions" && $sub_page == "banner.manager") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/promotions/banner_manager.php" >Home Page Banner</a></li>
		        <li><a class="<?php if($main_page == "promotions" && $sub_page == "circular.manager") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/promotions/circular_manager.php" >Monthly Promotions</a></li>
		    </ul>
		</li>
		<?php } ?>
		
		<!--<?php if($global_user_type == 1){ ?>
		<li>
		    <a href="#">
		        <i class="icon-signal"></i>
		        <span>Statistics</span>
		    </a>
		</li>
		<?php } ?>-->
		
		<?php if($global_user_type == 1){ ?>
		<li>
		    <a class="dropdown-toggle" href="#">
		        <i class="icon-edit"></i>
		        <span>Pages</span>
		        <i class="icon-chevron-down"></i>
		    </a>
		    <ul class="submenu <?php if($main_page == "page") { echo 'active'; } ?>">		
		    	<li><a  class="<?php if($main_page == "page" && $sub_page == "page.add") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/pages/page.php">Add New Page</a></li>        
		        <li><a  class="<?php if($main_page == "page" && $sub_page == "page.manager") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/pages/index.php">Manage Pages</a></li>
		        <!--<li><a class="<?php if($main_page == "user" && $sub_page == "users.profile") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/user.php">My Profile</a></li>-->
		    </ul>
		</li>
		<?php } ?>
		
		<?php if($global_user_type == 1){ ?>
		<li>
		    <a class="dropdown-toggle" href="#">
		        <i class="icon-calendar"></i>
		        <span>News</span>
		        <i class="icon-chevron-down"></i>
		    </a>
		    <ul class="submenu <?php if($main_page == "news") { echo 'active'; } ?>">		
		    	<li><a  class="<?php if($main_page == "news" && $sub_page == "news.add") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/news/news.php">Add News / Event</a></li>        
		        <li><a  class="<?php if($main_page == "news" && $sub_page == "news.manager") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/news/index.php">Manage News</a></li>
		        <!--<li><a class="<?php if($main_page == "user" && $sub_page == "users.profile") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/user.php">My Profile</a></li>-->
		    </ul>
		</li>
		<?php } ?>
		
		<?php if($global_user_type == 1){ ?>
		<li>
		    <a class="dropdown-toggle" href="#">
		        <i class="icon-group"></i>
		        <span>Users</span>
		        <i class="icon-chevron-down"></i>
		    </a>
		    <ul class="submenu <?php if($main_page == "user") { echo 'active'; } ?>">		
		    	<li><a  class="<?php if($main_page == "user" && $sub_page == "users.add") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/users/user.php">Add New User</a></li>        
		        <li><a  class="<?php if($main_page == "user" && $sub_page == "users.manager") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/users/index.php">Manage Users</a></li>
		        <!--<li><a class="<?php if($main_page == "user" && $sub_page == "users.profile") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/user.php">My Profile</a></li>-->
		    </ul>
		</li>
		<?php } ?>
		
		<?php if($global_user_type == 1){ ?>
		<li>
		    <a class="dropdown-toggle" href="#">
		        <i class="icon-cog"></i>
		        <span>Settings</span>
		        <i class="icon-chevron-down"></i>
		    </a>
		    <ul class="submenu <?php if($main_page == "settings") { echo 'active'; } ?>">
		        <li><a class="<?php if($main_page == "settings" && $sub_page == "settings.maintenance") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/settings/index.php">Website Maintenance</a></li>
		        <!--<li><a class="<?php if($main_page == "settings" && $sub_page == "settings.backup") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/settings/backup.php">Back Up</a></li>-->
		        <li><a class="<?php if($main_page == "settings" && $sub_page == "settings.seo") { echo 'active'; } ?>" href="<?php echo $wwwroot; ?>/settings/seo.php">SEO</a></li>
		    </ul>
		</li>
		<?php } ?>
	</ul>
</div><!--/sidebar-nav -->