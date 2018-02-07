<div class="category-root">
	<a href="<?php echo $wwwroot; ?>">Store</a>
	<?php if($grand_category) { ?>
		<a href="<?php echo $wwwroot; ?>/store/<?php echo $grand_category; ?>/"><?php echo get_category_info_by_alias($grand_category, "name"); ?></a>
	<?php } ?>
	<?php if($parent_category) { ?>
		<a href="<?php echo $wwwroot; ?>/store/<?php echo $grand_category; ?>,<?php echo $parent_category; ?>/"><?php echo get_category_info_by_alias($parent_category, "name"); ?></a>
	<?php } ?>
	<?php if($child_category) { ?>
		<a href="<?php echo $wwwroot; ?>/store/<?php echo $grand_category; ?>,<?php echo $parent_category; ?>,<?php echo $child_category; ?>"><?php echo get_category_info_by_alias($child_category, "name"); ?></a>
	<?php } ?>
</div>
	