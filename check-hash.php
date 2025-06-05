<?php
require_once 'inc/bootstrap.php';

if (isset($_GET['b64']))
	$hash = bin2hex(base64_decode($_GET['b64']));
elseif (isset($_GET['hex']))
	$hash = $_GET['hex'];

if (!isset($hash))
	die("No hash provided!");
elseif (strlen($hash) > 128)
	die("Hash too long!");

header("Content-Type: application/json");
$resp = array('banned' => false, 'reason' => null);

$query = prepare("SELECT * FROM `hashbans` WHERE `filehash` = :filehash");
$query->bindValue(":filehash", $hash);
$query->execute();
$hashban = $query->fetch(PDO::FETCH_ASSOC);
if ($hashban) {
	$resp['banned'] = true;
	$resp['reason'] = $hashban['reason'];
}

die(
	json_encode($resp)
);
