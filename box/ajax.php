<?php include_once('inc.config.php'); ?>
<?php include_once('inc.sanitize.php'); ?>

<?php
$action = $_GET['action'];
if($action == "getSubCategory"){
	$parent_id = sanitize($_GET['parent_id'], INT);
	$data = array();
	
	$sql = 'SELECT * FROM category WHERE parent_a = "' . $parent_id . '" OR parent_b = "' . $parent_id . '" OR parent_c = "' . $parent_id . '" ORDER BY name ASC';
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	
	while($r = mysql_fetch_assoc($result)) {
		$data[] = $r;
	}
	echo json_encode($data);
}
?>

<?php
if($_REQUEST['term']){
	$get_product_id = sanitize($_REQUEST['term'], SQL);
	
	$db_data = array();
	$sql = 'SELECT product_id,name FROM products WHERE status = 1 AND name LIKE "%' . $get_product_id . '%" OR product_id LIKE "%' . $get_product_id . '%" ';
	
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	while($r = mysql_fetch_assoc($result)) {
		$answer[] = array(
							"value"=>$r['product_id'],
							"label"=>stripcslashes($r['name'])
						 );
	}

	echo json_encode($answer);
}
?>

