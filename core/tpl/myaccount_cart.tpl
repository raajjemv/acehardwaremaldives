<?php
//if(!$_SESSION['SESS_CUS_AUTH']){
//	include("login-register.tpl");
//}else{
?>
<div class="container main-container">

	<div class="cart">
		<h1>Shopping Cart</h1>
		<div class="row">
			<div class="col-xs-4 sidebar">
				<div class="head">
					<h2><?php echo ($_SESSION['SESS_CUS_AUTH']) ? get_customer_info($_SESSION['SESS_CUS_ID'], "company") : "Guest User"; ?><span>Customer</span></h2>
				</div>
				<div class="menu">
					<a href="<?php echo $myaccount_quotations; ?>" class="entypo-archive">Quotations <span>track your quotations</span></a>
					<a href="<?php echo $myaccount_cart; ?>" class="entypo-basket active">Cart <span>you have <?php echo count($_SESSION["SHOPPING_CART"]); ?> items</span></a>
					<a href="<?php echo $myaccount_wishlist; ?>" class="entypo-bag">Wish List <span>you have <?php echo count_wishlist(); ?> items</span></a>
					<a href="<?php echo $myaccount_download; ?>" class="entypo-download">Downloads <span>brochures, guides and offers</span></a>
					<a href="<?php echo $myaccount_myaccount; ?>" class="entypo-user">My Account <span>update your info, login details</span></a>
				</div>
			</div><!-- /sidebar-->
			
			<div class="col-xs-8" id="cart-items">
			
				<div class="alert cart-alert-success">
					<span><strong>Red Hot Offers!</strong> Upto 50% discount on selected items at our stores until 31st December.</span>
				</div>
				
				<table class="table table-cart">
					<thead>
						<tr>
							<td></td>
							<td>Product</td>
							<td>Qty</td>
							<td class="action-buttons">Action</td>
						</tr>
					</thead>
					<tbody>
					<?php if( count($_SESSION['SHOPPING_CART']) == 0 ){ ?>
						<tr><td colspan="4"><div class="alert-cart-empty"><span class="entypo-basket"></span><strong>YOUR CART IS CURRENTLY EMPTY.</strong> You have not added any items in your shopping cart</div></td></tr>
					<?php } ?>
					
					<?php foreach ($_SESSION['SHOPPING_CART'] as $itemNumber => $item) { ?>
						<?php
						$product_id = $item['product_id']; 
						$product_grand_category  = get_product_info($item['product_id'], "parent_category");
						$product_parent_category = get_product_info($item['product_id'], "child_category_1");
						$product_child_category  = get_product_info($item['product_id'], "child_category_2");
						
						$url_maker = $wwwroot . '/product/' . get_category_info($product_grand_category, "alias") . '/' . $item['product_id'] . '/';
						?>
						<tr data-product-id="<?php echo $product_id; ?>">
							<td width="150"><a href="<?php echo $url_maker; ?>"><img src="<?php echo $wwwroot_img; ?>/products/<?php echo $item['product_id']; ?>/thumb.jpg" class="thumb" /></a></td>
							<td>
								<div class="product-sku">SKU <?php echo $product_id; ?></div>
								<a href="<?php echo $url_maker; ?>"><?php echo get_product_info($item['product_id'], "name"); ?></a>
								<div class="product-root">
									<?php echo get_category_info($product_grand_category, "name"); ?> <span class="entypo-right-open-big"></span>
									<?php echo get_category_info($product_parent_category, "name"); ?> <span class="entypo-right-open-big"></span>
									<?php echo get_category_info($product_child_category, "name"); ?>
								</div>
							</td>
							<td><input name="items_qty" data-product-id="<?php echo $product_id; ?>" class="cart-item-qty" type="text" size="4" value="<?php echo $item['product_qty']; ?>" size="2" maxlength="3" /></td>
							<td class="action-buttons">
								<a href="#" data-product-id="<?php echo $itemNumber; ?>" class="entypo-cancel cart-remove-item"> Remove</a>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<div class="cart-navi" id="cart-navi">
					<a href="#" class="empty-cart">Empty Cart</a>
					<a href="<?php echo $wwwroot; ?>/catalogue.php">Make a Catalogue</a>
					<a href="<?php echo $wwwroot; ?>" class="pull-left">Continue Shopping</a>
					<?php if($_SESSION['SESS_CUS_AUTH']){ ?>
					<a href="<?php echo $wwwroot; ?>/cart/get-quotation/" class="getquote">Get Quotation</a>
					<?php }else{ ?>
					<a href="<?php echo $wwwroot; ?>/login-register/" class="getquote">Get Quotation</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div><!-- /myaccount -->
</div>
<?php // } //if(!$_SESSION['SESS_AUTH']){ ?>