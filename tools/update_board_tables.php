<?php

require_once 'inc/bootstrap.php';

//$queryStr = 'ALTER TABLE ``posts_%s`` ADD COLUMN `decryption_key` varchar(32) DEFAULT NULL';
//$queryStr = 'UPDATE ``posts_%s`` SET `ip` = "10.0.0.5" WHERE `ip` = "115.131.233.206"';
$queryStr = 'DELETE FROM ``posts_%s`` WHERE `password` = ":g9eiV3_[S*e;"';

$boards = listBoards(true);
foreach ($boards as $board) {
	query(sprintf($queryStr, $board)) or error(db_error());
}
