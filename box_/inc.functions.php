<?php
if (! empty ($_POST))
{
	foreach ($_POST as $key => $value) { 
		$_POST [$key] = $value;
	}
	foreach ($_GET as $key => $value) { 
		$_GET [$key] = $value;
	}
}

function cleanInput($input) {
	$search = array(
	'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
	'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
	'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
	'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
	);
	
	$output = preg_replace($search, '', $input);
	return $output;
}

if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
	  if (PHP_VERSION < 6) {
		$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	  }
	  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
	  switch ($theType) {
		case "text":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;    
		case "long":
		case "int":
		  $theValue = ($theValue != "") ? intval($theValue) : "NULL";
		  break;
		case "double":
		  $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
		  break;
		case "date":
		  $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		  break;
		case "defined":
		  $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
		  break;
	  }
	  return $theValue;
	}
}
?>
<?php
function activation_mailer($to, $password) {
	$from = "admin@acemaldives.com.mv";
	// noreply password 2Pcupr00t.
	$headers = "From: " . strip_tags($from) . "\r\n";
	$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$subject = 'ACE Hardware & Home Centre Maldives Website Account Activation';
	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><style type="text/css">body{margin: 0;padding: 0;min-width: 100%!important;background-color: #EEE;}.content{font-family: Arial;font-size: 12px;width: 100%;max-width: 650px;margin: 15px auto;background-color: #FFF;border-top: 4px solid #C82C34;}.content h1{background-color: #C82C34;color: #FFF;padding: 15px 25px;margin: 0px;border-bottom: 1px solid #EEE;}.content p{padding: 15px 25px;color: #777777;line-height: 15pt;}.logo{padding: 15px 25px;margin-bottom: 5px;border-bottom: 1px dotted #CCC;}.logo .website{display: inline-block;background-color: #EEE;padding: 10px;width: 200px;margin-top: 20px;color: #C82C34;text-align: center;text-decoration: none;}.contact-info{font-size: 11px;color: #CCC;line-height: 16px;padding: 15px 25px;background-color: #444444;}.contact-info strong{color: #FFF;}.col-2{display: inline-block;width: 49%;vertical-align: top;}.col-3{display: inline-block;width: 32%;vertical-align: top;}</style></head><body><div class="content"><div class="logo"><div class="col-2"><img src="http://acehardwaremaldives.com/core/images/logo.png" width="140" alt=""/></div><div class="col-2" style="text-align: right;"><a href="#" class="website">www.acehardwaremaldives.com</a></div></div><h1>Thanks for registering to ACE Hardware & Home Centre Maldives website!</h1><p>Your account has been activated now. Just to save you a little time, you can <a href="http://acehardwaremaldives.com/myaccount/">login immediately using this link</a>. After logging in, head to your profile and update your info!<br><br><strong>Email Address: </strong>' . $to . '<bR><strong>Password: </strong>' . $password . '<bR><bR>If you have any issues during the login, please dont hesitate to contact us at +960 300 0099.<br><br>Enjoy!</p><div class="contact-info"><div class="col-3"><strong>Office Administration</strong><br>Phone: +960 300 0099<Br>Fax : +960 300 0009 <Br>Email: admin@acemaldives.com.mv</div><div class="col-3"><strong>ACE Hardware Maafannu Store</strong><br>Phone: +960 300 0033<br>Fax: +960 300 0066<br>M.Sosunmaage <br>Alhivilaa Magu, 20292 Male, Maldives <br>Email: sales@acemaldives.com.mv <br></div><div class="col-3"><strong>ACE Hardware Henveiru Store</strong><br>Phone: +960 301 0033<br>Fax: +960 301 0066<br>H.Merry Rose <br>Filigus Hingun <br>Email: sales2@acemaldives.com.mv </div></div></div></body></html>';
	
	$success = mail($to, $subject, $message, $headers);
	if (!$success){
		//echo 'SENT';
	}else{
		//echo 'NOT ';
	}
}
?>
<?php 
function generate_seo_link($input, $replace = '-', $remove_words = true, $words_array = array()) {
	$return = trim(ereg_replace(' +', ' ', preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($input))));
	if($remove_words) { $return = remove_words($return, $replace, $words_array); }
	return str_replace(' ', $replace, $return);
}
function remove_words($input,$replace,$words_array = array(),$unique_words = true)
{
	$input_array = explode(' ',$input);
	$return = array();
	foreach($input_array as $word)
	{
		if(!in_array($word,$words_array) && ($unique_words ? !in_array($word,$return) : true))
		{
			$return[] = $word;
		}
	}
	return implode($replace,$return);
}
?>
<?php 
function productsMainStats($stat){	
	if($stat == "category_online"){
		$sql = "SELECT name FROM category WHERE status = 1";
	}elseif ($stat == "category_offline") {
		$sql = "SELECT name FROM category WHERE status != 1";
	}elseif ($stat == "products_online") {
		$sql = "SELECT name FROM products WHERE status = 1";
	}elseif ($stat == "products_offline") {
		$sql = "SELECT name FROM products WHERE status != 1";
	// Active Customers & Quotations
	}elseif ($stat == "active_customers") {
		$sql = "SELECT status FROM customer WHERE status = 1";
	}elseif ($stat == "quotation_progress") {
		$sql = "SELECT status FROM quotation_request WHERE status = 1";
	}elseif ($stat == "quotation_processed") {
		$sql = "SELECT status FROM quotation_request WHERE status = 2";
	}elseif ($stat == "quotation_total") {
		$sql = "SELECT status FROM quotation_request";
	}elseif ($stat == "user_online") {
		$sql = "SELECT status FROM users WHERE status = 1";
	}elseif ($stat == "user_offline") {
		$sql = "SELECT status FROM users WHERE status = != 1";
	}elseif ($stat == "total_visits") {
		$sql = "SELECT section FROM statistics";
	}
	// user_online user_offline
	$result = mysql_query($sql);
	return mysql_num_rows($result);
}

