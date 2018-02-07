<div class="container main-container">
	<!--<div class="alert alert-redhotoffers alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong>Red Hot Offers!</strong> Upto 50% discount on selected items at our stores.
	</div>-->
	
	<div class="advantage">
		<div class="row">
			<a href="#" class="col-xs-3 entypo-search"><strong>Search</strong>All of our products</a>
			<a href="<?php echo $wwwroot; ?>/cart/get-quotation/" class="col-xs-3 entypo-check"><strong>Get-A-Quotation</strong>Request Online</a>
			<a href="<?php echo $wwwroot; ?>/ace/services/" class="col-xs-3 entypo-basket"><strong>Free Shipping</strong>Delivery to your doorstep</a>
			<a href="<?php echo $wwwroot; ?>/myaccount/" class="col-xs-3 entypo-users"><strong>Sign Up</strong>Get started now.</a>
		</div>
	</div><!-- /advantage -->
	
	<div class="banner">
		<div class="row">
			<?php include("home_categories.tpl"); ?>
			<div class="col-xs-9 slider">
				<div class="cycle-slideshow"
					style="margin-top: 15px;"   
					data-cycle-speed="2000"
				    data-cycle-timeout="6000"
				    data-cycle-prev=".cycle-prev"
					data-cycle-next=".cycle-next"
					data-cycle-caption="#alt-caption"
					data-cycle-manual-speed=2000
					data-cycle-caption-template="<h1>{{alt}}</h1><p>{{title}}</p>">
						<?php 
						$sql_banner = 'SELECT * FROM banner WHERE status = 1 ORDER BY RAND() DESC';
						if (!($result_banner = mysql_query ($sql_banner))){exit ('<b>Error:</b>' . mysql_error ());}
						?>
						<?php while ($r_banner = mysql_fetch_assoc($result_banner)) { ?>
						<img src="<?php echo $wwwroot_img; ?>/banner/<?php echo $r_banner['image']; ?>" alt="<?php echo $r_banner['title']; ?>" title="<?php echo $r_banner['descr']; ?> <br>
							<?php if($r_banner['link']){ ?>
								<a href='<?php echo $r_banner['link']; ?>' class='btn btn-default btn-sm'>Read More</a>">
							<?php } ?>
						<?php } ?>
				</div><!-- /cycle-slideshow -->
				
				<div id="alt-caption" class="center"></div>
				<a href="#" class="cycle-prev entypo-left-open-big"></a> 
				<a href="#" class="cycle-next entypo-right-open-big"></a>
			</div><!-- /col-xs-9 -->
		</div><!-- /row -->
	</div><!-- /banner -->
	
	<div class="index-products">
		<div id="accordion-nav" class="nav-products">
			<a href="#" class="redhotbuy" data-id="home-products-red">RED HOT BUY</a>/
			<a href="#" class="featured" data-id="home-products-featured">FEATURED</a>/
			<a href="#" class="newproducts" data-id="home-products-new">NEW</a>
		</div>
		<?php
		$products	= home_products_list(8);
		$products 	= json_decode($products);
		$data_count	= count($products->{'products'});
		
		$redhot_products = home_redhot_list(8);
		$redhot_products = json_decode($redhot_products);	
		
		$featured_products = home_featured_list(8);
		$featured_products = json_decode($featured_products);	
		?>
		<div id="home-products-red" class="accordion-container">
			<?php include('home_products_redhot.tpl'); ?> 
			<span class="more-red-hot-buy-detail pull-left">Save on these Red Hot Buys through the end of the month, plus FREE PICKUP at our stores!</span>
			<a href="<?php echo $wwwroot; ?>/promotions/redhot/" class="more-red-hot-buy pull-right">SHOP ALL RED HOT BUY</a>
		</div>
		<div id="home-products-new" class="accordion-container"><?php include('home_products_new.tpl'); ?></div>	
		<div id="home-products-featured" class="accordion-container"><?php include('home_products_featured.tpl'); ?></div>
	</div><!-- /index-products -->	
</div>