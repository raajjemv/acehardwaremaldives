<?php
if(!$_SESSION['SESS_CUS_AUTH']){
	include("login-register.tpl");
}else{
?>
<div class="container main-container">

	<div class="cart">
		<h1>Get Quotation</h1>
		<div class="row">
			<div class="col-xs-4 sidebar">
				<div class="head">
					<h2><?php echo ($_SESSION['SESS_CUS_AUTH']) ? get_customer_info($_SESSION['SESS_CUS_ID'], "company") : "Guest User"; ?><span>Customer</span></h2>
				</div>
				<div class="menu">
					<a href="<?php echo $myaccount_quotations; ?>" class="entypo-archive active">Quotations <span>track your quotations</span></a>
					<a href="<?php echo $myaccount_cart; ?>" class="entypo-basket">Cart <span>you have <?php echo count($_SESSION["SHOPPING_CART"]); ?> items</span></a>
					<a href="<?php echo $myaccount_wishlist; ?>" class="entypo-bag">Wish List <span>you have <?php echo count_wishlist(); ?> items</span></a>
					<a href="<?php echo $myaccount_download; ?>" class="entypo-download">Downloads <span>brochures, guides and offers</span></a>
					<a href="<?php echo $myaccount_myaccount; ?>" class="entypo-user">My Account <span>update your info, login details</span></a>
				</div>
			</div><!-- /sidebar-->
			
			<div class="col-xs-8">
				<div class="quotation-add-form">
					<h2>REQUEST FOR A QUOTATION<span>Online Quotation</span></h2>
					<div class="form">
						<form method="post" action="<?php echo $wwwroot; ?>/myaccount/">
							<div class="form-group">
								<label style="width: 100%;">Quotation Request No.</label>
								<input type="text" name="quo_req_no" class="form-control" value="ACE/QR/0<?php echo get_latest_quotation_request_no(); ?>" style="width: 150px; display: inline-block;">
								<input type="text" name="quo_date" class="form-control" value="22 Jan 2014" style="width: 150px; display: inline-block;">
							</div>
							<div class="form-group"><label>Company</label><input type="text" name="quo_company" class="form-control" value="<?php echo get_customer_info($_SESSION['SESS_CUS_ID'], "company"); ?>" placeholder="" disabled="true"></div>
							<div class="form-group">
								<label style="width: 100%;">Contact Info</label>
								<input type="text" name="quo_name" class="form-control" style="width: 200px; display: inline-block;" value="<?php echo get_customer_info($_SESSION['SESS_CUS_ID'], "contact_person"); ?>" placeholder="" disabled="true">
								<input type="text" name="quo_phone" class="form-control" style="width: 157px; display: inline-block;" value="<?php echo get_customer_info($_SESSION['SESS_CUS_ID'], "contact_no"); ?>" placeholder="" disabled="true">
								<input type="text" name="quo_email" class="form-control" style="width: 200px; display: inline-block;" value="<?php echo get_customer_info($_SESSION['SESS_CUS_ID'], "email_address"); ?>" placeholder="" disabled="true">
							</div>
							<div class="form-group">
								<label style="width: 100%;">Shipping Address</label>
								<textarea name="quo_shipping_address" class="form-control" style="height: 100px;"><?php echo get_customer_info($_SESSION['SESS_CUS_ID'], "shipping_address"); ?></textarea>
							</div>
							<h3>Items in your cart</h3>
							<table class="table table-condensed table-hover">
								<thead>
									<tr>
										<td style="padding-left: 25px;">#</td>
										<td>SKU</td>
										<td>Product</td>
										<td style="text-align: center;">Qty</td>
									</tr>
								</thead>
								<tbody>
									<?php 
									$i = 1;
									$count_cart_qty = 0;
									foreach ($_SESSION['SHOPPING_CART'] as $itemNumber => $item) { 
									?>
									<?php
									$product_id = $item['product_id']; 
									$product_grand_category  = get_product_info($item['product_id'], "parent_category");
									$count_cart_qty = $count_cart_qty + $item['product_qty'];
									
									$url_maker = $wwwroot . '/product/' . get_category_info($product_grand_category, "alias") . '/' . $item['product_id'] . '/';
									?>
									<tr data-product-id="<?php echo $product_id; ?>">
										<td style="color: #999; padding-left: 25px;"><?php echo $i++; ?></td>
										<td><a href="#" class="show-quick-view" data-product-id="<?php echo $item['product_id']; ?>"><?php echo $product_id; ?></a></td>
										<td><?php echo get_product_info($item['product_id'], "name"); ?></td>
										<td style="text-align: center;"><?php echo $item['product_qty']; ?></td>
									</tr>
									<?php } ?>
									
									<?php if($count_cart_qty == 0){ ?>
									<tr><td colspan="4" style="text-align: center; color: #FFF; padding: 10px; background-color: #E47073;">Your Cart is empty. You have not added any items in your shopping cart. Add items to your cart to request for a quotation </td></tr>
									<?php } ?>
								</tbody>
								<thead><tr><td colspan="2">&nbsp;</td><td>Total Items</td><td style="text-align: center;"><?php echo $count_cart_qty; ?></td></tr></thead>
							</table>
							<div class="form-group action-buttons">
								<?php if($count_cart_qty != 0){ ?>
								<input type="submit" class="btn btn-default pull-right" name="process_quotation" value="SUBMIT" />
								<?php } ?>
								<a href="<?php echo $wwwroot;?>/" class="btn btn-change pull-left">CONTINUE SHOPPING</a>
								<a href="<?php echo $wwwroot;?>/cart/" class="btn btn-default pull-left">MODIFY CART</a>
							</div>
						</form>
					</div><!-- /form -->
				</div><!-- /quotation-add-form -->
			</div><!-- /col-xs-8 -->
		</div><!-- /row -->
	</div><!-- /myaccount -->
</div>
<?php  } //if(!$_SESSION['SESS_AUTH']){ ?>