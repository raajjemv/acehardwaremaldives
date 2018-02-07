<div class="container main-container">

	<div class="page-info">
		<h1>Our Brands</h1>
		
		<div class="row">
			<div class="col-xs-12">
				<div class="page-contents page-brands">
					<?php
					$sql_brands = "SELECT * FROM brand WHERE status = 1 ORDER BY name ASC LIMIT 50";
					if (!($result_brands = mysql_query ($sql_brands))){exit ('<b>Error:</b>' . mysql_error ());}
					?>
					<?php 
					while($row_brands = mysql_fetch_assoc($result_brands)) {
					?>
						<?php
						$image_file = 'core/images/brands/' . $row_brands['alias'] . '.png';
						if(file_exists($image_file)){
						?><img src="<?php echo $wwwroot_img; ?>/brands/<?php echo $row_brands['alias']; ?>.png">
						<?php }else{ ?>
						<img src="http://placehold.it/188x188/F7F7F7/C82C34&text=<?php echo $row_brands['name']; ?>">	
						<?php } ?>
					<?php } ?>
					<div class="clear"></div>
				</div><!-- /page-contents -->
			</div><!-- /col-xs-6 -->
		</div><!-- /row -->
	</div><!-- /product-info -->
</div>