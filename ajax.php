<?php 
session_start();
include_once('inc.config.php'); 
include_once('inc.sanitize.php'); 
function productExists($product_id) {
	$product_id = sanitize($product_id, FLOAT);
	$sql = "SELECT * FROM products WHERE product_id = $product_id";
    //$sql = sprintf("SELECT * FROM products WHERE product_id = %d;", $product_id); 
    return mysql_num_rows(mysql_query($sql)) > 0;
}
function productExistsInWishList($product_id, $customer_id) {
	$product_id = sanitize($product_id, FLOAT);
	$customer_id = sanitize($customer_id, INT);
	
    $sql = "SELECT * FROM wishlist WHERE customer_id = $customer_id AND product_id = $product_id";
    return mysql_num_rows(mysql_query($sql)) > 0;
}
function stripslashes_deep($value)
{
    $value = is_array($value) ?
                array_map('stripslashes_deep', $value) :
                stripslashes($value);

    return $value;
}
?>
<?php
if($_GET['request'] == "subcategory" && $_GET['category_id']){
	$get_cat_id = sanitize($_GET['category_id'], INT);
	
	require_once("phpfastcache/phpfastcache.php");
	$cache = phpFastCache();
	$cache_name = "sub_category_menu_" . $get_cat_id;
	$data  = $cache->get($cache_name);
	
	if($data == null) {
		$db_data = array();
		$sql = "SELECT id,name,alias FROM category WHERE status = 1 AND parent_a = $get_cat_id OR parent_b = $get_cat_id OR parent_c = $get_cat_id ORDER BY name ASC";
		if (!($result = mysql_query ($sql))){exit ('Error-Subcategory' . mysql_error ());}
		while($r = mysql_fetch_assoc($result)) {
			$db_data[] = $r;
		}
		$cache->set($cache_name, $db_data , 600);
	}
	$data = $cache->get($cache_name);
	echo json_encode($data);
}
?>
<?php 
if (!isset($_SESSION['SHOPPING_CART'])){ $_SESSION['SHOPPING_CART'] = array(); }
// ONLINE CART
if($_GET['action'] && $_GET['product_id']){
	
	$action = $_GET['action'];
	$product_id 	= sanitize($_GET['product_id'], FLOAT);
	$product_qty 	= sanitize($_GET['product_qty'], INT); 
	// Check if product exists or not
	if ($action == 'add' && isset($_GET['product_qty'])){
		if($product_id && !productExists($product_id)) {
			echo 'Product does not exist. ' . $product_id . '-' . $product_qty;
		}else{
			$item = array('product_id' => $product_id, 'product_qty' => $product_qty);
			$_SESSION['SHOPPING_CART'][$product_id] = $item;
		}
		//array_push($_SESSION['SHOPPING_CART'], $item);
	}else if ($action == 'remove'){
		unset($_SESSION['SHOPPING_CART'][$_GET['product_id']]);
		echo count($_SESSION['SHOPPING_CART']);
	}else if ($action == 'empty'){
		unset($_SESSION['SHOPPING_CART']);
		echo 'Cart Empty';
	}else if ($action == 'update') {
		if ($product_qty == 0){
			unset($_SESSION['SHOPPING_CART'][$product_id]);
		}elseif($product_qty >= 1){
			$_SESSION['SHOPPING_CART'][$product_id]['product_qty'] = $product_qty;
		}
		echo 'update > ' . $product_id . ':' . $product_qty;
//		foreach ($_GET['items_qty'] as $itemID => $qty) {
//			if ($qty == 0){
//				unset($_SESSION['SHOPPING_CART'][$itemID]);
//			}else if($qty >= 1) {
//				$_SESSION['SHOPPING_CART'][$itemID]['qty'] = $qty;
//			}
//		}
	}
	//print_r($_SESSION['SHOPPING_CART']);
	
}
?>
<?php 
if($_GET['request'] == "getCartCount"){
	$cart = $_SESSION['SHOPPING_CART'];
	echo count($cart);
}
?>

<?php
if($_GET['request'] == "wish-list" && $_GET['product_id'] && $_SESSION['SESS_CUS_AUTH']){
	
	$get_product_id = sanitize($_GET['product_id'], FLOAT);
	$get_customer_id = sanitize($_SESSION['SESS_CUS_ID'], INT);
	
	if($get_product_id && !productExists($get_product_id)) {
		echo 'Product does not exist';
	}else{
		if( productExistsInWishList($get_product_id, $get_customer_id) ){
			echo 'Product already in wishlist';
		}else{
			$insert_wishlist = "INSERT INTO wishlist (customer_id, product_id) VALUES ($get_customer_id, $get_product_id)";
			if(mysql_query($insert_wishlist)){
				echo 'OK';
			}
		}
	}
}

if($_GET['request'] == "wish-list-remove" && $_GET['product_id'] && $_SESSION['SESS_CUS_AUTH']){
	$get_product_id = sanitize($_GET['product_id'], FLOAT);
	$get_customer_id = sanitize($_SESSION['SESS_CUS_ID'], INT);
	// $sql = "DELETE FROM pages WHERE id = $get_id"
	$sql = "DELETE FROM wishlist WHERE product_id = $get_product_id AND customer_id = $get_customer_id";
	//echo $sql;
	if(mysql_query($sql)){
		echo 'OK';
	}
}
?>


<?php
if($_GET['request'] == "quick-view" && $_GET['product_id']){
	$get_product_id = sanitize($_GET['product_id'], FLOAT);
	
	require_once("phpfastcache/phpfastcache.php");
	$cache = phpFastCache();
	$cache_name = "quick-view-" . $get_product_id;
	$data  = $cache->get($cache_name);
	
	if($data == null) {
		$db_data = array();
		$sql = "SELECT product_id,name,description FROM products WHERE status = 1 AND product_id = $get_product_id";
		if (!($result = mysql_query ($sql))){exit ('Error-Quick-View');}
		while($r = mysql_fetch_assoc($result)) {
			$db_data[] = $r;
		}
		$cache->set($cache_name, $db_data , 600);
	}
	$stat_section 		= 'quick-view';
	$stat_identifier 	= $get_product_id;
	include('inc.statistics.php');
	$data = $cache->get($cache_name);
	echo json_encode(stripslashes_deep($data));
}
?>

<?php
//if($_GET['request'] == "quick-search" && $_GET['keyword']){
//	$get_keyword = sanitize($_GET['keyword'], SQL);
//	
//	$db_data = array();
//	$sql = "SELECT product_id,name,description FROM products WHERE status = 1 AND name LIKE '%$get_keyword%' OR product_id LIKE '%$get_keyword%' LIMIT 5";
//	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
//	while($r = mysql_fetch_assoc($result)) {
//		$db_data[] = $r;
//	}
//	
//	echo json_encode(stripslashes_deep($db_data));
//}
if($_REQUEST['term']){
	$get_product_id = sanitize($_REQUEST['term'], SQL);
	
	$db_data = array();
	$sql = 'SELECT product_id,name FROM products WHERE status = 1 AND name LIKE "%' . $get_product_id . '%" OR product_id LIKE "%' . $get_product_id . '%" LIMIT 10';
	
	if (!($result = mysql_query ($sql))){exit ('Error-Search');}
	while($r = mysql_fetch_assoc($result)) {
		$answer[] = array(
							"value"=>stripcslashes($r['product_id']),
							"label"=>stripcslashes($r['name'])
						 );
	}

	echo json_encode($answer);
}
?>

