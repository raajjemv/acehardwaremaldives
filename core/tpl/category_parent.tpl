<?php
$top_category = main_category_menu();
$top_category = json_decode($top_category);
$data_count   = count($top_category->{'main_category_menu'});
//
$perPage = 9;
$current_page = sanitize($_GET['page'], INT);
?>

<div class="row category_container">
	<div class="col-xs-3">
		<?php include('category_accordion.tpl'); ?>
	</div><!-- /col-xs-3 -->
	
	<div class="col-xs-9">
		<div class="category_products">
			<!--<h1><?php echo get_category_info_by_alias($grand_category, "name"); ?></h1>-->
			<?php			
			$products	= parent_category_products_list($grand_category_id, $parent_category_id, $child_category_id, $perPage, $current_page);
			$getTotal	= parent_category_products_list($grand_category_id, $parent_category_id, $child_category_id, $perPage, $current_page, true);
			
			$products 	= json_decode($products);
			$data_count	= count($products->{'products'});
		
			$totalPages = ceil($getTotal / $perPage)-1;
			//echo $totalPages;
			
			if($category_level == "grand"){
				$page_url = $wwwroot . '/store/' . $grand_category . '/';
			}elseif ($category_level == "parent") {
				$page_url = $wwwroot . '/store/' . $grand_category . ',' . $parent_category . '/';
			}else{
				$page_url = $wwwroot . '/store/' . $grand_category . ',' . $parent_category . ',' . $child_category . '/';
			}
			//echo ' Page: ' . $current_page;
			//print_r($_GET);
			$page_numbers = page_numbers($current_page, $totalPages, $sep = '<li><a href="#">...</a></li>', $modulus = 8, $leading = 3, $trailing = 3, $page_url); 
			?>
			<div class="index-products">
				<div class="row">
					<?php if($data_count == 0){ ?>
					<div class="col-xs-12">
					<div class="alert alert-warning alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong>Sorry!</strong> We found no items for your selection. Please try another category.
					</div>
					</div>
					<?php } ?>
					
					<?php for ($i = 0; $i < $data_count; $i++) { ?>
					<div class="col-xs-4">
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
					
					<?php if($getTotal > $perPage){ ?>
					<ul class="pagination pull-right">
						<?php if($current_page > 1){ ?><li><a href="<?php echo $page_url; ?><?php echo $current_page-1; ?>/">&laquo;</a></li> <?php } ?>
						<?php echo $page_numbers; ?>
					  	<?php //for ($i = 1; $i < $totalPages; $i++) { ?>
					  	<!-- <li class="<?php echo ($current_page == $i) ? "active" : "" ;?>"><a href="<?php echo $page_url; ?><?php echo $i; ?>/"><?php echo $i; ?></a></li> -->
					  	<?php //} ?>
						<?php if($current_page != $totalPages){ ?><li><a href="<?php echo $page_url; ?><?php echo $current_page + 1; ?>/">&raquo;</a></li><?php } ?>
					</ul>
					<?php } ?>

				</div><!-- /row -->
			</div><!-- /index-products -->
		</div><!-- /category_products -->
		
		<div class="category_intro">
			<h1><?php echo get_category_info_by_alias($grand_category, "name"); ?></h1>
			<p><?php echo get_category_info_by_alias($grand_category, "description"); ?></p>
		</div>
	</div>
</div>