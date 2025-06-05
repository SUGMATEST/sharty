<?php
$board = $_GET['board'] ?? 'soy';

$files = scandir("static/board_banners/$board", SCANDIR_SORT_NONE);
$files = array_diff($files, ['.', '..']);

$name = $files[array_rand($files)];
header("Location: /static/board_banners/$board/$name", true, 303);
header('Cache-Control: no-cache');

/*

<script>
var banner = document.getElementById('board-banner');
banner.src = '/b.php?board=' + board_name;
 
//redirect on click
banner.onclick = function() {
	//check if special
	if (board_name == 'wiki') {
		window.location.href = 'https://wiki.soyjak.party';
		return;
	}
	else if (board_name == 'rules') {
		window.location.href = '/rules.html';
		return;
	}
	else if (board_name == 'booru') {
		window.location.href = 'https://booru.soy/';
		return;
	}

	//check if mod.php
	if (window.location.href.indexOf('mod.php') > -1) {
		window.location.href = '/mod.php?/' + board_name + '/';
		return;
	}
	window.location.href = '/' + board_name + '/';
}

</script>
*/
