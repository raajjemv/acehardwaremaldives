<div class="top_header">
	<div class="container row">
		<div class="col-xs-3">Welcome to Ace Hardware, Maldives</div>
		<div class="col-xs-9">
			<?php if($_SESSION['SESS_CUS_AUTH']){ ?><a href="<?php echo $wwwroot; ?>/logout/">Log Out</a><?php } ?>
			<a href="<?php echo $wwwroot; ?>/ace/contact-us/">Contact Us</a>
			<a href="<?php echo $wwwroot; ?>/our-brands/">Our Brands</a>
			<a href="<?php echo $wwwroot; ?>/ace/services/">Our Services</a>
			<a href="<?php echo $wwwroot; ?>/ace/about-us/">About Us</a>
			<a href="<?php echo $wwwroot; ?>/myaccount/">My Account <?php echo ($_SESSION['SESS_CUS_AUTH']) ? "(" . get_customer_info($_SESSION['SESS_CUS_ID'], "company") . ")" : ""; ?></a>
			<a href="<?php echo $wwwroot; ?>/">Home</a>
		</div>
	</div>
</div><!--/top_header-->

<div class="header">
	<div class="container row">
	<div class="col-xs-3 logo"><a href="<?php echo $wwwroot; ?>"><img src="<?php echo $wwwroot_img; ?>/logo.png" width="120"></a></div>
	
	<div class="col-xs-6 searchform">
		<form method="post" id="product_search_form" action="<?php echo $wwwroot; ?>/search/">
			<div class="input-group">
				<input type="text" class="form-control" name="keyword" id="ace_main_search" placeholder="search online store" value="<?php echo sanitize($_REQUEST['keyword'], SQL+HTML); ?>">
				<span class="spinner loading-indicator">S</span>
				<span class="input-group-btn"><button class="btn btn-default" type="submit">Search</button></span>
			</div><!-- /input-group -->
		</form>
		<div class="searchresults" id="ace_main_search_results"><ul></ul></div>
	</div>
	
	<div class="col-xs-3 cart">
		<ul class="nav nav-pills pull-right">
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#">Cart <span id="cart_count" class="cart_count"></span> <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
		            <li><a href="<?php echo $wwwroot; ?>/cart/">View Cart</a></li>
		            <li><a href="<?php echo $wwwroot; ?>/wishlist/">View Wish List</a></li>
		            <li><a href="<?php echo $wwwroot; ?>/cart/get-quotation/">Get Quotation</a></li>
		            <li class="divider"></li>
		            <li><a href="<?php echo $wwwroot; ?>/catalogue.php">Make a Catalogue</a></li>
	          	</ul>
			</li>
		</ul>
	</div><!--/col-xs-3 -->
	</div>
</div><!--/header row -->