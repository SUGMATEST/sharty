<?php
require_once 'inc/bootstrap.php';

// Output comma separated list for marge.moe's config file instead
$margeMoeFormat = true;

$blacklist = array(
	'j',
	'test',
	'mediator',
	'nate',
	'gem',
	'voice',
	'shrk',
);

$boards = listBoards(true);
foreach ($boards as $board) {
	if (!in_array($board, $blacklist)) {
		if ($margeMoeFormat) {
			echo "'" . $board . "', ";
//			echo $board . ", ";
		}
		else {
			echo '"'.$board."\": {},\n";
		}
	}
}

echo "\n";
