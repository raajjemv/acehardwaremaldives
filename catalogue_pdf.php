<?php session_start(); ?>
<?php
include_once('inc.config.php'); 
include_once('inc.functions.php');
include_once('inc.sanitize.php');
require_once("dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();

$message = '<html><head><title>Catalogue</title><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /></head><body>';
$message .= '
<style>
h1,h2,h3,h4,p,a{ margin: 0; padding: 0; text-decoration: none; }

@page {
	margin: 0.5cm 0.5cm 0.5cm 0.5cm;
}

.container{
	font-family: sans-serif	;
	width: 750px;
	margin: 0 auto;
}
.container .website_header{
	font-size: 10px;
	padding-bottom: 5px;
	text-align: right;
	margin-bottom: 10px;
}
.header{
	padding: 15px;
	background-color: #C82C34;
}
	.header h1{
		text-align: right;
		color: #FFF;
		font-size: 24px;
	}
	.header h2{
		text-align: right;
		color: #FFF;
		font-size: 45px;
		font-style: italic;
		text-transform: uppercase;
	}
.products{
	width: 750px;
	margin-top: 10px;
}
	.products img{
		width: 120px;
		height: 120px;
		margin-bottom: 15px;
	}
	.products tr td.product_td{
		padding: 10px;
		border: 1px solid #EEE;
		width: 157px;
	}
	table tr td{
		vertical-align: top;
	}
	.products,
	.products ul li{
		color: #777;
		font-size: 11px;
	}
	.products ul{
		margin: 0px;
		margin-bottom: 15px;
		padding: 0px;
	}
	.products h2{
		font-weight: normal;
		font-size: 12px;
		margin-bottom: 15px;
		color: #333;
	}
	.products h3{
		font-size: 10px;
		color: #333;
	}
.contact_info{
	width: 100%;
	margin-top: 15px;
	font-size: 12px;
	border-bottom: 2px solid #333;
	border-top: 2px solid #333;
}
	.contact_info tr td{
		vertical-align: top;
		padding-top: 15px;
		padding-bottom: 15px;
	}
	.contact_info tr td h2{
		font-size: 14px;
		margin-bottom: 7px;
	}
</style>';

$message .= '<div class="container">';
$message .= '<div class="header"><table cellpadding="0" cellspacing="0" width="100%"><tr><td><img src="core/images/logo_white.png" width="150" alt="" /></td><td><h1>Ace Hardware &amp; Home Centre</h1><h2>catalogue</h2></td></tr></table></div>';

// check if cart has any items 7777890 kernal
if( count($_SESSION['SHOPPING_CART']) == 0 ){
$message .= '<div class="message message-red"><strong>YOUR CART IS CURRENTLY EMPTY</strong> Add products to your cart to generate a catalogue.</div>';
}

$i = 0;
$j = 0;
$cols = 2;

$message .= '<table class="products" cellpadding="0" cellspacing="0">';
foreach ($_SESSION['SHOPPING_CART'] as $itemNumber => $item) {
	$j++;
	$product_id = $item['product_id'];
	$product_name = get_product_info($item['product_id'], "name");
	$product_desc = strip_tags(get_product_info($item['product_id'], "description"), "<ul><li><p>");
	
	if($i % $cols == 0){
		$message .= '<tr>';
	}
	
	$message .= '<td class="product_td">';
	$message .= '<table cellpadding="0" cellspacing="0"><tr>';
	$message .= '<td><div style="text-align: center"><img src="core/images/products/' . $product_id . '/thumb.jpg"></div>';
	$message .= '</td>';
	$message .= '<td><h3>SKU ' . $product_id . '</h3><h2>' . $product_name . '</h2>' . $product_desc . '</td>';
	$message .= '</tr></table>';
	$message .= '</td>';
	$i++;
	
	if($i % $cols == 0){
		$message .= '</tr>';
		$j = 0;
	}
}
if($j != 0 && count($_SESSION['SHOPPING_CART']) > 2){
	for($k = $j; $k < 2; $k++){
		$message .= '<td class="product_td" style="border:none">&nbsp;</td>';
	}
	//$message .= '<td>' . $j .'</td>';
}
$message .= '</table>';
$message .= '<table class="contact_info" cellpadding="0" cellspacing="0">
<tr>
	<td>
		<h2>Sales and Marketing</h2>
		Phone: +960 300 0099<br> 
		Fax: +960 300 0009<br> 
		Email: sales.marketing@acemaldives.com.mv<br> 
		Email: b2b@acemaldives.com.mv<br>
	</td>
	<td>
		<h2>Store One </h2>
		Phone: +960 300 0033<br> 
		Fax: +960 300 0066<br> 
		M.Sosunmaage, Alhivilaa Magu, 20292 Male, Maldives <br> 
		Email: sales@acemaldives.com.mv <br> 
	</td>
	<td>
		<h2>Store Two </h2>
		Phone:  +960 301 0033<br> 
		Fax:  +960 301 0066<br> 
		H.Merry Rose, Filigus Hingun, Male, Maldives <br> 
		Email: sales2@acemaldives.com.mv <br> 
	</td>
</tr>
</table>';
$message .= '</div>';

$message .= '</body></html>';
$dompdf->load_html($message);
$dompdf->set_paper("a4", "portrait");
$dompdf->render();
$filename = "ace_catalogue_" . date('dMY_his') . ".pdf";  
if($_GET['download']){
	$dompdf->stream($filename, array("Attachment" => true));
}else{
	$dompdf->stream($filename, array("Attachment" => false));
}
exit(0);
?>