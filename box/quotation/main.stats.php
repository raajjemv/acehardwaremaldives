<?php
$main_stats_active_customers   		= productsMainStats("active_customers");

$main_stats_quotations_inprogress 	= productsMainStats("quotation_progress");
$main_stats_quotations_processed   	= productsMainStats("quotation_processed");
$main_stats_quotations_totalrequest = productsMainStats("quotation_total");
?>
<div id="main-stats">
	<div class="row-fluid stats-row">
		<div class="span3 stat">
		    <div class="data"><span class="number"><?php echo $main_stats_active_customers; ?></span>Customers</div>
		    <span class="date">Active</span>
		</div>
		
		<div class="span3 stat">
		    <div class="data"><span class="number"><?php echo $main_stats_quotations_inprogress; ?></span>Quotations</div>
		    <span class="date">In-Progress</span>
		</div>
		
		<div class="span3 stat">
		    <div class="data"><span class="number"><?php echo $main_stats_quotations_processed; ?></span>Quotations</div>
		    <span class="date">Processed</span>
		</div>
		
		<div class="span3 stat">
		    <div class="data"><span class="number"><?php echo $main_stats_quotations_totalrequest; ?></span>Quotations</div>
		    <span class="date">Total Requests</span>
		</div>
	</div><!--/row-fluid stats-row -->
</div><!-- /main-stats -->