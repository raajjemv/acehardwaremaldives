<?php session_start(); ?>
<?php 
if(!$_SESSION['SESS_CUS_AUTH']){
	die();
}
include_once('inc.config.php'); 
include_once('inc.functions.php');
include_once('inc.sanitize.php');
header('content-type:text/html;charset=utf-8');
$get_quotion_id = sanitize($_GET['id'], INT);

$sql_quo = 'SELECT * FROM quotation_request WHERE quotation_request_no = ' . $get_quotion_id . ' AND customer_id = ' . $_SESSION['SESS_CUS_ID'];
if (!($result_quo = mysql_query ($sql_quo))){exit ('<b>Error:</b>' . mysql_error ());}
$r_quo = mysql_fetch_assoc($result_quo);
if(mysql_num_rows($result_quo) == 0){
	die("Invalid QR number");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Ace Hardware, Maldives - Quotation Request</title>
<style>
*{ margin: 0; padding: 0; text-decoration: none; }
body{
	font-family: Arial;
	font-size: 12px;
	background-color: #FFF;
}
pre{
	font-family: Arial;
	font-size: 12px;
}
.quo_container{
	width: 700px;
	background-color: #FFF;
	margin: 0 auto;
	padding: 15px;
}
	.quo_container .website_header{
		font-size: 10px;
		padding-bottom: 5px;
		text-align: right;
		border-bottom: 1px solid #EEE;
		margin-bottom: 15px;
	}
	.quo_container h1{
		font-size: 18px;
		color: #FFF;
		text-align: center;
		text-transform: uppercase;
		padding-bottom: 10px;
		padding-top: 10px;
		margin-bottom: 15px;
		background-color: #333;
		border-bottom: 1px solid #EEE;
	}
.header{
	width: 100%;
	padding-bottom: 15px;
	border-bottom: 1px solid #EEE;
}
	.header .heading{
		font-weight: bold;
		font-size: 16px;
	}
	.header p{
		padding-left: 15px;
		text-align: center;
	}
.quotation_items{
	
}
	.quotation_items .table{
		font-size: 12px;
		margin: 0px;
	}
	.quotation_items .table tr td{
		border: none;
		border-bottom: 1px solid #EEE;
		font-size: 12px;
		padding: 10px;
		font-weight: 300;
	}
	.quotation_items .table thead tr td{
		border-bottom: 2px solid #CCC;
		font-size: 12px;
		font-weight: bold;
	}

.company_info{
	padding-bottom: 15px;
	margin-bottom: 15px;
	border-bottom: 1px solid #EEE;
}
	.company_info .title{
		font-weight: bold;
	}
	.company_info table tr td{
		padding: 5px 0px;
		vertical-align: top;
	}
</style>
</head>
<body>
<div class="quo_container">
	<div class="website_header">www.acehardwaremaldives.com</div>
	<table cellpadding="0" cellspacing="0" class="header">  
		<tr>
			<td><img src="<?php echo $wwwroot_img; ?>/logo.png" width="150" alt="" /></td>
			<td>
				<p><strong class="heading">Ace Hardware &amp; Home Centre</strong><br>
				<strong>GST 1001221GST501</strong><br>
				sales@acemaldives.com.mv &nbsp;&nbsp;&nbsp; sales2@acemaldives.com.mv <br>
				Tel: +960 300 0033 &nbsp;&nbsp;&nbsp; Fax: +960 301 0066, +960 300 0066</p>
			</td>
		</tr>
	</table>
	
	<h1>Quotation Request</h1>
	
	<div class="company_info">
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td class="title">Customer Name</td> <td><?php echo get_customer_info($r_quo['customer_id'], "contact_person"); ?></td>
				<td class="title">Quotation Request No.</td><td class="title">ACE/QR/<?php echo $r_quo['quotation_request_no']; ?></td>
			</tr>
			<tr>
				<td class="title">Company</td> <td><?php echo get_customer_info($r_quo['customer_id'], "company"); ?></td>
				<td class="title">Date</td><td><?php echo dateFormater($r_quo['date']); ?></td>
			</tr>
			<tr>
				<td class="title">Contact</td> <td><?php echo get_customer_info($r_quo['customer_id'], "contact_no"); ?><br><?php echo get_customer_info($r_quo['customer_id'], "email_address"); ?></td>
				<td class="title">Status</td><td><?php echo $status_msg[$r_quo['status']]; ?></td>
			</tr>
			<tr><td class="title">Shipping Address</td><td><pre><?php echo $r_quo['shipping_address']; ?></pre></td></tr>
		</table>
	</div>
	
	<div class="quotation_items">
		<?php
		$sql_quo_items = 'SELECT * FROM quotation_requested_items WHERE quotation_request_no = ' . $get_quotion_id . ' AND customer_id = ' . $_SESSION['SESS_CUS_ID'];
		//echo $sql_quo_items;
		if (!($result_quo_items = mysql_query ($sql_quo_items))){exit ('<b>Error:</b>' . mysql_error ());}
		//$r_quo_items = mysql_fetch_assoc($result_quo_items);
		$total_items = 0;
		?>
		<table class="table" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<td>SKU</td>
					<td>PRODUCT NAME</td>
					<td style="text-align: center;">QTY</td>
				</tr>
			</thead>
		<?php while($r_quo_items = mysql_fetch_assoc($result_quo_items)) { ?>
			<?php $total_items = $total_items + $r_quo_items['qty']; ?>
			<tr>
				<td><?php echo $r_quo_items['product_id']; ?></td>
				<td><?php echo get_product_info($r_quo_items['product_id'], "name"); ?></td>
				<td style="text-align: center;"><?php echo $r_quo_items['qty']; ?></td>
			</tr>
		<?php } ?>
			<thead>
				<tr>
					<td>&nbsp;</td>
					<td>TOTAL</td>
					<td style="text-align: center;"><?php echo $total_items; ?></td>
				</tr>
			</thead>
		</table>
	</div>
</div>
</body>
</html>