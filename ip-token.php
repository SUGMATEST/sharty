<?php

require_once 'inc/bootstrap.php';

use GeoIp2\Database\Reader as GeoIp2Reader;

$token = null;
$ttl = 0;
$true_ip = isset($trueClientIP) ? $trueClientIP : $_SERVER['REMOTE_ADDR'];
$using_hidden_service = $true_ip == $config['onion_addr'];
$title = $using_hidden_service ? 'Use an IP token' : 'Generate an IP token';

$redis = new Redis();
$redis->connect('127.0.0.1', 6379);

if (isset($_POST['ip-token'])) {
	if ($true_ip != $config['onion_addr']) {
		error('IP tokens can only be used from the hidden service.');
	}

	if (!$redis->exists('ipToken_' . md5($_POST['ip-token']))) {
		error('Invalid IP token.');
	}

	$ttl = $redis->ttl('ipToken_' . md5($_POST['ip-token']));

	setcookie('ip_token', $_POST['ip-token'], time() + $ttl);
	header('Location: /ip-token.php');
	die();
}

else if (isset($_POST['delete-token'])) {
	setcookie('ip_token', '', time() - 3600);
	header('Location: /ip-token.php');
	die();
}

else if (isset($_POST['generate'])) {
	if (isset($trueClientIP)) {
		error('You cannot generate new tokens while using a token.');
	}

	if ($true_ip == $config['onion_addr']) {
		error('You cannot generate tokens from the hidden service.');
	}

	$integrityFound = false;
	if (isset($_POST['integrity-v2'])) {
		/*    sprintf(_json,
								   "{"
								   "\"ap\":%d,"
								   "\"arch\":%d,"
								   "\"cd\":%d,"
								   "\"dm\":%d,"
								   "\"tz\":%d,"
								   "\"ti\":\"%s\","
								   "\"tei\":\"%s\","
								   "\"uhd\":%d,"
								   "\"uhblwc\":%d,"
								   "\"tfvce\":%d,"
								   "\"tfvw\":%d,"
								   "\"ts\":%d,"
								   "\"istr\":%d,"
								   "\"iseh\":%d,"
								   "\"isc\":%d,"
								   "\"isdwk\":%d,"
								   "\"isswk\":%d,"
								   "\"isg\":%d,"
								   "\"isc86\":%d,"
								   "\"isw606\":%d"
								   "}",
								   fingerprint.ApplePayStatus,
								   fingerprint.Architecture,
								   fingerprint.ColorDepth,
								   fingerprint.DeviceMemory,
								   fingerprint.TimeZone,
								   fingerprint.TrueIP,
								   fingerprint.TuxlerExposedIP,
								   fingerprint.UserHasDiscord,
								   fingerprint.UserHasBlockedLocalhostWebsocketConnections,
								   fingerprint.TuxlerFoundViaChromeExtension,
								   fingerprint.TuxlerFoundViaWebsocket,
								   fingerprint.Timestamp,
								   fingerprint.IsTrident,
								   fingerprint.IsEdgeHTML,
								   fingerprint.IsChromium,
								   fingerprint.IsDesktopWebKit,
								   fingerprint.IsSafariWebKit,
								   fingerprint.IsGecko,
								   fingerprint.IsChromium86OrNewer,
								   fingerprint.IsWebKit606OrNewer
								   );*/
		$jsonData = $_POST['integrity-v2'];
		// Decode the JSON data
		$data = json_decode($jsonData, true);
		$iv = base64_decode($data['iv']);
		$encryptedData = ($data['data']);

		// Temporary fix for memory initialization issue
		// Find the position of the first '=' or '=='
		$equalsPos = strpos($encryptedData, '=');
		if ($equalsPos !== false) {
			// Check if it's a double '=='
			if (substr($encryptedData, $equalsPos, 2) == '==') {
				// Crop the string up to the first occurrence of '=='
				$encryptedData = substr($encryptedData, 0, $equalsPos + 2);
			} else {
				// Crop the string up to the first occurrence of '='
				$encryptedData = substr($encryptedData, 0, $equalsPos + 1);
			}
		}
		$encryptedData = base64_decode($encryptedData);
		$key = "98c371aec7aac89c16226c782c4968cb"; // Ensure this is exactly 16 bytes
		$key = hex2bin($key);
		$decryptedData = openssl_decrypt($encryptedData, 'aes-128-cbc', $key, OPENSSL_RAW_DATA | OPENSSL_DONT_ZERO_PAD_KEY | OPENSSL_ZERO_PADDING, $iv);
		$decryptedData = rtrim($decryptedData, "\0");
		error_log($decryptedData);

		$decryptedData = json_decode($decryptedData, true);

		//if it is not an array then it is invalid
		if (!is_array($decryptedData)) {
			error_log("Failed to get integrity data. Dumping encrypted data: " . $jsonData . "Decrypted data is of type " . gettype($decryptedData) . " and is " . $decryptedData);
			error("Integrity check failed. Make sure you have WASM and Javascript enabled.");
		}

		if ($decryptedData['f'] == 1) {
			error("Integrity check failed. Make sure you have WASM and Javascript enabled.");
		}

		if ($decryptedData['arch'] != 255) {
			error('IP tokens can only be generated from desktops.');
		}

		// Make sure the timestamp is within 80 minutes of the current time
		if (abs(time() - $decryptedData['ts']) > 60 * 80) {
			error_log("Invalid integrity timestamp, time difference: " . abs(time() - $decryptedData['ts']));
			error("Invalid integrity timestamp. Please refresh the page and try again.");
		}

		$decryptedData['ti'] = trim($decryptedData['ti']);
		$decryptedData['tei'] = trim($decryptedData['tei']);

		if ($decryptedData['ti'] != $true_ip) {
			error("Integrity check failed. Please refresh the page and try again.");
		}

		if ($decryptedData['tei'] != $decryptedData['ti']) {
			error_log("Notice: User had different IP to tuxler API. Tuxler exposed IP: " . $decryptedData['tei'] . " True IP: " . $decryptedData['ti']);
			// If both are the same type of IP then error
			if (
				(
					filter_var($decryptedData['tei'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) &&
					filter_var($decryptedData['ti'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)
				)
				||
				(
					filter_var($decryptedData['tei'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) &&
					filter_var($decryptedData['ti'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)
				)
			) {
				error("Integrity check failed. Please refresh the page and try again.");
			}
		}

		$gi_reader = new GeoIp2Reader('inc/lib/geoip2/GeoLite2-City.mmdb');
		try {
			$gi_record = $gi_reader->city($_SERVER["REMOTE_ADDR"]);
		}
		catch (Exception $e) {
			$gi_record = $gi_reader->city('76.230.242.131');
		}

		$tz = timezone_open($gi_record->location->timeZone);
		$tz_offset = (timezone_offset_get($tz, new DateTime("now", $tz)) / 60) * -1;
		$tz_diff = $decryptedData['tz'] - $tz_offset;

		if (
			($tz_diff < -60 || $tz_diff > 60)
		) {
			error_log("Timezone mismatch detected, difference: " . $tz_diff);
			error("Integrity check failed. Please refresh the page and try again.");
		}

		if ($decryptedData['tfvce']) {
		        error("Please remove the Tuxler extension from your browser.");
		}
		if ($decryptedData['tfvw']) {
		        error("Please remove Tuxler from your computer.");
		}

		$integrityFound = true;
	}

	if (!$integrityFound) {
		error("Integrity check failed. Make sure you have WASM and Javascript enabled.");
	}

	if ($token = $redis->get('ipTokenAddr_' . $_SERVER['REMOTE_ADDR'])) {
		$redis->del('ipToken_' . md5($token));
	}

	$ttl = 7*24*60*60;
	$token = 'IP-' . strtoupper(bin2hex(random_bytes(12)));
	$redis->set('ipTokenAddr_' . $_SERVER['REMOTE_ADDR'], $token, $ttl);
	$redis->set('ipTokenAddrIntegrity_' . $_SERVER['REMOTE_ADDR'], json_encode($decryptedData), $ttl);
	$redis->set('ipToken_' . md5($token), $_SERVER['REMOTE_ADDR'], $ttl);
}

else if (isset($_COOKIE['ip_token']) && $redis->exists('ipToken_' . md5($_COOKIE['ip_token']))) {
	$ttl = $redis->ttl('ipToken_' . md5($_COOKIE['ip_token']));
}

$redis->close();

die(
	Element($config['file_page_template'], array(
		'title' => $title,
		'config' => $config,
		'boardlist' => createBoardlist(isset($mod) ? $mod : false),
		'body' => Element($config['file_ip_token'], array(
			'token' => $token,
			'expires' => time() + $ttl,
			'ip' => $_SERVER['REMOTE_ADDR'],
			'using_token' => isset($trueClientIP),
			'true_ip' => $true_ip,
			'hidden_service' => $using_hidden_service,
		)),
	))
);
