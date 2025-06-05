<?php
require 'inc/bootstrap.php';

function refund($amount, $msg) {
	add_shop_balance($_POST['password'], $amount);
	error($msg);
}

// Always send JSON errors
$_POST['json_response'] = 1;

// Get wallet balance
if (isset($_POST['balance']) && isset($_POST['password'])) {
	header('Content-Type: text/json; charset=utf-8');
	die(json_encode(array(
		'balance' => get_shop_balance($_POST['password'])
	), JSON_NUMERIC_CHECK));
}

// Purchase and apply item to a post
else if (
	isset($_POST['purchase']) &&
	isset($_POST['board']) &&
	isset($_POST['post-id']) &&
	isset($_POST['item-id']) &&
	isset($_POST['password'])
) {
	global $board;
	if (!openboard($_POST['board'])) {
		error($config['error']['noboard']);
	}

	if (!$config['item_shop']) {
		error('The item shop is not enabled on this board.');
	}

	if ($config['board_locked']) {
		error('Board is locked');
	}

	if (!array_key_exists($_POST['item-id'], $config['shop_items'])) {
		error('Invalid item ID!');
	}

	$item = $config['shop_items'][$_POST['item-id']];

	if (get_shop_balance($_POST['password']) - $item['price'] < 0) {
		error('You cannot afford this item.');
	}
	add_shop_balance($_POST['password'], $item['price'] * -1);

	$query = prepare(sprintf('SELECT * FROM ``posts_%s`` WHERE `id` = :id', $board['uri']));
	$query->bindValue(':id', $_POST['post-id']);
	$query->execute() or refund($item['price'], db_error($query));

	if (!$post = $query->fetch(PDO::FETCH_ASSOC)) {
		refund($item['price'], $config['error']['invalidpost']);
	}

	if ($post['locked']) {
		refund($item['price'], 'Items cannot be used on locked threads.');
	}

	if ($post['looped']) {
		refund($item['price'], 'Items cannot be used on looped threads.');
	}

	if (isset($post['capcode'])) {
		refund($item['price'], 'Items cannot be used on capcode posts.');
	}

	if (isset($post['thread']) && $item['op_only']) {
		refund($item['price'], 'This item cannot be used on replies.');
	}

	$post['body_nomarkup'] .=
	"\n<tinyboard award>" . $item['icon'] . '</tinyboard>' .
	"\n<tinyboard award alt>" . $item['name'] . '</tinyboard>';

	$query = prepare(sprintf('UPDATE ``posts_%s`` SET `body_nomarkup` = :body_nomarkup WHERE `id` = :id', $board['uri']));
	$query->bindValue(':id', $post['id']);
	$query->bindValue(':body_nomarkup', $post['body_nomarkup']);
	$query->execute() or refund($item['price'], db_error($query));

	modLog('Used item "' . $item['name'] . '" on post #' . $post['id']);

	rebuildPost($post['id']);

	if (is_callable($item['effect'])) {
		$post['board'] = $board['uri'];
		$item['effect']($post);
	}

	header('Content-Type: text/json; charset=utf-8');
	die(json_encode(array('success' => true)));
}

// Get item list
else if (isset($_GET['board'])) {
	if (!openboard($_GET['board'])) {
		error($config['error']['noboard']);
	}

	if (!$config['item_shop']) {
		error('The item shop is not enabled on this board.');
	}

	header('Content-Type: text/json; charset=utf-8');
	die(json_encode($config['shop_items'], JSON_NUMERIC_CHECK));
}

?>
