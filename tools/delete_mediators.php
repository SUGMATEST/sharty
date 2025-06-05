<?php
require_once 'inc/bootstrap.php';

$type = MEDIATOR;
$excluded_boards = ['j', 'q', 'test', 'mediator', 'chive'];
$accounts_needed = 30;
$start_point = 351;

$boards = array_diff(listBoards(true), $excluded_boards);
$end_point = $start_point + $accounts_needed;

for ($i = $start_point; $i < $end_point; $i++) {
	$query = prepare('DELETE FROM ``mods`` WHERE `id` = :id');
	$query->bindValue(':id', $i);
	$query->execute() or error(db_error($query));
}
