<?php session_start(); ?>
<?php
//if(!$_SESSION['SESS_CUS_AUTH']){
//	die();
//}
include_once('inc.config.php'); 
include_once('inc.functions.php');
include_once('inc.sanitize.php');
require_once("dompdf/dompdf_config.inc.php");
$dompdf = new DOMPDF();

$get_quotion_id = sanitize($_GET['id'], INT);

$sql_quo = 'SELECT * FROM quotation_request WHERE quotation_request_no = ' . $get_quotion_id;
if (!($result_quo = mysql_query ($sql_quo))){exit ('<b>Error:</b>' . mysql_error ());}
$r_quo = mysql_fetch_assoc($result_quo);
if(mysql_num_rows($result_quo) == 0){
	die("Invalid QR number");
}

$message = '<html><head><title>Template</title><link href="<?php echo $wwwroot_css; ?>/bootstrap.min.css" rel="stylesheet"></head><body>';
$message .= '
<style>
@page {
  margin: 2cm 2cm;
}
*{ margin: 0; padding: 0; text-decoration: none; }
body{
	font-family: "Open Sans", sans-serif;
	font-weight: 300;
	font-size: 12px;
	background-color: #EEE;
}
.website_header{
	width: 600px;
	margin: 0px auto;
	padding-top: 10px;
	text-align: right;
}
.quo{
	width: 600px;
	position: relative;
	/*min-height: 95%;*/
	margin: 15px auto;
	background-color: #FFF;
	border-left: 15px solid #C82C34;
	border-right: 1px solid #EEE;
}
.heading{
	padding-bottom: 15px;
}
	.heading h1{
		margin-left: 20px;
		color: #C82C34;
		font-weight: 300;
		margin-bottom: 10px;
	}
	.heading .logo{
		margin-top: 20px;
		margin-left: 20px;
	}
	.heading span{
		color: #888;
		font-size: 12px;
		margin-left: 20px;
		margin-right: 50px;
		font-weight: 400;
	}
	
.company_info{
	border-top: 1px solid #EEE;
}
	.company_info table{
		background-color: #F7F7F7;
	}
	.company_info table tr td.title{
		font-weight: 600;
		width: 150px;
		color: #999;
	}
	.company_info table tr td{
		font-size: 12px;
		padding:10px 20px;
		border-bottom: 1px solid #EEE;
	}
.quotation_items{
	padding: 20px;
	border-bottom: 1px solid #EEE;
}
	.quotation_items .table{
		font-size: 12px;
		margin: 0px;
	}
	.quotation_items .table tr td{
		border: none;
		border-bottom: 1px solid #EEE;
		font-size: 12px;
		font-weight: 300;
	}
	.quotation_items .table thead tr td{
		color: #888;
		font-size: 12px;
		font-weight: 300;
	}
</style>';
$message .= '<div class="website_header">www.acehardwaremaldives.com</div>';
$message .= '<div class="quo"><div class="company_info"><div class="row"><div class="col-xs-12 heading"><h1>Quotation Request</h1><span>ACE/QR/' . $r_quo["quotation_request_no"] . '</span><span>' . $r_quo["date"] . '</span></div></div></div>';
//$message 	.= '<div class="company_info">'
//			.	'<table cellpadding="0" cellspacing="0" width="100%">'
//			.		'<tr><td>SSS</td></tr>'
//			. 	'</table>' 
//			. '</div>';

$message .= '</body></html>';
$dompdf->load_html($message);
$dompdf->set_paper("a4", "portrait");
$dompdf->render();
$filename = "quo.pdf";  
$dompdf->stream($filename, array("Attachment" => false));
exit(0);
?>