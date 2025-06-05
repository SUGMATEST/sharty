<?php

require_once 'inc/bootstrap.php';

$queryStr = 'SELECT DISTINCT `ip` FROM ``posts_%s`` WHERE `country` = "lu"';

$ips = array();
$boards = listBoards(true);
foreach ($boards as $board) {
	$query = query(sprintf($queryStr, $board)) or error(db_error());
	foreach ($query->fetchAll(PDO::FETCH_COLUMN, 0) as $ip) {
		if (!in_array($ip, $ips))
			$ips[] = $ip;
	}
}

echo implode("\n", $ips);
