<?php
if(!$_SESSION['SESS_CUS_AUTH']){
	include("login-register.tpl");
}else{
?>
<div class="container main-container">

	<div class="cart">
		<h1>Wish List</h1>
		<div class="row">
			<div class="col-xs-4 sidebar">
				<div class="head">
					<h2><?php echo ($_SESSION['SESS_CUS_AUTH']) ? get_customer_info($_SESSION['SESS_CUS_ID'], "company") : "Guest User"; ?><span>Customer</span></h2>
				</div>
				<div class="menu">
					<a href="<?php echo $myaccount_quotations; ?>" class="entypo-archive">Quotations <span>track your quotations</span></a>
					<a href="<?php echo $myaccount_cart; ?>" class="entypo-basket">Cart <span>you have <?php echo count($_SESSION["SHOPPING_CART"]); ?> items</span></a>
					<a href="<?php echo $myaccount_wishlist; ?>" class="entypo-bag active">Wish List <span>you have <?php echo count_wishlist(); ?> items</span></a>
					<a href="<?php echo $myaccount_download; ?>" class="entypo-download">Downloads <span>brochures, guides and offers</span></a>
					<a href="<?php echo $myaccount_myaccount; ?>" class="entypo-user">My Account <span>update your info, login details</span></a>
				</div>
			</div><!-- /sidebar-->
			
			<div class="col-xs-8" id="cart-items">
			
				<div class="alert cart-alert-success">
					<span><strong>Red Hot Offers!</strong> Upto 50% discount on selected items at our stores until 31st December.</span>
				</div>
				<?php
				$sql = 'SELECT * FROM wishlist WHERE customer_id = ' . $_SESSION['SESS_CUS_ID'];
				if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
				$num_rows = mysql_num_rows($result);
				?>
				<table class="table table-cart">
					<thead>
						<tr>
							<td></td>
							<td>Product</td>
							<td class="action-buttons">Action</td>
						</tr>
					</thead>
					<tbody>
					<?php if($num_rows == 0 ){ ?>
						<tr><td colspan="4"><div class="alert-cart-empty"><span class="entypo-basket"></span><strong>YOUR WISH LIST IS EMPTY.</strong> You have not added any items in to your wish list.</div></td></tr>
					<?php } ?>
					
					<?php while ($r = mysql_fetch_assoc($result)) { ?>
						<?php
						$product_id = $r['product_id']; 
						$product_grand_category  = get_product_info($r['product_id'], "parent_category");
						$product_parent_category = get_product_info($r['product_id'], "child_category_1");
						$product_child_category  = get_product_info($r['product_id'], "child_category_2");
						
						$url_maker = $wwwroot . '/product/' . get_category_info($product_grand_category, "alias") . '/' . $r['product_id'] . '/';
						?>
						<tr data-product-id="<?php echo $product_id; ?>">
							<td width="150"><a href="<?php echo $url_maker; ?>"><img src="<?php echo $wwwroot_img; ?>/products/<?php echo $r['product_id']; ?>/thumb.jpg" class="thumb" /></a></td>
							<td>
								<div class="product-sku">SKU <?php echo $r['product_id']; ?></div>
								<a href="<?php echo $url_maker; ?>"><?php echo get_product_info($r['product_id'], "name"); ?></a>
								<div class="product-root">
									<?php echo get_category_info($product_grand_category, "name"); ?> <span class="entypo-right-open-big"></span>
									<?php echo get_category_info($product_parent_category, "name"); ?> <span class="entypo-right-open-big"></span>
									<?php echo get_category_info($product_child_category, "name"); ?>
								</div>
							</td>
							<td class="action-buttons">
								<a href="#" data-product-id="<?php echo $product_id; ?>" class="entypo-cancel wishlist-remove-item"> Remove</a>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<div class="cart-navi" id="cart-navi">
					<a href="<?php echo $wwwroot; ?>" class="getquote">Continue Shopping</a>
				</div>
			</div>
		</div>
	</div><!-- /myaccount -->
</div>
<?php } //if(!$_SESSION['SESS_AUTH']){ ?>