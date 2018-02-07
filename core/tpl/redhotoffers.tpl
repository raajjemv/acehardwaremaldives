<div class="container main-container">
	<!--<div class="alert alert-redhotoffers alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<strong>Red Hot Offers!</strong> Upto 50% discount on selected items at our stores.
	</div>-->
	<?php
	$redhot_offers = home_redhot_list(1);
	$redhot_offers 	= json_decode($redhot_offers);
	//print_r($redhot_offers);
	
	$redhot_offers_title = $redhot_offers->{'products'}[0]->{'title'}; 
	$redhot_offers_description = $redhot_offers->{'products'}[0]->{'description'}; 
	
	$today = date('Y-m-d H:i:s');
	$footer_redhot_date = $redhot_offers->{'products'}[0]->{'end_date'};
	$footer_redhot_remain_days = dateDiff($footer_redhot_date, $today, $precision = 1);
	?>
	<div class="red-hot-header">
		<span class="date">ends in <?php echo $footer_redhot_remain_days; ?></span>
		<h1><?php echo $redhot_offers_title; ?></h1>
		<p><?php echo $redhot_offers_description; ?></p>
	</div>
	
	<div class="index-products">
		<?php	
		$redhot_products = home_redhot_list(500);
		$redhot_products = json_decode($redhot_products);
		$data_count_redhot_products	= count($redhot_products->{'products'});
		?>
		<?php include('home_products_redhot_all.tpl'); ?>
	</div><!-- /index-products -->	
</div>