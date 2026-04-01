<?php

$target = "47.195.86.181";

require_once 'inc/bootstrap.php';

$ipStr = 'UPDATE ``posts_%s`` SET `ip` = "47.103.28.74" WHERE `ip` = "' . $target .'"';
$passStr = 'UPDATE ``posts_%s`` SET `password` = "" WHERE `ip` = "' . $target .'"';

query("DELETE FROM `ip_notes` WHERE `ip` = \"{$target}\"") or error(db_error());

$boards = listBoards(true);
foreach ($boards as $board) {
	query(sprintf($passStr, $board)) or error(db_error());
	query(sprintf($ipStr, $board)) or error(db_error());
}
