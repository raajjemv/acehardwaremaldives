<?php
function store_category() {
	// require_once("phpfastcache/phpfastcache.php");
	// $cache = phpFastCache("auto");
	// $data  = $cache->get("store_category");
	// //check if data is available
	// if($data != null) {
		$db_data = array();
		$sql1 = "SELECT id,name,alias,parent_a FROM category WHERE status = 1 AND parent_a = 0000 ORDER BY order_no ASC";
		if (!($result1 = mysql_query ($sql1))){exit ('<b>Error:</b>' . mysql_error ());}
		$i = 0;
		while($r1 = mysql_fetch_assoc($result1)) {
			$i++;
			$j = 0;
			$top_category_id = $r1['id'];
			
			$sql2 = "SELECT id,name,alias,parent_a FROM category WHERE 	status = 1 AND 
																		parent_a = '" . $top_category_id . "' OR 
																		parent_b = '" . $top_category_id . "' OR 
																		parent_c = '" . $top_category_id . "' ORDER BY name ASC";
			if (!($result2 = mysql_query ($sql2))){exit ('<b>Error:</b>' . mysql_error ());}
			
			$db_data[$i]["id"] 		= $r1['id'];
			$db_data[$i]["name"] 	= $r1['name'];
			$db_data[$i]["alias"] 	= $r1['alias'];
			
			while($r2 = mysql_fetch_assoc($result2)) {
				$j++;
				$k = 0;
				$middle_category_id = $r2['id'];
				
				$sql3 = "SELECT id,name,alias,parent_a FROM category WHERE 	status = 1 AND 
																			parent_a = '" . $middle_category_id . "' OR 
																			parent_b = '" . $middle_category_id . "' OR 
																			parent_c = '" . $middle_category_id . "' ORDER BY name ASC";
				if (!($result3 = mysql_query ($sql3))){exit ('<b>Error:</b>' . mysql_error ());}
				
				$db_data[$i]["children"][$j]["id"] 		= $r2['id'];
				$db_data[$i]["children"][$j]["name"] 	= $r2['name'];
				$db_data[$i]["children"][$j]["alias"] 	= $r2['alias'];
				
				while($r3 = mysql_fetch_assoc($result3)) {
					$k++;
					$db_data[$i]["children"][$j]["grand_children"][$k]["id"] 	= $r3['id'];
					$db_data[$i]["children"][$j]["grand_children"][$k]["name"] 	= $r3['name'];
					$db_data[$i]["children"][$j]["grand_children"][$k]["alias"] = $r3['alias'];
				}
			}
		}
		//set the cache for 10 minutes
	// 	$cache->set("store_category",$db_data, 600);
	// }//if($data == null) {
	// $data = $cache->get("store_category");
	return '{"store_category": ' . json_encode($db_data) . '}';
}

function main_category_menu() {
	// require_once("phpfastcache/phpfastcache.php");
	// $cache = phpFastCache();
	// $data  = $cache->get("main_category_menu");
	
	// if($data == null) {
		$db_data = array();
		$sql = "SELECT id,name,alias,parent_a FROM category WHERE status = 1 AND parent_a = 0000 ORDER BY order_no ASC";
		if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
		while($r = mysql_fetch_assoc($result)) {
			$db_data[] = $r;
		}
		//$cache->set("main_category_menu",$db_data , 600);
//	}
	//$data  = $cache->get("main_category_menu");
	return '{"main_category_menu": ' . json_encode($db_data) . '}';
}

function home_products_list($limit) {
	// require_once("phpfastcache/phpfastcache.php");
	// $cache = phpFastCache();
	// $data  = $cache->get("home_products_list");
	
	// if($data == null) {
		$db_data = array();
		//$sql = "SELECT *,id * RAND() AS random_no FROM products WHERE status = 1 ORDER BY RAND()";
		$sql = "SELECT * FROM products WHERE status = 1 ORDER BY id DESC";
		if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
		while($r = mysql_fetch_assoc($result)) {
			$db_data[] = $r;
		}
	// 	$cache->set("home_products_list",$db_data , 60);
	// }
	// $data  = $cache->get("home_products_list");
	return '{"products": ' . json_encode($db_data) . '}';
}

