<?php
include_once 'inc.config.php';
include_once('inc.functions.php');
include_once('inc.sanitize.php');
include_once 'geoip/geoip.inc';

$gi = geoip_open("geoip/GeoIP.dat", GEOIP_STANDARD);
$stat_country = geoip_country_name_by_addr($gi, $_SERVER['REMOTE_ADDR']);
geoip_close($gi);

if($stat_country == ''){ $stat_country = 'Localhost'; }

function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'Linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'Mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'Windows';
    }
    
	if(strstr($u_agent ,'iPad')) { 
		$platform = 'Mac / iPad';
		$browserMobile = ' (Mobile)';
	}
	
	if(strstr($u_agent ,'iPhone')) { 
		$platform = 'Mac / iPhone';
		$browserMobile = ' (Mobile)';
	}
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari' . $browserMobile; 
        $ub = "Safari" . $browserMobile; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
   	// Check For bots & Version
    if (preg_match('/compatible/i', $u_agent)) {
    	$temp1 = strstr($u_agent, 'compatible;'); // Find the word compatible
    	$temp1 = explode(';', $temp1);	// Sepearate the words
    	$temp2 = explode('/', $temp1[1]); // Separate version and name
    	
        $bname		= $temp2[0];
        $version  	= $temp2[1];
        $platform 	= "Bot";
    }
    
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
    
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
} 

$ua=getBrowser();
$yourbrowser= "Your browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'];

$section 			= sanitize($stat_section, SQL);
$identifier 		= sanitize($stat_identifier, SQL);
$request_time	 	= date('Y') . '-' . date('m') . '-' . date('d') . ' ' . date('H') . '-' . date('i') . '-' . date('s');
$country			= $stat_country;
$ip_address			= $_SERVER['REMOTE_ADDR'];
$browser_name		= $ua['name'];
$browser_version	= $ua['version'];
$platform			= $ua['platform'];
$http_referer		= $_SERVER["HTTP_REFERER"];
$customer_id		= ($_SESSION['SESS_CUS_ID']) ? sanitize($_SESSION['SESS_CUS_ID'], INT) : "0";

if($section && $identifier){
	$sql = "INSERT INTO statistics (section, identifier, request_time, country, ip_address, browser_name, browser_version, platform, http_referer, execution_time, customer_id) 
							VALUES ('$section', '$identifier', '$request_time', '$country', '$ip_address', '$browser_name', '$browser_version', '$platform', '$http_referer', '$execution_time', '$customer_id')";
	if (!($result = mysql_query ($sql))){exit ('<b>Error:</b>' . mysql_error ());}
}
?>