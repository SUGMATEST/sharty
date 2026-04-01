<?php
require 'inc/bootstrap.php';
include_once "proxycheck.io.php.function.php";

if (!empty($_GET['ip'])) {
	header('Content-Type: application/json; charset=utf-8');

	$ip = $_GET['ip'];

	$board = false;
	if (!empty($_GET['board'])) {
		if (openboard($_GET['board'])) {
			$board = $_GET['board'];
		}
	}

	$minHours = 1;
	if (!empty($_GET['min-hours'])) {
		$minHours = $_GET['min-hours'];
	}

	$minPosts = 1;
	if (!empty($_GET['min-posts'])) {
		$minPosts = $_GET['min-posts'];
	}

	$ageCheck = true;
	$postCheck = true;
	$vpnCheck = vpn_check($ip, false);

	if (get_ip_post_count($ip, $board) < $minPosts) {
		$postCheck = false;
	}

	if (get_oldest_post($ip, $board) > time() - (3600 * $minHours)) {
		$ageCheck = false;
	}

	$passed = !$vpnCheck || ($postCheck && $ageCheck);

	echo json_encode(array(
		'vpn' => $vpnCheck,
		'passed' => $passed,
		'failed' => !$passed
	));
}

else {
	http_response_code(404);
	readfile("static/404.html");
}