function home_redhot_list($limit) {
	// require_once("phpfastcache/phpfastcache.php");
	// $cache = phpFastCache();
	// $data  = $cache->get("home_redhot_list");
	
	// if($data == null) {
		$db_data = array();
		$sql = 'SELECT *, promotions.id FROM promotions INNER JOIN promotion_items ON promotion_items.promotion_id = promotions.id WHERE promotions.status = 1 AND promotions.type = 1 AND DATE(now()) BETWEEN DATE(promotions.start_date) AND DATE(promotions.end_date) ORDER BY RAND()';
		if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
		while($r = mysql_fetch_assoc($result)) {
			$db_data[] = $r;
		}
	// 	$cache->set("home_redhot_list",$db_data , 60);
	// }
	// $data  = $cache->get("home_redhot_list");
	return '{"products": ' . json_encode($db_data) . '}';
}

function home_featured_list($limit) {
	// require_once("phpfastcache/phpfastcache.php");
	// $cache = phpFastCache();
	// $data  = $cache->get("home_featured_list");
	
	// if($data == null) {
		$db_data = array();
		$sql = 'SELECT *, promotions.id FROM promotions INNER JOIN promotion_items ON promotion_items.promotion_id = promotions.id WHERE promotions.status = 1 AND promotions.type = 2 AND DATE(now()) BETWEEN DATE(promotions.start_date) AND DATE(promotions.end_date) ORDER BY RAND()';
		if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
		while($r = mysql_fetch_assoc($result)) {
			$db_data[] = $r;
		}
	// 	$cache->set("home_featured_list",$db_data , 60);
	// }
	// $data  = $cache->get("home_featured_list");
	return '{"products": ' . json_encode($db_data) . '}';
}

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

function get_search_results($keyword, $limit, $page, $onlytotal=false) {
	$db_data = array();
	// PAGINATION
	$page	= sanitize($page, INT);
	$limit 	= sanitize($limit, INT);
	if($page == 1){
		$offset = 0;
	}else{
		$offset = $limit * $page;
	}
	// SEARCH KEYWORD
	$keyword = sanitize($keyword, SQL);
	$values = explode(' ', $keyword);
	$keyword_sql = '';
	
	if($keyword){
		foreach($values as $v){
			$v = sanitize(trim($v), SQL);
			$keyword_sql .= 'AND (name LIKE "%' . $v . '%" OR  description LIKE "%' . $v . '%")';
		}
	}
	
	//$sql = 'SELECT * FROM products WHERE status = 1 AND name LIKE "%' . $keyword . '%" OR product_id LIKE "%' . $keyword . '%" LIMIT ' . $offset . ',' . $limit;
	//$sql_count = 'SELECT * FROM products WHERE status = 1 AND name LIKE "%' . $keyword . '%" OR product_id LIKE "%' . $keyword . '%"';
	$sql = 'SELECT * FROM products WHERE status = 1 ' . $keyword_sql . ' OR product_id LIKE "%' . $keyword . '%" LIMIT ' . $offset . ',' . $limit;
	$sql_count = 'SELECT * FROM products WHERE status = 1 ' . $keyword_sql . ' OR product_id LIKE "%' . $keyword . '%"';
		
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	if (!($result_count = mysql_query ($sql_count))){exit ('<b>Error:</b>' . mysql_error ());}
	
	$total_rows = mysql_num_rows($result_count);
	
	while($r = mysql_fetch_assoc($result)) {
		$db_data[] = $r;
	}
	
	//echo $sql;
	//echo $sql;
	if($onlytotal){
		return $total_rows;
	}else{
		return '{"products": ' . json_encode($db_data) . '}';
	}
}

function get_product_info($product_id, $field) {
	$product_id = sanitize($product_id, FLOAT);
	$sql = 'SELECT * FROM products WHERE status = 1 AND product_id = ' . $product_id;
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	$r = mysql_fetch_assoc($result);
	return stripslashes($r[$field]);
}

function get_web_settings($field) {
	$sql = 'SELECT * FROM settings LIMIT 1';
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	$r = mysql_fetch_assoc($result);
	return stripslashes($r[$field]);
}

function get_page_info($page_id, $field) {
	$page_id = sanitize($page_id, SQL);
	$sql = 'SELECT * FROM pages WHERE status = 1 AND alias = "' . $page_id . '"';
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	$r = mysql_fetch_assoc($result);
	return stripslashes($r[$field]);
}

function get_category_info($cat_id, $field) {
	$cat_id = sanitize($cat_id, INT);
	$sql = 'SELECT * FROM category WHERE status = 1 AND id = ' . $cat_id;
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	$r = mysql_fetch_assoc($result);
	return stripslashes($r[$field]);
}

	function get_category_info_by_alias($cat_alias, $field) {
		$cat_alias = sanitize($cat_alias, SQL);
		$sql = 'SELECT * FROM category WHERE status = 1 AND alias = "' . $cat_alias . '"';
		if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
		$r = mysql_fetch_assoc($result);
		return stripslashes($r[$field]);
	}
	
