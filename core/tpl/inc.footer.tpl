<div class="footer">
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
				<h4>CONTACT US</h4>
				<h5>Office Administration </h5>
				<p>
				Phone: +960 300 0099<br>
				Fax : +960 300 0009<br>
				Email: admin@acemaldives.com.mv
				</p>
				<h5>Sales and Marketing </h5>
				<p>
				Phone: +960 300 0033<br>
				Fax : +960 300 0066<br>
				Email: sales@acemaldives.com.mv<br>
				</p>
			</div>
			<div class="col-xs-4">
				<h4>ABOUT OUR SHOP</h4>
				<h5>Ace Hardware, Maldives</h5>
				<p>We are your local hardware store and we are a part of your community. 
				Ace Hardware was launched in the Maldives on 15 December 2011 in partnership with Ace International, Chicago, USA, and subsequently, ACE HARDWARE AND HOME CENTRE store was opened on 20 December 2011. </p>
			</div>
			<div class="col-xs-4 promotions">
				<h4>PROMOTIONS</h4>
				<h5>Monthly Promotional Circular</h5>
				<?php
				$sql_footer_monthly_promo = "SELECT * FROM promotions_monthly ORDER BY date DESC LIMIT 6";
				if (!($result_footer_monthly_promo = mysql_query ($sql_footer_monthly_promo))){exit ('<b>Error:</b>' . mysql_error ());}
				?>
				<?php while($r_footer_monthly_promo = mysql_fetch_assoc($result_footer_monthly_promo)) { ?>
				<a href="<?php echo $wwwroot; ?>/core/downloads/<?php echo $r_footer_monthly_promo['attachment']; ?>" class="entypo-right-open-mini"><?php echo $r_footer_monthly_promo['title']; ?></a>
				<?php } ?>
				
				<?php
				$sql_footer_redhot = "SELECT * FROM promotions WHERE status = 1 AND type = 1 ORDER BY start_date DESC LIMIT 1";
				if (!($result_footer_redhot = mysql_query ($sql_footer_redhot))){exit ('<b>Error:</b>' . mysql_error ());}
				$r_footer_redhot = mysql_fetch_assoc($result_footer_redhot);
				
				$today = date('Y-m-d H:i:s');
				$footer_redhot_date = $r_footer_redhot['end_date'];
				$footer_redhot_remain_days = dateDiff($footer_redhot_date, $today, $precision = 1);
				?>
				<h5><?php echo $r_footer_redhot['title']; ?></h5>
				<p>
					<?php echo $r_footer_redhot['description']; ?>
					Offer ends in <?php echo $footer_redhot_remain_days; ?>
				</p>
			</div>
		</div><!--/row -->
		<hr>
		<div class="row">
			<div class="col-xs-4">
				<h4>STORE LOCATOR</h4>
				<p class="entypo-address"><a href="<?php echo $wwwroot; ?>/ace/store-locations/" style="color: #C82C34;">Click here</a> to access our store locator, we'll point you to nearest store.</p>
			</div>
			
			<div class="col-xs-4">
				<h4>MORE INFO</h4>
				<p>
					<a href="<?php echo $wwwroot; ?>/news-events/" class="entypo-dot">News &amp; Events</a><br>
					<a href="<?php echo $wwwroot; ?>/our-brands/" class="entypo-dot">Our Brands</a><br>
					<a href="<?php echo $wwwroot; ?>/ace/current-vacancies/" class="entypo-dot">Career</a><br>
					<!--<a href="#" class="entypo-dot">Delivery Information</a><br>
					<a href="#" class="entypo-dot">Returns &amp; Refunds Policy</a>-->
				</p>
			</div>
			
			<div class="col-xs-4">
				<!--<h4>&nbsp;</h4> -->
				<div class="social-icons"> 
					<a href="https://www.facebook.com/AceHardwareAndHomeCentreMaldives" target="_blank"><img src="<?php echo $wwwroot_img; ?>/social/fb.png" alt="" /></a>
					<a href="https://twitter.com/ACEhardwareMV" target="_blank"><img src="<?php echo $wwwroot_img; ?>/social/twitter.png" alt="" /></a>
					<a href="http://www.youtube.com/channel/UC75EYu084suwIz23xAwMMkw" target="_blank"><img src="<?php echo $wwwroot_img; ?>/social/youtube.png" alt="" /></a>
				</div>
				<p class="copyright">&copy; <?php echo date('Y'); ?>, Ace Hardware &amp; Home Centre. <br> All Rights Reserved.</p>
			</div>
		</div><!--/row -->
	</div><!--/container -->
</div>

<div class="container">
		<div class="row">
			<div class="col-xs-4 pull-right">
				<div class="coload_info pull-right clearfix">
					<a href="http://coload.com.mv/" target="blank" class="coload_logo pull-right"><img src="http://www.colorbank.mv/public/img/logo_coload.png" width="40" class="coload" alt=""></a>
					<span class="ownedmanaged pull-right"><a href="http://coload.com.mv/" target="blank">Co-Load Maldives Pvt. Ltd</a> in partnership with ACE international, Chicago, USA.</a></span>
				</div>	
			</div>
		</div>
</div>

<div class="quick-view-bg" id="quick-view-bg"> <div class="loading">
<div class="spinner">
  <div class="spinner-container container1">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
    <div class="circle4"></div>
  </div>
  <div class="spinner-container container2">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
    <div class="circle4"></div>
  </div>
  <div class="spinner-container container3">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
    <div class="circle4"></div>
  </div>
</div>

</div> </div>
<div class="quick-view" id="quick-view">
	<a href="#" class="entypo-cancel pull-right quick-view-close"></a>
	<h1><?php echo get_product_info("7306038", "name"); ?></h1>
	<div class="row">
		<div class="col-xs-4"><img class="thumb-image" src="<?php echo $wwwroot_img; ?>/products/<?php echo get_product_info("7306038", "product_id"); ?>/thumb.jpg"></div>
		<div class="col-xs-8">
			<div class="sku">SKU <?php echo get_product_info("7306038", "product_id"); ?></div>
			<div class="description"><?php echo get_product_info("7306038", "description"); ?></div>
			<a href="#" class="readmore">Read More</a>
			<div class="spinEdit">
				<input type="text" name="aSpinEdit" class="aSpinEdit" value="" data-product-id="<?php echo $products->{'products'}[$i]->{'product_id'} ?>"/> 
				<a href="#" class="add-to-cart" data-product-id="<?php echo $products->{'products'}[$i]->{'product_id'} ?>"><span class="add-to-cart entypo-basket"></span>ADD TO CART</a>
				<a href="<?php echo $wwwroot; ?>/myaccount/" class="add-to-wishlist pull-right" data-product-id="<?php echo $products->{'products'}[$i]->{'product_id'} ?>"><span class="entypo-bag"></span>ADD TO WISH LIST</a>
			</div>
			
			
		</div>
	</div>
</div>

<div class="alert-add-to-cart" id="alert-add-to-cart"><span class="entypo-check"></span> Item successfully added to your shopping cart</div>

<div class="alert-add-to-wishlist" id="alert-add-to-wishlist"><span class="entypo-check"></span> Item successfully added to your wishlist.</div>