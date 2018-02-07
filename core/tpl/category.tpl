<?php
$grand_category 	= $_GET['parent_cat'];
$parent_category  	= $_GET['sub_cat_1'];
$child_category  	= $_GET['sub_cat_2']; 

$grand_category_id  = get_category_info_by_alias($grand_category, "id");
$parent_category_id = get_category_info_by_alias($parent_category, "id");
$child_category_id  = get_category_info_by_alias($child_category, "id");

?>

<?php 
if($grand_category && $parent_category && $child_category){
	if($grand_category_id && $parent_category_id && $child_category_id){
		echo '<div class="container main-container">';
		include('category_header.tpl');
		$category_level = "child";
		include("category_parent.tpl");
		echo '</div>';
	}else{
		include('404.tpl');
	}
}elseif ($grand_category && $parent_category && !$child_category) {
	if($grand_category_id && $parent_category_id){
		echo '<div class="container main-container">';
		include('category_header.tpl');
		$category_level = "child";
		include("category_parent.tpl");
		echo '</div>';
	}else{
		include('404.tpl');
	}
}elseif ($grand_category && !$parent_category && !$child_category){
	if($grand_category_id){
		echo '<div class="container main-container">';
		include('category_header.tpl');
		$category_level = "child";
		include("category_parent.tpl");
		echo '</div>';
	}else{
		include('404.tpl');
	}	
}
?>
