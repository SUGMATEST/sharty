<?php

$dir = 'static/banners';

if (isset($_GET['404']))
	$dir = 'static/404-images';
else if (isset($_GET['403']))
	$dir = 'static/403-images';
else if (isset($_GET['banned']))
	$dir = 'static/banimages';

$files = scandir($dir, SCANDIR_SORT_NONE);
$files = array_diff($files, ['.', '..']);

$name = $files[array_rand($files)];

//header("Cache-Control: no-store");
header('Cache-Control: public, max-age=120');
header("Location: /{$dir}/{$name}", true, 303);