function get_customer_info($customer_id, $field) {
	$customer_id = sanitize($customer_id, INT);
	$sql = 'SELECT * FROM customer WHERE status = 1 AND id = ' . $customer_id;
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	$r = mysql_fetch_assoc($result);
	return stripslashes($r[$field]);
}

function get_latest_quotation_request_no() {
	$sql = 'SELECT * FROM quotation_request ORDER BY id DESC';
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	$r = mysql_fetch_assoc($result);
	return $r['id'] + 1;
}
function count_quotation_items($q_id) {
	$q_id = sanitize($q_id, INT);
	
	$sql = 'SELECT * FROM quotation_requested_items WHERE quotation_request_no = ' . $q_id;
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	$r = mysql_fetch_assoc($result);
	return mysql_num_rows($result);
}
function count_wishlist() {
	$customer_id = sanitize($_SESSION['SESS_CUS_ID'], INT);
	
	$sql = 'SELECT * FROM wishlist WHERE customer_id = ' . $customer_id;
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	$r = mysql_fetch_assoc($result);
	return mysql_num_rows($result);
}

function checkRedHot($product_id){
	$today = date('Y-m-d');
	$product_id = sanitize($product_id, INT);
	//
	//$sql = 'SELECT * FROM promotions WHERE status = 1 AND type = 1 AND product_id = ' . $product_id;
	
	$sql = 'SELECT *, promotions.id FROM promotions INNER JOIN promotion_items ON promotion_items.promotion_id = promotions.id WHERE promotions.status = 1 AND promotions.type = 1 AND promotion_items.product_id = ' . $product_id . ' AND DATE(now()) BETWEEN DATE(promotions.start_date) AND DATE(promotions.end_date)';
	
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
	//
	$total_rows = mysql_num_rows($result);
	//
	//echo $sql;
	if($total_rows != 0){
		return '<span class="red-hot-item">RED HOT BUY</span>';
	}else{
		return '';
	}
}
// UTILITY FUNCTIONS
function randomPassword($length = 8) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);
}

function dateDiff($time1, $time2, $precision = 6) {
// If not numeric then convert texts to unix timestamps
	if (!is_int($time1)) {
		$time1 = strtotime($time1);
	}
	if (!is_int($time2)) {
		$time2 = strtotime($time2);
	}
	
	// If time1 is bigger than time2
	// Then swap time1 and time2
	if ($time1 > $time2) {
		$ttime = $time1;
		$time1 = $time2;
		$time2 = $ttime;
	}
	
	// Set up intervals and diffs arrays
	$intervals = array('year','month','day','hour','minute','second');
	$diffs = array();
	
	// Loop thru all intervals
	foreach ($intervals as $interval) {
		// Create temp time from time1 and interval
		$ttime = strtotime('+1 ' . $interval, $time1);
		// Set initial values
		$add = 1;
		$looped = 0;
		// Loop until temp time is smaller than time2
		while ($time2 >= $ttime) {
			// Create new temp time from time1 and interval
			$add++;
			$ttime = strtotime("+" . $add . " " . $interval, $time1);
			$looped++;
		}
		
		$time1 = strtotime("+" . $looped . " " . $interval, $time1);
		$diffs[$interval] = $looped;
	}
	
	$count = 0;
	$times = array();
	// Loop thru all diffs
	foreach ($diffs as $interval => $value) {
		// Break if we have needed precission
		if ($count >= $precision) {
			break;
		}
		// Add value and interval 
		// if value is bigger than 0
		if ($value > 0) {
			// Add s if value is not 1
			if ($value != 1) {
				$interval .= "s";
			}
			// Add value and interval to times array
			$times[] = $value . " " . $interval;
		$count++;
		}
	}
	
	// Return string with times
	return implode(" ", $times);
}

function word_limit($str,$no_of_words)
{ 
	$str = strip_tags($str);
	$wordlimitv2 = '';
	$str_array = split(" ",$str,$no_of_words+1);
	if(count($str_array)>$no_of_words) { 
		for($i=0; $i < $no_of_words; $i++) 
		{
			$wordlimitv2 .= $str_array[$i]." "; 
		} 
		return $wordlimitv2 . "...";
	} else { 
		return $str; 
	}
}

function dateFormater($date) {
	$result = strtotime($date);
	return(date('d F Y',$result));
}

