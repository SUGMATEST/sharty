<?php

require_once 'inc/bootstrap.php';

$queryStr = 'UPDATE ``posts_%s`` SET `ip` = "0.0.0.0", `integrity_hash` = NULL, `integrity` = NULL, `password` = NULL, `sharty_browser_hash` = NULL, post_flags = 0, country = NULL, passkey = NULL WHERE time < (UNIX_TIMESTAMP() - 604800)';

$boards = listBoards(true);
foreach ($boards as $board) {
	query(sprintf($queryStr, $board)) or error(db_error());
}

query('DELETE FROM integrity WHERE ts < (UNIX_TIMESTAMP() - 604800)') or error(db_error());

Cache::flush();
