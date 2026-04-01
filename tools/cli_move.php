<?php

require_once 'inc/bootstrap.php';
require_once 'inc/mod/pages.php';

$originBoard = "a";
$postID = 36296;

$_POST['board'] = "test";
$_POST['shadow'] = true;

$mod = array(
	'id' => 137,
	'type' => 99,
	'username' => "IAMS",
	'hash' => mkhash("IAMS", "niggeR"),
	'boards' => ["*"]
);

mod_move($originBoard, $postID);