function notification_mailer($to, $subject, $message_recieved) {
	$from = "code@meemoinc.com";
	// noreply password 2Pcupr00t.
	$headers = "From: " . strip_tags($from) . "\r\n";
	$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	$message = '<html><link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,300" rel="stylesheet" type="text/css"><link href="http://weloveiconfonts.com/api/?family=entypo" rel="stylesheet" type="text/css"><body>';
	$message .= '<style>@import url(http://weloveiconfonts.com/api/?family=entypo);*{text-decoration:none;margin:0;padding:0;}[class*=entypo-]:before{font-family:entypo, sans-serif;}body{font-family:"Open Sans", sans-serif;font-weight:300;background-color:#efefef;}.message_box{max-width:500px; margin: 25px 0px; display:inline-block;/*position:absolute;left:50%;top:10%;margin-left:-250px;*/color:#FFF;text-align:center;background-color:#C82C34;padding:15px 0;}.message_box h1{font-size:15px;margin-bottom:15px; color: #FFF; }.message_box p{font-size:12px;}.spiner1{font-size:42px;display:inline-block; color: #FFF; }.message{color:#888;background-color:#FFF;padding:15px;}.url{color:rgba(255,255,255,.65);padding:5px;}</style>';
	
	$message .= '<div style="text-align: center; "><div class="message_box"><span class="entypo-lamp spiner1"></span><h1>Ace Hardware Website Notification</h1>';
	
	$message .= '<p class="message">' . $message_recieved . '</p>';
	
	$message .= '<p class="url">www.acehardwaremaldives.com</p></div><div>';
	
	$message .= '</body></html>';
	
	$success = mail($to, $subject, $message, $headers);
	if (!$success){
	}
}

function welcome_mailer($to) {
	$from = "admin@acemaldives.com.mv";
	// noreply password 2Pcupr00t.
	$headers = "From: " . strip_tags($from) . "\r\n";
	$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$subject = 'Welcome to ACE Hardware & Home Centre Maldives website';
	$message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><style type="text/css">body{margin: 0;padding: 0;min-width: 100%!important;background-color: #EEE;}.content{font-family: Arial;font-size: 12px;width: 100%;max-width: 650px;margin: 15px auto;background-color: #FFF;border-top: 4px solid #C82C34;}.content h1{background-color: #C82C34;color: #FFF;padding: 15px 25px;margin: 0px;border-bottom: 1px solid #EEE;}.content p{padding: 15px 25px;color: #777777;line-height: 15pt;}.logo{padding: 15px 25px;margin-bottom: 5px;border-bottom: 1px dotted #CCC;}.logo .website{display: inline-block;background-color: #EEE;padding: 10px;width: 200px;margin-top: 20px;color: #C82C34;text-align: center;text-decoration: none;}.contact-info{font-size: 11px;color: #CCC;line-height: 16px;padding: 15px 25px;background-color: #444444;}.contact-info strong{color: #FFF;}.col-2{display: inline-block;width: 49%;vertical-align: top;}.col-3{display: inline-block;width: 32%;vertical-align: top;}</style></head><body><div class="content"><div class="logo"><div class="col-2"><img src="http://acehardwaremaldives.com/core/images/logo.png" width="140" alt=""/></div><div class="col-2" style="text-align: right;"><a href="#" class="website">www.acehardwaremaldives.com</a></div></div><h1>Welcome to ACE Hardware & Home Centre Maldives website.</h1><p>You can browse through our wide range of products and also create catalogues by selecting the items you prefer. Registered customers can request for quotations and enjoy other several benefits such as downloading our credit application form.<br><br>Thank you.</p><div class="contact-info"><div class="col-3"><strong>Office Administration</strong><br>Phone: +960 300 0099<Br>Fax : +960 300 0009 <Br>Email: admin@acemaldives.com.mv</div><div class="col-3"><strong>ACE Hardware Maafannu Store</strong><br>Phone: +960 300 0033<br>Fax: +960 300 0066<br>M.Sosunmaage <br>Alhivilaa Magu, 20292 Male, Maldives <br>Email: sales@acemaldives.com.mv <br></div><div class="col-3"><strong>ACE Hardware Henveiru Store</strong><br>Phone: +960 301 0033<br>Fax: +960 301 0066<br>H.Merry Rose <br>Filigus Hingun <br>Email: sales2@acemaldives.com.mv </div></div></div></body></html>';
	
	$success = mail($to, $subject, $message, $headers);
	if (!$success){
		echo 'SENT';
	}else{
		echo 'NOT ';
	}
}

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

function page_numbers($current, $total, $sep = ' &hellip; ', $modulus = 8, $leading = 3, $trailing = 3, $page_url) { 
	//
    //$link = '<a href="?page=%1$s">%1$s</a>';
    $link = '<li><a href="' . $page_url . '%1$s/">%1$s</a></li>';
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