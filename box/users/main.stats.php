<?php
$main_stats_users_online  = productsMainStats("user_online");
$main_stats_users_offline = productsMainStats("user_offline");
?>
<div id="main-stats">
	<div class="row-fluid stats-row">
		<div class="span6 stat">
		    <div class="data"><span class="number"><?php echo $main_stats_users_online; ?></span>Active</div>
		    <span class="date">Users</span>
		</div>
		
		<div class="span6 stat">
		    <div class="data"><span class="number"><?php echo $main_stats_users_offline; ?></span>Suspend</div>
		    <span class="date">Users</span>
		</div>
	</div><!--/row-fluid stats-row -->
</div><!-- /main-stats -->