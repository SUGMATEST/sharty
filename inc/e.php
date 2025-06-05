<?php
#Error Report System
$jsError = $_POST['jsError'];

#rate limit settings
$limit = 10; // limit of requests
$timeFrame = 60; // time frame in seconds

#IP address
$ip = $_SERVER['REMOTE_ADDR'];

#connect to Redis
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

#check if limit is exceeded
if ($redis->exists($ip) && $redis->get($ip) >= $limit) {
	//429
	http_response_code(429);
    exit('Rate limit exceeded');
}

#increment the count
$redis->incr($ip);
$redis->expire($ip, $timeFrame);

#create log entry
$jsError = htmlspecialchars($jsError);
//replace newlines with spaces
$jsError = str_replace(array("\r", "\n"), ' ', $jsError);
$logEntry = date("Y-m-d H:i:s") . " - " . $ip . " - " . $jsError . "\n";

#write to log
$logfile = fopen("error.log", "a");
fwrite($logfile, $logEntry);
fclose($logfile);