<?php
require_once 'inc/bootstrap.php';

$type = MEDIATOR;
$excluded_boards = ['j', 'q', 'test', 'mediator', 'chive'];
$accounts_needed = 30;
$start_point = 83;

$boards = array_diff(listBoards(true), $excluded_boards);
$end_point = $start_point + $accounts_needed;

for ($i = $start_point; $i < $end_point; $i++) {
	$username = "mediator{$i}";
	$password = bin2hex(random_bytes(8));

	list($version, $crypted_password) = crypt_password($password);

	$query = prepare('INSERT INTO ``mods`` VALUES (NULL, :username, :password, :version, :type, :boards)');
	$query->bindValue(':username', $username);
	$query->bindValue(':password', $crypted_password);
	$query->bindValue(':version', $version);
	$query->bindValue(':type', $type);
	$query->bindValue(':boards', implode(',', $boards));
	$query->execute() or error(db_error($query));

	$userID = $pdo->lastInsertId();

//	modLog('Created a new user: ' . utf8tohtml($username) . ' <small>(#' . $userID . ')</small>');
	echo "{$username} : {$password}\n";
}
