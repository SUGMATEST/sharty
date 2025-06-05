<?php
@define('TINYBOARD', 'xD');
require_once('vendor/autoload.php');

if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
	$_SERVER['REMOTE_ADDR'] = preg_replace('/^((?:.+?:){4}).*/', '$1:', $_SERVER['REMOTE_ADDR']);
}

if (!empty($_COOKIE['ip_token']) && empty($trueClientIP) && $_SERVER['REMOTE_ADDR'] == '0.0.0.0') {
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);

	if ($ip = $redis->get('ipToken_' . md5($_COOKIE['ip_token']))) {
		global $trueClientIP;
		$trueClientIP = $_SERVER['REMOTE_ADDR'];
		$_SERVER['REMOTE_ADDR'] = $ip;
	}
	else {
		setcookie('ip_token', '', time() - 3600);
	}

	$redis->close();
}
