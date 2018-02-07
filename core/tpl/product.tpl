<?php 
$grand_category  = get_product_info($_GET['product_id'], "parent_category"); 
$parent_category = get_product_info($_GET['product_id'], "child_category_1"); 
$child_category  = get_product_info($_GET['product_id'], "child_category_2");
if(get_product_info($_GET['product_id'], "product_id") != ""){ 
?>

<div class="container main-container">

	<div class="product-info">
		<div class="product-root">
			<a href="<?php echo $wwwroot; ?>">Home</a>
			<a href="<?php echo $wwwroot; ?>/store/<?php echo get_category_info($grand_category, "alias"); ?>/"><?php echo get_category_info($grand_category, "name"); ?></a>
			<a href="<?php echo $wwwroot; ?>/store/<?php echo get_category_info($grand_category, "alias"); ?>,<?php echo get_category_info($parent_category, "alias"); ?>/"><?php echo get_category_info($parent_category, "name"); ?></a>
			<a href="<?php echo $wwwroot; ?>/store/<?php echo get_category_info($grand_category, "alias"); ?>,<?php echo get_category_info($parent_category, "alias"); ?>,<?php echo get_category_info($child_category, "alias"); ?>/"><?php echo get_category_info($child_category, "name"); ?></a>
			<span><?php echo get_product_info($_GET['product_id'], "name"); ?></span>
		</div>
		
		<div class="product-contents">
			<div class="row">
				<div class="col-xs-5">
					<?php echo checkRedHot( get_product_info($_GET['product_id'], "product_id") ); ?>
					<img src="<?php echo $wwwroot_img; ?>/products/<?php echo get_product_info($_GET['product_id'], "product_id"); ?>/large.jpg" class="thumb-image" alt="" />
					<!--<div class="fb-like" data-href="<?php echo $wwwroot; ?>/product/<?php echo get_category_info($grand_category, "alias"); ?>/<?php echo get_product_info($_GET['product_id'], "product_id"); ?>/" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>-->
					
					<!-- AddThis Button BEGIN -->
					<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
					<a class="addthis_button_preferred_1"></a>
					<a class="addthis_button_preferred_2"></a>
					<a class="addthis_button_preferred_3"></a>
					<a class="addthis_button_preferred_4"></a>
					<a class="addthis_button_compact"></a>
					<a class="addthis_counter addthis_bubble_style"></a>
					</div>
					<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
					<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-52e34cad140c4751"></script>
					<!-- AddThis Button END -->
				</div>
				<div class="col-xs-7">
					<h1>
						<?php echo get_product_info($_GET['product_id'], "name"); ?>
						<span>SKU <?php echo get_product_info($_GET['product_id'], "product_id"); ?></span>
					</h1>
					<div class="description">
						<h2>Product Description</h2>
						<?php echo get_product_info($_GET['product_id'], "description"); ?>
					</div>
					
					<div class="product-cart">
						<div class="spinEdit"><input type="text" name="aSpinEdit" class="aSpinEdit" value="" data-product-id="<?php echo get_product_info($_GET['product_id'], "product_id"); ?>"/></div>
						<a href="#" class="add-to-cart" data-product-id="<?php echo get_product_info($_GET['product_id'], "product_id"); ?>"><span class="add-to-cart entypo-basket"></span>ADD TO CART</a>
						<a href="<?php echo $wwwroot; ?>/myaccount/" class="add-to-wishlist" data-product-id="<?php echo get_product_info($_GET['product_id'], "product_id"); ?>"><span class="entypo-bag"></span>ADD TO WISH LIST</a>
					</div>
					
					<?php if($global_hide == "false"){ ?>
					<div class="shipping-returns">
						<div class="row">
							<div class="col-xs-6">
								<h3>Shipping</h3>
								<p>This item can be shipped to your home. Or pickup this item at your local Ace Store for FREE *. </p>
							</div>
							
							<div class="col-xs-6">
								<h3>30-Day Return Guarantee * </h3>
								<p>We want you to be fully satisfied with every item that you purchase from us. </p>
							</div>
						</div>
					</div><!-- /shipping-returns -->
					<?php } ?>
				</div><!-- /col-xs-7 -->
			</div><!-- /row -->
		</div><!-- /product-contents -->
	</div><!-- /product-info -->
</div>
<?php 
}else{
	include('404.tpl');
}
?>