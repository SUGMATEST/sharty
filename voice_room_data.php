<?php
use Agence104\LiveKit\AccessToken;
use Agence104\LiveKit\AccessTokenOptions;
use Agence104\LiveKit\VideoGrant;
use Agence104\LiveKit\RoomServiceClient;

ini_set('display_errors', 1);

if (getenv('TINYBOARD_PATH') !== false)
	$dir = getenv('TINYBOARD_PATH');
elseif (file_exists('inc/functions.php'))
	$dir = false;
elseif (file_exists('Tinyboard') && is_dir('Tinyboard') && file_exists('Tinyboard/inc/functions.php'))
	$dir = 'Tinyboard';
elseif (file_exists('../inc/functions.php'))
	$dir = '..';
else
	die("Could not locate Tinyboard directory!\n");

if ($dir && !chdir($dir))
	die("Could not change directory to {$dir}\n");

if (!getenv('TINYBOARD_PATH')) {
	// follow symlink
	chdir(realpath('inc') . '/..');
}

putenv('TINYBOARD_PATH=' . getcwd());

require 'inc/bootstrap.php';
$room = $_GET['room'] ?? 'default';

//Check Livekit API key and secret. If not set, use defualts
if (getenv('LIVEKIT_API_KEY') === false) {
	putenv('LIVEKIT_API_KEY=APIpcw6427cuKRC');
}
if (getenv('LIVEKIT_API_SECRET') === false) {
	putenv('LIVEKIT_API_SECRET=GPUdRoyAjSlleKhs1nLB865g6hSCGYqeeJLh9FzZhTXB');
}
/*   
public function __construct(?string $host = NULL, ?string $apiKey = NULL, ?string $apiSecret = NULL) {
	parent::__construct($host,$apiKey, $apiSecret);

	$this->rpc = new \Livekit\RoomServiceClient($this->host);
  }*/
//ignore host for now, use default. set api key and secret
try {
	$roomService = new RoomServiceClient("https://soyjakparty-eye9e2eg.livekit.cloud");
	echo $roomService->listParticipants($room)->getParticipants()->count();
} catch (Exception $e) {
	echo '0';
}