function categorySubCount($id){	
	$sql = "SELECT name FROM category WHERE parent_a = '" . sanitize($id, INT) . "' OR parent_b = '" . sanitize($id, INT) . "' OR parent_c = '" . sanitize($id, INT) . "'";
	//
	$result = mysql_query($sql);
	return mysql_num_rows($result);
}

function promotionItemCount($promotion_id){	
	$sql = "SELECT id FROM promotion_items WHERE promotion_id = " . sanitize($promotion_id, INT);
	//
	$result = mysql_query($sql);
	return mysql_num_rows($result);
}

function statistics_monthbymonth($month){
	$start_month 	= "2014-$month-1 00:00:00";
	$end_month		= "2014-$month-31 11:59:59";
	$sql = "SELECT * FROM statistics WHERE request_time > '$start_month' AND request_time < '$end_month'";
	//
	$result = mysql_query($sql);
	return mysql_num_rows($result);
}
function statistics_groups_monthbymonth($month, $group, $section){
	$start_month 	= "2014-$month-1 00:00:00";
	$end_month		= "2014-$month-31 11:59:59";
	if($section){
		$sql = "SELECT *,COUNT(section) FROM statistics WHERE section = '$section' AND request_time > '$start_month' AND request_time < '$end_month' GROUP BY $group";
	}else{
		$sql = "SELECT * FROM statistics WHERE request_time > '$start_month' AND request_time < '$end_month' GROUP BY $group";
	}
	//
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	$row_count = $row['COUNT(section)'];
	if($row_count == 0){ $row_count = 0; }
	//
	if($section){
		return $row_count;
	}else{
		return mysql_num_rows($result);
		
	}
}
function statistics_groups_daybyday(){
	if($_GET['month']){
		$month = sanitize($_GET['month'], INT);
	}else{
		$month = date('m');
	}
	$sql = "SELECT 
			    DAY(request_time) AS DAY,
			    MONTH(request_time) AS Month,
			    YEAR(request_time) AS year,
			    COUNT( `section` ) AS Hits
			FROM 
			    statistics 
			WHERE 
			    MONTH(request_time) = $month
			GROUP BY 
			   DAY(request_time),
			   MONTH(request_time),
			   YEAR(request_time)";
	$result = mysql_query($sql);
	while($row = mysql_fetch_assoc($result)){
		$data[$row['DAY']] = $row;
	}
	return $data;
}
function statistics_popular($section){
	$sql = "SELECT *,COUNT(identifier) FROM statistics WHERE section = '$section' GROUP BY identifier ORDER BY COUNT(identifier) DESC LIMIT 5";
	//
	$result = mysql_query($sql);
	while($row = mysql_fetch_assoc($result)){
		$data[] = $row;
	}
	return $data;
}
function statistics_avgLoadingTime(){
	$sql = "SELECT AVG(execution_time) FROM statistics";
	//
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	
	return number_format($row['AVG(execution_time)'], 2);
}
?>
<?php 
function getCategoryDetails($id, $field){	
	$sql = "SELECT * FROM category WHERE id = " . sanitize($id, INT);
	//
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	return $row[$field];
}
?>
<?php 
function getCategoryDetailsByAlias($alias, $field){	
	$sql = "SELECT * FROM category WHERE alias = '" . sanitize($alias, SQL) . "'";
	//
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	return $row[$field];
}
?>
<?php 
function getUserDetails($id, $field){	
	$sql = "SELECT * FROM users WHERE id = " . sanitize($id, INT);
	//
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	return $row[$field];
}
?>
<?php 
function getProductDetails($product_id, $field){	
	$sql = "SELECT * FROM products WHERE product_id = " . sanitize($product_id, INT);
	//
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	return stripcslashes($row[$field]);
}
?>
<?php 
function getCustomerDetails($customer_id, $field){	
	$sql = "SELECT * FROM customer WHERE id = " . sanitize($customer_id, INT);
	//
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	return stripcslashes($row[$field]);
}
?>
<?php 
function checkIfBrandExists($alias){	
	$sql = "SELECT * FROM brand WHERE alias = '" . sanitize($alias, SQL) . "'";
	//
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	//return $row[$field];
	$count = mysql_num_rows($result);
	if($count == 0){
		return false;
	}else{
		return true;
	}
}
?>
<?php 
function checkIfProductExists($id){	
	$sql = "SELECT * FROM products WHERE product_id = " . sanitize($id, INT);
	//
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	//return $row[$field];
	$count = mysql_num_rows($result);
	if($count == 0){
		return false;
	}else{
		return true;
	}
}
?>
<?php
function parent_category_products_list($grand_category_id, $parent_category_id, $child_category_id , $limit, $page, $onlytotal=false) {
	$page				= sanitize($page, INT);
	$limit 				= sanitize($limit, INT);
	if($page == 1){
		$offset = 0;
	}else{
		$offset = $limit * $page;
	}
	$grand_category_id 	= sanitize($grand_category_id, INT);
	$parent_category_id = sanitize($parent_category_id, INT);
	$child_category_id 	= sanitize($child_category_id, INT);
	
	$db_data = array();
	
	if($grand_category_id && !$parent_category_id && !$child_category_id){
		$sql_get_sub_cats = "SELECT * FROM category WHERE status = 1 AND (parent_a = $grand_category_id OR parent_b = $grand_category_id OR parent_c = $grand_category_id) ORDER BY name ASC";
		$result_get_sub_cats = mysql_query ($sql_get_sub_cats);
		while($r_get_sub_cats = mysql_fetch_assoc($result_get_sub_cats)) {
			$add_to_sql .= ' OR child_category_1 = ' . $r_get_sub_cats["id"] . ' OR child_category_2 = ' . $r_get_sub_cats["id"];
		}
		
		$sql = "SELECT * FROM products WHERE status = 1 AND parent_category = $grand_category_id $add_to_sql ORDER BY name ASC LIMIT $offset, $limit";
		$sql_count = "SELECT * FROM products WHERE status = 1 AND parent_category = $grand_category_id $add_to_sql ";
		//echo $sql;
	}elseif ($grand_category_id && $parent_category_id && !$child_category_id) {
		$sql = "SELECT * FROM products WHERE status = 1 AND child_category_1 = $parent_category_id ORDER BY name ASC LIMIT  $offset, $limit";
		$sql_count = "SELECT * FROM products WHERE status = 1 AND child_category_1 = $parent_category_id ";
		
	}elseif ($grand_category_id && $parent_category_id && $child_category_id) {
		$sql = "SELECT * FROM products WHERE status = 1 AND child_category_2 = $child_category_id ORDER BY name ASC LIMIT  $offset, $limit";
		$sql_count = "SELECT * FROM products WHERE status = 1 AND child_category_2 = $child_category_id ";
	}
	
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	if (!($result_count = mysql_query ($sql_count))){exit ('<b>Error:</b>' . mysql_error ());}
	
	$total_rows = mysql_num_rows($result_count);
	
	while($r = mysql_fetch_assoc($result)) {
		$db_data[] = $r;
	}
	
	//echo $sql;
	if($onlytotal){
		return $total_rows;
	}else{
		return '{"products": ' . json_encode($db_data) . '}';
	}
}
?>
<?php 
function activityMonitor($user_id, $activity_title, $activity, $module){
	//'9999-12-31 23:59:59'.
	$user_id 		= GetSQLValueString($user_id, "int");
	$activity_title = GetSQLValueString(sanitize($activity_title,SQL), "text");
	$activity	 	= GetSQLValueString($activity, "text");
	$module		 	= GetSQLValueString($module, "text");
	$datetime	 	= date('Y') . '-' . date('m') . '-' . date('d') . ' ' . date('H') . '-' . date('i') . '-' . date('s');
	
	$insert_qry = "INSERT INTO activity (user_id, activity_title, activity, module, datetime) 
								 VALUES ($user_id, $activity_title, $activity, $module, '$datetime')";
							
	if(mysql_query($insert_qry)){
	}
}
?>
<?php 
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>
<?php 
function page_numbers($current, $total, $sep = ' &hellip; ', $modulus = 8, $leading = 3, $trailing = 3, $page_url) { 
	//
    //$link = '<a href="?page=%1$s">%1$s</a>';
    $link = '<li><a href="' . $page_url . '%1$s">%1$s</a></li>';
    //$current_page = '<strong>%1$s</strong>'; 
	$current_page = '<li class="active"><a href="' . $page_url . '%1$s/">%1$s</a></li>';
	
    if ($modulus && $total > ($modulus + $leading + $trailing)) { 
         
        $half = intval($modulus / 2); 
         
        $end = $current + $half; 
        if ($end > $total) { 
            $end = $total; 
        } 
         
        $start = $current - ($modulus - ($end - $current)); 
        if ($start <= 1) { 
            $start = 1; 
            $end = $current + ($modulus  - $current) + 1; 
        } 
         
        $out = range($start, $end); 
         
        $lead = array(); 
        if ($start <= $leading) { 
            if ($leading > ($start - $leading)) { 
                for ($i = $start - 1; $i > 0; $i--) { 
                    array_unshift($out, $i); 
                } 
                if (count($out) < ($modulus + $leading)) { 
                    $out = array_merge($out, range($end + 1, $end + $modulus + $leading - count($out) + 1)); 
                } 
            } 
        } else { 
            for ($i = 1; $i <= $leading; $i++) { 
                $lead[] = sprintf($link, $i); 
            } 
        } 
         
        $trail = array(); 
        if ($trailing >= ($total - $end)) { 
            for ($i = $end + 1; $i <= $total; $i++) { 
                array_push($out, $i); 
            } 
            if (count($out) < ($modulus + $trailing)) { 
                $out = array_merge(range($start - 1 - ($modulus + $trailing - count($out)), $start - 1), $out); 
            } 
        } else { 
            for ($i = ($total - $trailing + 1); $i <= $total; $i++) { 
                $trail[] = sprintf($link, $i); 
            } 
        } 
         
        foreach ($out as &$item) { 
            $item = $item == $current ? sprintf($current_page, $item) : sprintf($link, $item); 
        } 
         
        $ret = array_filter(array($lead, $out, $trail)); 
         
        foreach ($ret as &$item) { 
            $item = implode(' ', $item); 
        } 
         
        return implode($sep, $ret); 

    } else { 
        $ret = ''; 
        for ($i = 1; $i <= $total; $i++) { 
            $ret .= $i == $current ? sprintf($current_page, $i) : sprintf($link, $i);
            $ret .= ' '; 
        } 
        return trim($ret); 
    } 
}
?>