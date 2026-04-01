<?php
require 'inc/bootstrap.php';

$query = query('SELECT * FROM `bans` ORDER BY `id` DESC LIMIT 100');
$query->execute() or error(db_error($query));
$bans = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($bans as &$ban) {
	if ($ban['hide_post_from_ban_list']) {
		$ban['post'] = null;
	}
	else if (!empty($ban['post'])) {
		$post = json_decode($ban['post'], true);
		if (!empty($post['files'])) {
			$post['files'] = array(array());
			$post['files'][0]['file'] = 'deleted';
			$post['files'][0]['thumb'] = false;
			$post['num_files'] = 1;
		}
		$post = new Post($post);
		$ban['post'] = $post->build(true);
	}

	if ($config['mod_ids']) {
		$ban['mod_id'] = get_identifier_code_for_number($ban['creator']);
	}
}

header('Cache-Control: public, max-age=60');
die(
	Element($config['file_page_template'], array(
		'title' => 'Ban List',
		'config' => $config,
		'boardlist' => createBoardlist(isset($mod) ? $mod : false),
		'body' => Element($config['file_public_ban_list'], array(
			'bans' => $bans,
		)),
	))
);
