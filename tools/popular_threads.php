<?php

require_once 'inc/bootstrap.php';


$boards = listBoards(true);

foreach ($boards as $board) {
	$q = query(sprintf("SELECT * from ``posts_%s`` WHERE time < UNIX_TIMESTAMP() - 10*60 AND `thread` IS NULL", $board));
	$q->execute() or error(db_error($q));
	while($row = $q->fetch(PDO::FETCH_ASSOC)) {
		$q2 = prepare(sprintf("SELECT COUNT(*) FROM ``posts_%s`` WHERE `thread` = :thread", $board));
		$q2->bindValue(':thread', $row['id']);
		$q2->execute() or error(db_error($q2));
		list($replycount) = $q2->fetch(PDO::FETCH_NUM);
		if($replycount < 15) continue;

		$q2 = prepare(sprintf("SELECT COUNT(*) FROM ``posts_%s`` WHERE `thread` = :thread AND `files` IS NOT NULL", $board));
		$q2->bindValue(':thread', $row['id']);
		$q2->execute() or error(db_error($q2));
		list($imagecount) = $q2->fetch(PDO::FETCH_NUM);

		$row['board'] = $board;

		//if(!check_post($row)) continue;

		$row['replies'] = $replycount;
		$row['images'] = $imagecount;

		$posts[] = $row;
	}
}

{
	shuffle($posts);
	
	$total = 0;
	$max_threads = 8;
	$count = count($posts);
	
	$dup_boards = array();
	
	for ($i = 0; $i < $count && $total < $max_threads; $i++) {
		$posts[$i]['domain'] = $config['site_domain'];
		
		$picky = ($count - $i) > ($max_threads - $total);
		
		if ($picky && isset($dup_boards[$posts[$i]['board']])) {
			continue;
		}

		$dup_boards[$posts[$i]['board']] = true;

		$popular_threads[] = $posts[$i];
		$total++;
	}
}

foreach ($popular_threads as $no => $thread) {
	echo ($no + 1) . ". - /{$thread['board']}/thread/{$thread['id']}.html\n";
}
