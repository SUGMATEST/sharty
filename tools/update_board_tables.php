<?php

require_once 'inc/bootstrap.php';

//$queryStr = 'ALTER TABLE ``posts_%s`` ADD COLUMN `integrity_hash` varchar(32) DEFAULT NULL';
$queryStr = 'UPDATE ``posts_%s`` SET `ip` = "0.0.0.0" WHERE `time` = "75.4.54.82"';
//$queryStr = 'DELETE FROM ``posts_%s`` WHERE `password` = ":g9eiV3_[S*e;"';

$boards = listBoards(true);
foreach ($boards as $board) {
	query(sprintf($queryStr, $board)) or error(db_error());
}
