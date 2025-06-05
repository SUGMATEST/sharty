<?php
use Agence104\LiveKit\AccessToken;
use Agence104\LiveKit\AccessTokenOptions;
use Agence104\LiveKit\VideoGrant;
ini_set('display_errors', 1);

if(getenv('TINYBOARD_PATH') !== false)
	$dir = getenv('TINYBOARD_PATH');
elseif(file_exists('inc/functions.php'))
	$dir = false;
elseif(file_exists('Tinyboard') && is_dir('Tinyboard') && file_exists('Tinyboard/inc/functions.php'))
	$dir = 'Tinyboard';
elseif(file_exists('../inc/functions.php'))
	$dir = '..';
else
	die("Could not locate Tinyboard directory!\n");

if($dir && !chdir($dir))
	die("Could not change directory to {$dir}\n");

if(!getenv('TINYBOARD_PATH')) {
	// follow symlink
	chdir(realpath('inc') . '/..');
}

putenv('TINYBOARD_PATH=' . getcwd());

require 'inc/bootstrap.php';
checkBan('voice');


check_login(false);

$is_mod = isset($mod);
if (!$is_mod) {
	include_once "proxycheck.io.php.function.php";
	if (vpn_check($_SERVER["REMOTE_ADDR"], $config['mandate_soy_history'])) {
		die();
	}
}
class XorShift{

	var $x,$y,$z,$w;

	function __construct( $seed = false ){

		$this->x = 123456789;
		$this->y = 362436069;
		$this->z = 521288629;

		if( $seed !== false ){
			$this->w = $seed;
		}
		else{
			$this->w = 88675123;
		}
	}

	function random(){

		$t = ( $this->x ^ ($this->x << 11) ) & 0x7fffffff;
		
		$this->x = $this->y;
		$this->y = $this->z;
		$this->z = $this->w;
		
		$this->w = ( $this->w ^ ($this->w >> 19) ^ ( $t ^ ( $t >> 8 )) );
		
		return $this->w;
	}

	function setSeed( $seed ){
		$this->w = $seed;
	}
}
function ConvertIPToName($ip) {
	$nounList = array();
	//Read from nounlist.txt
	$lines = file('nounlist.txt');
	foreach($lines as $line) {
		$nounList[] = trim($line);
	}
	$hashedIp = hash('sha256', $ip . "828c32cd7252a22a8fc91621666bd521ac54ef7d7295ad0f3fe1ef2df11d62e7nigger");
	$ipInt = hexdec(substr($hashedIp, 0, 8));
	$xor = new XorShift($ipInt);
	$fourNouns = array();
	for($i = 0; $i < 4; $i++) {
		$fourNouns[] = $nounList[$xor->random() % count($nounList)];
	}
	$fourNounsJoined = implode("-", $fourNouns);
	return $fourNounsJoined;
}

$room = $_GET['room'] ?? 'default';
// If this room doesn't exist, it'll be automatically created when the first
// client joins.
$roomName = $room;
// The identifier to be used for participant.
$participantName =	ConvertIPToName($_SERVER['REMOTE_ADDR']);

// Define the token options.
$tokenOptions = (new AccessTokenOptions())
  ->setIdentity($participantName);

// Define the video grants.
$videoGrant = (new VideoGrant())
  ->setRoomJoin()
  ->setRoomName($roomName);

  //Check Livekit API key and secret. If not set, use defualts
  if (getenv('LIVEKIT_API_KEY') === false) {
	putenv('LIVEKIT_API_KEY=APIpcw6427cuKRC');
  }
  if (getenv('LIVEKIT_API_SECRET') === false) {
	putenv('LIVEKIT_API_SECRET=GPUdRoyAjSlleKhs1nLB865g6hSCGYqeeJLh9FzZhTXB');
  }

// Initialize and fetch the JWT Token.
$token = (new AccessToken(getenv('LIVEKIT_API_KEY'), getenv('LIVEKIT_API_SECRET')))
  ->init($tokenOptions)
  ->setGrant($videoGrant)
  ->toJwt();

modLog('Livekit Token generated for ' . $participantName . ' in room ' . $roomName);
echo $token;
