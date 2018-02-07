<div class="accordion">
	<?php for ($i = 0; $i < $data_count; $i++) { ?>
	<h3	data-alias="<?php echo $top_category->{'main_category_menu'}[$i]->{'alias'}; ?>" class="title_<?php echo $top_category->{'main_category_menu'}[$i]->{'alias'}; ?>">
		<?php echo $top_category->{'main_category_menu'}[$i]->{'name'}; ?>
		<span class="entypo-right-open-big"></span>
	</h3>
	<div class="subcategory sub_<?php echo $top_category->{'main_category_menu'}[$i]->{'alias'}; ?>">
		<?php
		$sql2 = "SELECT id,name,alias,parent_a FROM category WHERE status = 1 AND parent_a = '" . $top_category->{'main_category_menu'}[$i]->{'id'} . "' OR parent_b = '" . $top_category->{'main_category_menu'}[$i]->{'id'} . "' OR parent_c = '" . $top_category->{'main_category_menu'}[$i]->{'id'} . "' ORDER BY name ASC";
		if (!($result2 = mysql_query ($sql2))){exit ('<b>Error:</b>' . mysql_error ());}
		?>
		<a href="<?php echo $wwwroot; ?>/store/<?php echo $top_category->{'main_category_menu'}[$i]->{'alias'}; ?>/" class="">
			Browse All 
			<?php echo $top_category->{'main_category_menu'}[$i]->{'name'}; ?>
			<span class="bubble pull-right"><?php echo parent_category_products_list($top_category->{'main_category_menu'}[$i]->{'id'}, '', '', 1, 1, true); ?></span>
		</a>
		<?php while($r2 = mysql_fetch_assoc($result2)) { ?>
		<a href="<?php echo $wwwroot; ?>/store/<?php echo $top_category->{'main_category_menu'}[$i]->{'alias'}; ?>,<?php echo stripslashes($r2['alias']); ?>/" class="<?php echo ($r2['alias'] == $parent_category) ? "active" : "not-active"; ?>"><?php echo stripslashes($r2['name']); ?></a>
			<?php if($parent_category && ($parent_category == $r2['alias'])){ ?>
				<?php 
				$parent_category_id = get_category_info_by_alias($parent_category, "id");
				$sql3 = "SELECT id,name,alias,parent_a FROM category WHERE status = 1 AND parent_a = '" . sanitize($parent_category_id, INT) . "' OR parent_b = '" . sanitize($parent_category_id, INT) . "' OR parent_c = '" . sanitize($parent_category_id, INT) . "' ORDER BY name ASC";
				if (!($result3 = mysql_query ($sql3))){exit ('<b>Error:</b>' . mysql_error ());}
				?>
				<?php while($r3 = mysql_fetch_assoc($result3)) { ?>
					<a href="<?php echo $wwwroot; ?>/store/<?php echo $top_category->{'main_category_menu'}[$i]->{'alias'}; ?>,<?php echo $r2['alias']; ?>,<?php echo $r3['alias']; ?>/" class="child_category entypo-dot <?php echo ($r3['alias'] == $child_category) ? "active" : "not-active"; ?>"><?php echo stripslashes($r3['name']); ?></a>
				<?php } ?>
			<?php } ?>
		<?php } ?>
	</div>
	
	<?php } ?>	
</div><!-- /accordion -->