<div class="row">
	<?php for ($i = 0; $i < 4; $i++) { ?>
	<div class="col-xs-3">
		<?php $url_maker = $wwwroot . '/product/' . get_category_info($products->{'products'}[$i]->{'parent_category'}, "alias") . '/' . $products->{'products'}[$i]->{'product_id'} . '/'; ?>
		<div class="products">
			<div class="thumbs">
				<div class="fadeimage"></div>
				<?php echo checkRedHot($products->{'products'}[$i]->{'product_id'}); ?>
				<a href="#" class="quickview entypo-layout show-quick-view" data-product-id="<?php echo $products->{'products'}[$i]->{'product_id'} ?>">Quick View</a>
				<?php $thumb_image = 'core/images/products/' . $products->{'products'}[$i]->{'product_id'} . '/thumb.jpg'; ?>
				<?php if( $products->{'products'}[$i]->{'product_id'} && file_exists($thumb_image) ){ ?>
				<img src="<?php echo $wwwroot_img; ?>/products/<?php echo $products->{'products'}[$i]->{'product_id'} ?>/thumb.jpg">
				<?php }else{?>
				<img src="http://placehold.it/134x134/CCCCCC/EF3D42&text=AceHardware">
				<?php } ?>
				</div>
			<div class="descr">
				<a href="<?php echo $url_maker; ?>"><h2><?php echo stripslashes($products->{'products'}[$i]->{'name'}); ?></h2></a>
				<!--<h3>MVR <?php echo number_format(rand(1000, 4000), 2); ?></h3>-->
				<p>
					<?php echo get_category_info($products->{'products'}[$i]->{'parent_category'}, "name"); ?> <span class="entypo-right-open-mini"></span>
					<?php echo get_category_info($products->{'products'}[$i]->{'child_category_1'}, "name"); ?> <span class="entypo-right-open-mini"></span>
					<?php echo get_category_info($products->{'products'}[$i]->{'child_category_2'}, "name"); ?> 
				</p>
			</div>
			<div class="navi">
				<a href="<?php echo $url_maker; ?>" class="more-info"><span class="entypo-info"></span></a>
				<div class="spinEdit"><input type="text" name="aSpinEdit" class="aSpinEdit" value="" size="3" data-product-id="<?php echo $products->{'products'}[$i]->{'product_id'} ?>"/></div>
				<a href="#" class="add-to-cart" data-product-id="<?php echo $products->{'products'}[$i]->{'product_id'} ?>"><span class="add-to-cart entypo-basket"></span>ADD TO CART</a>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<div class="row">
	<?php for ($i = 4; $i < 8; $i++) { ?>
	<div class="col-xs-3">
		<?php $url_maker = $wwwroot . '/product/' . get_category_info($products->{'products'}[$i]->{'parent_category'}, "alias") . '/' . $products->{'products'}[$i]->{'product_id'} . '/'; ?>
		<div class="products">
			<div class="thumbs">
				<div class="fadeimage"></div>
				<?php echo checkRedHot($products->{'products'}[$i]->{'product_id'}); ?>
				<a href="#" class="quickview entypo-layout show-quick-view" data-product-id="<?php echo $products->{'products'}[$i]->{'product_id'} ?>">Quick View</a>
				<?php if($products->{'products'}[$i]->{'product_id'}){ ?>
				<img src="<?php echo $wwwroot_img; ?>/products/<?php echo $products->{'products'}[$i]->{'product_id'} ?>/thumb.jpg">
				<?php }else{?>
				<img src="http://placehold.it/134x134/FFFFFF/EF3D42&text=AceHardware">
				<?php } ?>
			</div>
			<div class="descr">
				<a href="<?php echo $url_maker; ?>"><h2><?php echo stripslashes($products->{'products'}[$i]->{'name'}); ?></h2></a>
				<!--<h3>MVR <?php echo number_format(rand(1000, 4000), 2); ?></h3>-->
				<p>
					<?php echo get_category_info($products->{'products'}[$i]->{'parent_category'}, "name"); ?> <span class="entypo-right-open-mini"></span>
					<?php echo get_category_info($products->{'products'}[$i]->{'child_category_1'}, "name"); ?> <span class="entypo-right-open-mini"></span>
					<?php echo get_category_info($products->{'products'}[$i]->{'child_category_2'}, "name"); ?> 
				</p>
			</div>
			<div class="navi">
				<a href="<?php echo $url_maker; ?>" class="more-info"><span class="entypo-info"></span></a>
				<div class="spinEdit"><input type="text" name="aSpinEdit" class="aSpinEdit" value="" size="3" data-product-id="<?php echo $products->{'products'}[$i]->{'product_id'} ?>"/></div>
				<a href="#" class="add-to-cart" data-product-id="<?php echo $products->{'products'}[$i]->{'product_id'} ?>"><span class="add-to-cart entypo-basket"></span>ADD TO CART</a>
			</div>
		</div>
	</div>
	<?php } ?>
</div>