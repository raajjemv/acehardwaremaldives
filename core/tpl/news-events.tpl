<div class="container main-container">
	<div class="news-container">
		<h1>News &amp; Events</h1>
		<?php
		$sql = "SELECT * FROM news WHERE status = 1 ORDER BY datetime DESC LIMIT 15";
		if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
		while($r = mysql_fetch_assoc($result)) {
		?>
		<div class="news-articles">
			<span class="datetime pull-right"><?php echo dateFormater($r['datetime']); ?></span>
			<h2><?php echo $r['title']; ?></h2>

			<?php 
			$image = "core/images/news/" . generate_seo_link($r['title'], '-', true, '') . ".jpg";
			if(file_exists($image)){ 
			?>
			<img src="<?php echo $wwwroot_img; ?>/news/<?php echo generate_seo_link($r['title'], '-', true, ''); ?>.jpg" width="400" style="float:left; margin: 15px; margin-top: 28px">
			<?php } ?>

			<p><?php echo $r['body']; ?> </p>
			<div class="clear"></div>
		</div>
		<?php } ?>
	</div>
</div>