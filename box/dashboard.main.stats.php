<?php
$main_stats_total_visits	= productsMainStats("total_visits");
$main_stats_products_online = productsMainStats("products_online");
$main_stats_quotations_totalrequest = productsMainStats("quotation_total");
$main_stats_active_customers   		= productsMainStats("active_customers");
?>
<div id="main-stats">
	<div class="row-fluid stats-row">
		<div class="span3 stat">
		    <div class="data"><span class="number"><?php echo $main_stats_total_visits; ?></span>visits</div>
		    <span class="date">Total</span>
		</div>
		
		<div class="span3 stat">
		    <div class="data"><span class="number"><?php echo $main_stats_products_online; ?></span>Products</div>
		    <span class="date">Online Store</span>
		</div>
		
		<div class="span3 stat">
		    <div class="data"><span class="number"><?php echo $main_stats_quotations_totalrequest; ?></span>Quotation</div>
		    <span class="date">Requests</span>
		</div>
		
		<div class="span3 stat">
		    <div class="data"><span class="number"><?php echo $main_stats_active_customers; ?></span>Customers</div>
		    <span class="date">Registered</span>
		</div>
	</div><!--/row-fluid stats-row -->
</div><!-- /main-stats -->