<?php
require 'inc/bootstrap.php';

if (
	isset($_GET['board']) &&
	isset($_GET['id'])
) {
	global $config, $mod;

	if (!openboard($_GET['board'])) {
		error($config['error']['noboard']);
	}

	if (get_oldest_post($_SERVER['REMOTE_ADDR']) > time() - (3600 * 2)) {
		error('Your IP currently doesn\'t meet the requirements to vote to remove posts');
	}

	if ($config['user_vote_to_delete'] !== true) {
		error('You cannot vote to delete posts from this board.');
	}

	check_login(false);

	$query = prepare(sprintf('SELECT * FROM ``posts_%s`` WHERE `id` = :id', $_GET['board']));
	$query->bindValue(':id', $_GET['id']);
	$query->execute() or error(db_error($query));

	if (!$post = $query->fetch(PDO::FETCH_ASSOC)) {
		error($config['error']['invalidpost']);
	}

	if (!empty($post['capcode'])) {
		error('You cannot vote to delete capcode posts.');
	}
	if ($post['invincible']) {
		error('You cannot vote to delete looped posts.');
	}

	$redis = New Redis();
	$redis->connect('127.0.0.1', 6379);

	$inLastHour = $redis->get('commieVotesThisHour_' . $_GET['board'] . '_' . $_SERVER['REMOTE_ADDR']);
	if (!hasPermission($config['mod']['extra_votes'], $_GET['board']) && $inLastHour >= 3) {
		error('You cannot vote to remove any more posts right now.');
	}
	else if ($inLastHour >= 10) {
		error('You cannot vote to remove any more posts right now.');
	}

	if ($redis->exists('commieVote_' . $_GET['board'] . '_' . $_GET['id'] . '_' . $_SERVER['REMOTE_ADDR'])) {
		error('You have already voted to remove this post.');
	}

	$redis->set('commieVote_' . $_GET['board'] . '_' . $_GET['id'] . '_' . $_SERVER['REMOTE_ADDR'], true);

	if ($inLastHour) {
		$ttl = $redis->ttl('commieVotesThisHour_' . $_GET['board'] . '_' . $_SERVER['REMOTE_ADDR']);
		$redis->set('commieVotesThisHour_' . $_GET['board'] . '_' . $_SERVER['REMOTE_ADDR'], $inLastHour + 1, $ttl);
	}
	else {
		$redis->set('commieVotesThisHour_' . $_GET['board'] . '_' . $_SERVER['REMOTE_ADDR'], 1, 60*60);
	}

	if ($post['mediator_votes'] + 1 >= 5) {
		modLog('Deleting post #' . $_GET['id'] . ' as it reached the voting threshold');
		deletePost($_GET['id']);
	}
	else {
		$query = prepare(sprintf('UPDATE ``posts_%s`` SET `mediator_votes` = :votes WHERE `id` = :id', $_GET['board']));
		$query->bindValue(':id', $_GET['id']);
		$query->bindValue(':votes', $post['mediator_votes'] + 1);
		$query->execute() or error(db_error($query));
		rebuildPost($_GET['id']);
	}

	if (!empty($_SERVER['HTTP_REFERER'])) {
		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	else {
		header('Location: /' . $_GET['board'] . '/index.html');
	}
	die();
}

else {
	error('Board and post ID must be specified.');
}

?>
