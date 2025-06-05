<?php
require_once 'inc/bootstrap.php';
require_once 'inc/functions.php';
/*
Bans::new_ban($_SERVER['REMOTE_ADDR'], $this->reason, $this->expires, $this->all_boards ? false : $board['uri'], -1, $post);*/

//return if GET, POST only
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	die();
}

//if already banned, return
$ip = $_SERVER['REMOTE_ADDR'];

$bans = Bans::find($ip, $board, $config['show_modname']);

foreach ($bans as &$ban) {
	if ($ban['expires'] && $ban['expires'] < time()) {
	} else {
		die();
	}
}


//get the reason from post data (will be a int, corresponding)

$id = $_POST['i'];

switch ($id) {
	case 1:
		$reason = '7. Residential proxies or residential VPNs are forbidden.';
		break;
	case 3:
		$reason = '7. Residential proxies or residential VPNs are forbidden. (2)';
		die();
		break;
	default:
		die();
}




Bans::new_ban($_SERVER['REMOTE_ADDR'], $reason, null, false, 137 /*IAMS*/ , false);