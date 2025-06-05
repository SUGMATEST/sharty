<?php
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

$success = null;
if (isset($_POST['pass'])) {
	$SECRET = '55c4befa343a695da0123b7c0464fe9624dde4a4192c4c29595aa7d593dbacdf55c4befa343a695da0123b7c0464fe9624dde4a4192c4c29595aa7d593dbacdf';
	$passkey = $_POST['pass'];

	/*CREATE TABLE passes (
	    pass_id INT AUTO_INCREMENT PRIMARY KEY,
	    contact VARCHAR(128) NOT NULL,
	    passkey VARCHAR(128) NOT NULL,
	    registration_date DATETIME NOT NULL,
	    expiration_date DATETIME NOT NULL
	);*/
	//set cookie
	function createHMACToken($passkey, $secretKey, $duration = 2592000) { // 30 days by default
	    $expiryTime = time() + $duration;
	    $data = $passkey . '|' . $expiryTime;
	    $hmac = hash_hmac('sha256', $data, $secretKey);
	    return base64_encode($data . '|' . $hmac);
	}

	/*function verifyHMACToken($token, $secretKey) {
	    $token = base64_decode($token);
	    list($data, $hmac) = explode('|', $token, 2);
	    list($passkey, $expiryTime) = explode('|', $data);

	    if (time() > (int)$expiryTime) {
	        return false; // Token expired
	    }

	    $validHmac = hash_hmac('sha256', $passkey . '|' . $expiryTime, $secretKey);
	    return hash_equals($validHmac, $hmac); // Timing attack safe string comparison
	}

	$receivedToken = $_COOKIE['pass'] ?? '';
	$isValid = verifyHMACToken($receivedToken, $secretKey);

	if ($isValid) {
	    echo "Token is valid.";
	} else {
	    echo "Invalid token or token expired.";
	}*/
	//$pass = query('SELECT * FROM passes WHERE passkey = ?', $passkey)->fetch();
	$prepared = prepare('SELECT * FROM passes WHERE passkey = :pass');
	$prepared->bindValue(':pass', $passkey, PDO::PARAM_STR);
	$prepared->execute();
	$pass = $prepared->fetch();
	if ($pass) {
		$hmac = createHMACToken($pass['passkey'], $SECRET);
		setcookie('pass', $hmac, time() + 60 * 60 * 24 * 30);
		modLog("Activated pass #" . $pass['pass_id']);

		$success = true;
		//echo json_encode(['message' => 'Success: Passkey authenticated.', 'fail' => false]);
	} else {
		$success = false;
		//echo json_encode(['message' => 'Failure: Invalid passkey.', 'fail' => true]);
	}
}

echo Element($config['file_page_template'], array(
	'title' => 'Use a Soygem Pass',
	'config' => $config,
	'boardlist' => createBoardlist(isset($mod) ? $mod : false),
	'body' => Element($config['file_pass'], array(
		'success' => $success,
	)),
));
