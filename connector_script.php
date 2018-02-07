<?php

$hash = "3876649d63f07e2260c7df5fc55b6ca32e6faed8";

class Systeminfo {

	function getServiceStatus($checkservices) {
		$services = array();
		$errno = false; $errstr = false; $timeout = 1;
		if(isset($checkservices) && !empty($checkservices)) {
			foreach($checkservices as $name => $port) {
				$fp = fsockopen("localhost", $port, $errno, $errstr, $timeout); 
				if (!$fp) { 
					$services[$name] = "Offline"; 
				} else { 
					$services[$name] = "Online"; 
				} 
				fclose($fp); 
			}
		}
		return $services;
	}
    function formatspeed($bytes)    {
        $labels = array('B/s','KB/s','MB/s','GB/s','TB/s');
        for($x = 0; $bytes >= 1024 && $x < (count($labels) - 1); $bytes /= 1024, $x++); 
        return round($bytes, 1).$labels[$x];
    }
    function time_ago($date,$timestamp=false,$diff=true, $granularity=2) {
        $date = $timestamp===true ? $date : strtotime($date);
        $difference = ($diff === true) ? (time() - $date) : $date;
        $retval = '';
        $periods = array('decade' => 315360000,
            'year' => 31536000,
            'month' => 2628000,
            'week' => 604800, 
            'day' => 86400,
            'hour' => 3600,
            'minute' => 60,
            'second' => 1);
                                     
        foreach ($periods as $key => $value) {
            if ($difference >= $value) {
                $time = floor($difference/$value);
                $difference %= $value;
                $retval .= ($retval ? ' ' : '').'<span>'.$time.'</span>'.' ';
                $retval .= (($time > 1) ? $key.'s' : $key);
                $granularity--;
            }
            if ($granularity == '0') { break; }
        }
        return $retval;      
    }

}


class Linuxinfo extends Systeminfo {
    var $ldir = "/proc";
    
    function getCpuInfo() {
        return $this->parsefile($this->ldir."/cpuinfo");
    }
    
    function getMemStat() {
        return $this->parsefile($this->ldir."/meminfo");
    }
    
    function getUptime() {
        //GET SERVER LOADS 
		$loadresult = @exec('uptime');  
		preg_match("/averages?: ([0-9\.]+),[\s]+([0-9\.]+),[\s]+([0-9\.]+)/",$loadresult,$avgs); 
		
		//GET SERVER UPTIME 
		$uptime = explode(' up ', $loadresult); 
		$uptime = explode(',', $uptime[1]); 
		$uptime = $uptime[0].', '.$uptime[1]; 
		return array("load" => $avgs[1].", ".$avgs[2].", ".$avgs[3], "uptime" => $uptime);
    }
		    
    function countProcesses() {
        $processes = shell_exec("ps ax -o stat,args |wc -l");
        if (strtolower(substr(PHP_OS, 0, 3)) !== 'win') return $processes;
        else return 0;
    }

    function parsefile($file) {
        //$content = file_get_contents($file);
        $content = shell_exec("cat ".$file);
        $info=array();
        foreach( explode("\n",$content) as $line) {
            $pos = strpos($line,":");
            $key = trim( substr($line,0,$pos) );
            $val = trim( substr($line,$pos+1) );
            if ( $key=="") continue;
            $info[$key] = $val;
        }
        return $info;        
    }
	
	// Not used for now, but maybe in the future
    function getCurrentSpeed($port) {
        $start = $this->parsefile($this->ldir."/net/dev");
        sleep(3);
        $end = $this->parsefile($this->ldir."/net/dev");
        if(empty($start)) return array("rx" => "Could not process", "tx" => "Could not process");
        $interfaces = array_keys($start);
        if(!empty($start[$port])) {
            $startoutput = preg_replace('!\s+!', ' ', $start[$port]);
            $endoutput = preg_replace('!\s+!', ' ', $end[$port]);
            $startspeeds = explode(" ", trim($startoutput));
            $endspeeds = explode(" ", trim($endoutput));
            return array("rx" => round(($endspeeds[0]-$startspeeds[0])/3,0), "tx" => round(($endspeeds[8]-$startspeeds[8])/3,0), "interfaces" => $interfaces);
        } else return array("rx" => "Invalid port", "tx" => "Invalid port", "interfaces" => $interfaces);
    }
	
}

class Wininfo extends Systeminfo {
    
    function getCpuInfo() {
        exec("wmic cpu get name", $output);
        return array("model name" => $output[1]);
    }
    
    function getMemStat() {
        exec("wmic ComputerSystem get TotalPhysicalMemory && wmic OS get FreePhysicalMemory", $output);
        return array("MemTotal" => $output[1]/1024, "MemFree" => $output[4], "Buffers" => 0, "Cached" => 0);
    }
    
    public function getUptime()
    {
        exec("wmic cpu get loadpercentage", $load);
        exec("net statistics Workstation", $uptime);
        if(isset($uptime) && !empty($uptime)) {
            $uptime = $uptime[3];
            $uptime = str_replace("Statistics since", "", $uptime);
            $uptime = trim($uptime);
            $parts = explode("/", $uptime);
            $extra = explode(" ", $parts[2]);
            $newuptime = strtotime($extra[0]."-".$parts[1]."-".$parts[0]." ".$extra[1]);
            $uptime = $this->time_ago($newuptime, true, true);
        } else $uptime = "";
        $loadamount = (isset($load[1]) && !empty($load[1])) ?  $load[1]."%" : "";
        return array("load" => $loadamount, "uptime" => $uptime);

    }
	    
    function countProcesses() {
        exec("wmic process get name", $output);
        return (count($output)-5);
    }

}


if(isset($_GET["hash"]) && !empty($_GET["hash"])) {
    if($_GET["hash"] == $hash) {
		if (strtolower(substr(PHP_OS, 0, 3)) === 'win') {
			$stats = new Wininfo;
		} else {
			$stats = new Linuxinfo;
		}
        if($_GET["type"] == "register") {
			$_SERVER["SERVER_ADDR"] = (isset($_SERVER["SERVER_ADDR"]) && !empty($_SERVER["SERVER_ADDR"])) ? $_SERVER["SERVER_ADDR"] : $_SERVER["LOCAL_ADDR"];
            $output["ip"] = sprintf("%u", ip2long($_SERVER["SERVER_ADDR"]));
            $output["hostname"] = php_uname("n");
            header("Content-Disposition: inline; filename=\"server_register.json\";");
            header("content-type: application/json charset=utf-8");
            echo json_encode($output);
            exit();
        } elseif($_GET["type"] == "response") {
            header("HTTP/1.1 200");
            header("Content-Disposition: inline; filename=\"server_response.json\";");
            header("content-type: application/json charset=utf-8");
        } else {
            //$port = (isset($_GET["netport"]) && !empty($_GET["netport"])) ? $_GET["netport"] : "eth0";
            $output["cpu"] = $stats->getCpuInfo();
            $output["memory"] = $stats->getMemStat();
            $output["uptime"] = $stats->getUptime();
            $output["processes"] = $stats->countProcesses();
            $output["services"] = $stats->getServiceStatus($_GET["services"]);
            //$output["netspeed"] = $stats->getCurrentSpeed($port);
            header("Content-Disposition: inline; filename=\"server_status.json\";");
            header("content-type: application/json charset=utf-8");
            echo json_encode($output);
        }
    } else header("HTTP/1.1 401");
} else {
    header("HTTP/1.1 404");
}


?>