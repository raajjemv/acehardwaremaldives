<div class="col-xs-3 top-category">
	<h1>Shop</h1>
	<?php
	$top_category = main_category_menu();
	$top_category = json_decode($top_category);
	$data_count   = count($top_category->{'main_category_menu'});
	?>
	<?php for ($i = 0; $i < $data_count; $i++) { ?>
	<a 	href="#" class="entypo-right-open-mini" 
	   	data-id="<?php echo $top_category->{'main_category_menu'}[$i]->{'id'}; ?>" 
	   	data-alias="<?php echo $top_category->{'main_category_menu'}[$i]->{'alias'}; ?>">
		<?php echo $top_category->{'main_category_menu'}[$i]->{'name'}; ?>
	</a>
	<?php } ?>
</div>

<?php
$top_category = main_category_menu();
$top_category = json_decode($top_category);
$data_count   = count($top_category->{'main_category_menu'});
?>
<?php for ($i = 0; $i < $data_count; $i++) { ?>
	<div class="col-xs-3 sub-top-category" id="<?php echo $top_category->{'main_category_menu'}[$i]->{'alias'}; ?>">
		<?php
		$top_category_id = $top_category->{'main_category_menu'}[$i]->{'id'};
		$sql2 = "SELECT id,name,alias,parent_a FROM category WHERE 	status = 1 AND 
																	parent_a = '" . $top_category_id . "' OR 
																	parent_b = '" . $top_category_id . "' OR 
																	parent_c = '" . $top_category_id . "' ORDER BY name ASC";
		if (!($result2 = mysql_query ($sql2))){exit ('<b>Error:</b>' . mysql_error ());}
		?>
		<h1><?php echo $top_category->{'main_category_menu'}[$i]->{'name'}; ?> <a href="#" class="entypo-cancel"></a></h1>
		<div class="category-container">
			<a href="<?php echo $wwwroot; ?>/store/<?php echo $top_category->{'main_category_menu'}[$i]->{'alias'}; ?>/" class="shopall">Shop All <?php echo $top_category->{'main_category_menu'}[$i]->{'name'}; ?></a>
			<?php while($r2 = mysql_fetch_assoc($result2)) { ?>
			<a 	href="#" class="entypo-right-open-mini" 
			   	data-id="<?php echo $r2['id']; ?>" 
			   	data-name="<?php echo stripslashes($r2['name']); ?>"
			   	data-parent-alias="<?php echo $top_category->{'main_category_menu'}[$i]->{'alias'}; ?>"
			   	data-alias="<?php echo stripslashes($r2['alias']); ?>"
			   	>
				<?php echo stripslashes($r2['name']); ?>
			</a>	
			<?php } ?>
		</div>
	</div>
<?php } ?>

<div class="col-xs-3 sub-sub-category">
	<h1 class="title"><span></span><a href="#" class="entypo-cancel"></a></h1>
	<div class="category-container">
	</div>
</div>
