<?php
include_once '../inc.config.php'; 
if (!$_GET['id'])
{
	$_GET['id'] = $_POST['id'];
}
if (!($result_editor = mysql_query ('' . 'SELECT * FROM invoice WHERE id=' . $_GET['id'])))
{
	$feedback_er .=  mysql_error();
}
$row = mysql_fetch_array ($result_editor);
?>
<html>
<head>
<title>Template</title>
<style type="text/css">
*{
	margin: 0; padding: 0;
}
body{
	margin: 0; padding: 0;
	font-family: "helvetica";
	font-weight: light;
}
h1{
	color: #8AC4B3;
	font-size: 48px;
	text-align: right;
	font-weight: normal;
}
h2{
	color: #8AC4B3;
	font-size: 21px;
	text-align: left;
	font-weight: normal;
}
h3{
	color: #8AC4B3;
	font-size: 18px;
	text-align: right;
	font-weight: normal;
}
h4{
	color: #999;
	font-size: 11px;
	font-weight: normal;
	z-index: 300;
	position: absolute;
	bottom: 0;
	right: 0;padding: 5px;
	background-color: #FFF;
}
.page{
	width: 700px;
	margin: 40px;
	position: absolute;
}

hr{
	width: 100%;
	border: none;
	border-bottom: 1px solid #e1e0e2;
}
span{
	color: #8AC4B3;
}
table{
	z-index: 200;
}
table tr td{
	vertical-align: top;
}
.tophead{
	font-size: 13px;
	color: #6D6E71;
}
	.tophead td{
		vertical-align: top;
	}
.contents{
	font-size: 12px;
	line-height: 18px;
	color: #6D6E71;
	padding: 10px 0px;
}
.amount{
	background-color: #EEE;
}
	.amount td{
		padding-right: 15px;
	}
.terms{
	color: #999;
	font-size: 11px;
	line-height: 16px;
}
	.terms p{
		padding: 10px 0px;
	}

.title{
	position: absolute;
	bottom: 200px;
	font-size: 32px;
	text-align: center;z-index: 100;
}
	.title span{
		font-size: 14px;
		color: #6D6E71;
		
	}

.bgdesign{
	background-image: url('bg.jpg');
	background-position: bottom;
	position: absolute;
	bottom: 0;
	right: 0;
	height: 500px;
	width: 100%;
	color: #FFF;
	z-index: 0;
}
.date{
	font-size: 11px;
	color: #999;
}
</style>
</head>
<body>
<div class="page">
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td colspan="2" style="height: 90px;" class="date"><?php echo $row['inv_date']; ?></td>
			<td colspan="2" style="height: 90px;"><h1>Invoice</h1></td>
		</tr>
		<tr class="tophead">
			<td style="width: 25px;"><span>job : </span></td>
			<td style="width: 160px; text-align: right;"><?php echo $row['job']; ?></td>
			<td style="width: 300px;text-align: center;"><span>client : </span><?php echo $row['client']; ?></td>
			<td style="width: 160px; text-align: right;">
				<span>inv #: </span><?php echo $row['inv_no']; ?><br>
				<span>TIN: 40695GST01</span>
			</td>
		</tr>
		<tr><td colspan="4" style="height: 50px; vertical-align: bottom;"><h2>Services</h2></tr>
		<tr><td colspan="4" style="height: 15px; vertical-align: bottom;"><hr></td></tr>
		<tr><td colspan="4">
			<div class="contents">
				<?php echo $row['services']; ?>
			</div>
		</td></tr>
		<tr><td colspan="4" style="height: 15px; vertical-align: bottom;"><hr></td></tr>
		<tr class="amount">
			<td colspan="2"></td>
			<td><h3 style="color: #6D6E71;"><?php echo $row['amount_title']; ?></h3></td>
			<td><h3><?php echo $row['currency']; ?> <?php echo $row['amount_mvr']; ?></h3></td>
		</tr>
		<tr class="amount">
			<td colspan="2"></td>
			<td><h3 style="color: #6D6E71;">GST 6%</h3></td>
			<td><h3><?php echo $row['currency']; ?> <?php echo $row['gst']; ?></h3></td>
		</tr>
		<tr class="amount">
			<td colspan="2"></td>
			<td><h3 style="color: #6D6E71;">Total</h3></td>
			<td><h3><?php echo $row['currency']; ?> <?php echo $row['totalamount']; ?></h3></td>
		</tr>
		<tr class="amount"><td colspan="4" style="text-align: right;"><span>(<?php echo $row['amount_in_words']; ?>)</span></td></tr>
		<tr><td colspan="4" style="height: 12px; vertical-align: bottom; background-color: #EEE;"><hr></td></tr>
		<tr class="terms"><td colspan="3"><p><?php echo $row['invoice_terms']; ?></p></td><td></td></tr>
	</table>
	
	<h1 class="title">Lemorios Designs <br><span>Simple. Elegant. Surprising. Intuitive</span></h1>
	<div class="bgdesign">H</div>
	<h4> www.lemorios.com </h4>
</div>
</body>
</html>