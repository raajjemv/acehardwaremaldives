<div class="row">
	<?php for ($i = 0; $i < $data_count_redhot_products; $i++) { ?>
	<?php 
	$product_id = $redhot_products->{'products'}[$i]->{'product_id'}; 
	$product_name = get_product_info($redhot_products->{'products'}[$i]->{'product_id'}, "name"); 
	$product_parent_category = get_product_info($redhot_products->{'products'}[$i]->{'product_id'}, "parent_category");
	$product_child_category_1 = get_product_info($redhot_products->{'products'}[$i]->{'product_id'}, "child_category_1"); 
	$product_child_category_2 = get_product_info($redhot_products->{'products'}[$i]->{'product_id'}, "child_category_2"); 
	?>
	<div class="col-xs-3">
		<?php $url_maker = $wwwroot . '/product/' . get_category_info($product_parent_category, "alias") . '/' . $product_id . '/'; ?>
		<div class="products">
			<div class="thumbs">
				<div class="fadeimage"></div>
				<?php //echo checkRedHot($product_id); ?>
				<a href="#" class="quickview entypo-layout show-quick-view" data-product-id="<?php echo $redhot_products->{'products'}[$i]->{'product_id'} ?>">Quick View</a>
				<?php $thumb_image = 'core/images/products/' . $product_id . '/thumb.jpg'; ?>
				<?php if( $product_id && file_exists($thumb_image) ){ ?>
				<img src="<?php echo $wwwroot_img; ?>/products/<?php echo $product_id; ?>/thumb.jpg">
				<?php }else{?>
				<img src="http://placehold.it/134x134/CCCCCC/EF3D42&text=AceHardware">
				<?php } ?>
				</div>
			<div class="descr">
				<a href="<?php echo $url_maker; ?>"><h2><?php echo stripslashes($product_name); ?></h2></a>
				<!--<h3>MVR <?php echo number_format(rand(1000, 4000), 2); ?></h3>-->
				<p>
					<?php echo get_category_info($product_parent_category, "name"); ?> <span class="entypo-right-open-mini"></span>
					<?php echo get_category_info($product_child_category_1, "name"); ?> <span class="entypo-right-open-mini"></span>
					<?php echo get_category_info($product_child_category_2, "name"); ?> 
				</p>
			</div>
			<div class="navi">
				<a href="<?php echo $url_maker; ?>" class="more-info"><span class="entypo-info"></span></a>
				<div class="spinEdit"><input type="text" name="aSpinEdit" class="aSpinEdit" value="" size="3" data-product-id="<?php echo $product_id; ?>"/></div>
				<a href="#" class="add-to-cart" data-product-id="<?php echo $product_id; ?>"><span class="add-to-cart entypo-basket"></span>ADD TO CART</a>
			</div>
		</div>
	</div>
	<?php } ?>
</div>