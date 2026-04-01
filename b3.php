<?php
/*$board = $_GET['board'] ?? 'soy';

$files = scandir("static/board_banners/$board", SCANDIR_SORT_NONE);
$files = array_diff($files, ['.', '..']);

$name = $files[array_rand($files)];
header("Location: /static/board_banners/$board/$name", true, 303);
header('Cache-Control: no-cache');*/

/*<img width="800" height="100" alt="Board banner" id="board-banner" style="display: block; margin-left: auto; margin-right: auto;" src="/b2.php?board={{ board.uri }}" />

<script>
	var possibleBanners = ['fort', 'craft', 'calm', 'caca', 'bait', 'an', 'a', 'yyy', 'x', 'trump', 'sude', 'spice', 'soy', 'sci', 'raid', 'r', 'qa', 'q', 'pol', 'wiki', 'rules', 'plier', 'booru', 'o', 'news', 'nate', 'mtv', 'jak'];
	
	var pickedBanner = possibleBanners[Math.floor(Math.random() * possibleBanners.length)];
	var banner = document.getElementById('board-banner');
	banner.onclick = function() {
		if (pickedBanner == 'wiki') {
			window.location.href = 'https://wiki.soyjak.party';
			return;
		}
		else if (pickedBanner == 'rules') {
			window.location.href = '/rules.html';
			return;
		}
		else if (pickedBanner == 'booru') {
			window.location.href = 'https://booru.soy/';
			return;
		}
	
		if (inMod) {
			window.location.href = '/mod.php?/' + pickedBanner + '/';
			return;
		}
		window.location.href = '/' + pickedBanner + '/';
	}
	
</script>*/

include_once 'inc/bootstrap.php';

global $config;

$nonBoards = ['wiki', 'rules', 'booru', 'o', 'irc'];

$boards = scandir("static/board_banners", SCANDIR_SORT_NONE);
$boards = array_diff($boards, ['.', '..']);

// Prevent displaying locked boards
$selectionFailures = 0;
while (true) {
	$board = $boards[array_rand($boards)];

	if (in_array($board, $nonBoards)) {
		break;
	}

	if (openboard($board)) {
		$board = $board['uri'];
		if ($config['board_locked'] != true) {
			break;
		}
	}

	$selectionFailures += 1;
	if ($selectionFailures > 5) {
		$board = $nonBoards[0];
		break;
	}

	// Remove board from the list so it's not tried again
	$boards = array_diff($boards, [$board]);
}

$files = scandir("static/board_banners/$board", SCANDIR_SORT_NONE);
$files = array_diff($files, ['.', '..']);
$name = $files[array_rand($files)];

if ($board == 'yyy') {
	$board = 'yyyyyyy';
}

$href = "/$board/";
if ($board == 'wiki') {
	$href = 'https://wiki.soyjak.st';
}
else if ($board == 'blog') {
	$href = 'https://blog.soyjak.st';
}
else if ($board == 'rules') {
	$href = '/rules.html';
}
else if ($board == 'booru') {
	$href = 'https://soybooru.com/';
}
else if ($board == 'irc') {
        $href = 'https://webirc.soyjak.st';
}
else if (isset($_GET['mod']) && $_GET['mod']) {
	$href = "/mod.php?/$board/";
}
else {
	$href = "/$board/";
}

if ($board == 'yyyyyyy') {
	$board = 'yyy';
}
$html = "<!DOCTYPE html>";
//$html .= "<script>if (window.location.hostname != 'soyjak.party' && window.location.hostname != 'soyjak.st' && !location.hostname.includes('.onion')) { window.top.document.replaceChildren(); }</script>";
$html .= "<a target='_parent' href='$href'>";
$html .= "<img alt='Board banner' id='board-banner' style='width:100%;height:100%;margin:0px;padding:0px;display:block;' src='/static/board_banners/$board/$name' />";
$html .= "</a>";

header('Cache-Control: public, max-age=120');
echo $html;
