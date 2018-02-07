<?php session_start(); ?>
<?php 
include_once('inc.config.php'); 
include_once('inc.sanitize.php');
//
function download_file($file, $name, $mime_type='')
{
	if(!is_readable($file)) die('File not found.');
	
	$size = filesize($file);
	$name = rawurldecode($name);
	
	$known_mime_types=array(
		"pdf" => "application/pdf",
		"txt" => "text/plain",
		"html" => "text/html",
		"htm" => "text/html",
		"exe" => "application/octet-stream",
		"zip" => "application/zip",
		"doc" => "application/msword",
		"xls" => "application/vnd.ms-excel",
		"ppt" => "application/vnd.ms-powerpoint",
		"gif" => "image/gif",
		"png" => "image/png",
		"jpeg"=> "image/jpg",
		"jpg" =>  "image/jpg",
		"php" => "text/plain"
	);
	
	if($mime_type==''){
		$file_extension = strtolower(substr(strrchr($file,"."),1));
		if(array_key_exists($file_extension, $known_mime_types)){
			$mime_type=$known_mime_types[$file_extension];
		} else {
		$mime_type="application/force-download";
		};
	};
	
	@ob_end_clean(); 
	
	// required for IE, otherwise Content-Disposition may be ignored
	if(ini_get('zlib.output_compression'))
	ini_set('zlib.output_compression', 'Off');
	
	header('Content-Type: ' . $mime_type);
	//header('Content-Disposition: attachment; file="'.$name.'"');
	header("Content-disposition: attachment; filename=" . $name . "");
	header("Content-Transfer-Encoding: binary");
	header('Accept-Ranges: bytes');
	header("Cache-control: private");
	header('Pragma: private');
	readfile($file); 
}
//
if(!$_SESSION['SESS_CUS_AUTH'] && !$_SESSION['SESS_CUS_ID']){
	die("no downloads available");
}
$get_quo_id = sanitize($_GET['qr_id'], INT);
$get_cus_id = sanitize($_SESSION['SESS_CUS_ID'], INT);
//
$sql = 'SELECT * FROM quotation_request WHERE quotation_request_no = ' . $get_quo_id . ' AND customer_id = ' . $get_cus_id . ' AND status = 3 ORDER BY quotation_request_no ASC';
if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
$row_qr = mysql_fetch_assoc($result);
$count_rows = mysql_num_rows($result);
//
if($count_rows){
	$file_name = "ACE-QR-" . sanitize($row_qr['quotation_request_no'], INT) . ".pdf";
	$file_path = 'core/private/quotation/' . $file_name; // the file made availab
	download_file($file_path, $file_name, 'application/pdf');
	exit();
}else{
	die("No downloads available. QR may not be available for download.");
}
?>