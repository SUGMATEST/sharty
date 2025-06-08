<?php
require 'inc/bootstrap.php';

global $config, $board;

if (isset($_POST['thread'], $_POST['board'])) {
	if (!openBoard($_POST['board']))
		error($config['noboard']);

	$query = prepare(sprintf('SELECT * FROM ``posts_%s`` WHERE `id` = :id', $board['uri']));
	$query->bindValue(':id', $_POST['thread']);
	$query->execute() or error(dberror($query));

	if (!$post = $query->fetch(PDO::FETCH_ASSOC))
		error($config['invalidpost']);

	if (empty($post['decryption_key'])) {
		error('This thread isn\'t encrypted.');
	}

	check_login(false);
	$is_mod = isset($_COOKIE['mod']);
	$pass_id = get_pass_id($_COOKIE['pass']);

	if (!$is_mod && !isset($pass_id)) {
		if (isset($config['encrypted_thread_pass_only']) && $config['encrypted_thread_pass_only'])
			error("A Soygem pass is required to decrypt threads on this board.");

		if (get_oldest_post($_SERVER['REMOTE_ADDR']) > time() - (3600 * 8) || get_ip_post_count($_SERVER['REMOTE_ADDR']) < 15 || $_SERVER['REMOTE_ADDR'] == '0.0.0.0') {
			error("Your IP address doesn't meet the requirements for decrypting threads.");
		}

		checkBan();

		$query = prepare('SELECT * FROM ``integrity`` WHERE `ti` = :ip');
		$query->bindValue(':ip', $_SERVER['REMOTE_ADDR']);
		$query->execute() or error(dberror($query));

		if (!$integrity = $query->fetch(PDO::FETCH_ASSOC))
			error('Integrity check failed.');

		if ($integrity['ts'] < time() - (3600 * 2))
			error('Integrity check failed.');

	}

	error_log($_SERVER['REMOTE_ADDR'] . " decrypted post #" . $_POST['thread']);
	header('Content-Type: application/json');
	die(json_encode(array('success' => true, 'key' => $post['decryption_key'])));
}

error($config['invalidpost']);
