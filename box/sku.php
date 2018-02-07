<?php 
include_once('inc.config.php'); 
include_once('inc.functions.php');
include_once('inc.sanitize.php');

if (! empty ($_POST))
{
	foreach ($_POST as $key => $value) { 
		$_POST [$key] = sanitize ($value, SQL);
	}
	foreach ($_GET as $key => $value) { 
		$_GET [$key] = sanitize ($value, SQL);
	}
}

$product_id_1 = GetSQLValueString($_GET['product_id'], "double");
$product_id_2 = sanitize($_GET['product_id'], FLOAT);
$product_id_3 = $_GET['product_id'];

echo "SKU TEST1: " .  $product_id_1 . '<br>';
echo "SKU TEST2: " .  $product_id_2 . '<br>';
echo "SKU TEST2: " .  $product_id_3 . '<br>';
?>