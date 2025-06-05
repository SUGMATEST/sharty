<?php
$mode = @$_GET['mode'];
function httpPost($url, $data)
{

	$header = array();
	//$header[] = 'Content-length: 0';
	//$header[] = 'Content-type: application/json';
	$header[] = 'Authorization: Bearer 9ceec5570c4f7cca36150002a72620d9';
	
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}
function httpPostGetCode($url, $data)
{

	$header = array();
	//$header[] = 'Content-length: 0'; 
	//$header[] = 'Content-type: application/json';
	$header[] = 'Authorization: Bearer 9ceec5570c4f7cca36150002a72620d9';
	
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    $response = curl_exec($curl);
	$httpcode = curl_getinfo($curl,  CURLINFO_RESPONSE_CODE );
    curl_close($curl);
    return $httpcode;
}
function GetNewToken() {
	if (apcu_fetch("token_idx") == null)
		apcu_store("token_idx", 0);
	$idx = apcu_inc("token_idx");
	if ($idx > 9000){
		apcu_delete("tokens");
		apcu_store("token_idx", 0);
		$idx = 0;
	}
	header("X-Index: {$idx}");

	$arr = apcu_entry("tokens", function($key) {
		return json_decode(httpPost("http://localhost:2370/GetChallenges?difficultyLevel=15", []));
	});
	$token = $arr[$idx];
	if (!$token){
		apcu_delete("tokens");
		
		$arr = apcu_entry("tokens", function($key) {
			return json_decode(httpPost("http://localhost:2370/GetChallenges?difficultyLevel=15", []));
		});
		$token = $arr[0];
		apcu_store("token_idx", 0);
		$idx = 0;
	}
	header("X-Token: {$token}");
	
	return $token;
}

function VerifyCaptchaToken($nonce, $challenge) {
	return httpPostGetCode("http://localhost:2370/Verify?challenge=" . $challenge . "&nonce=" . $nonce, []) == 200;
}




switch ($mode) {
// Request: GET entrypoint.php?mode=get&extra=1234567890
// Response: JSON: cookie => "generatedcookie", captchahtml => "captchahtml", expires_in => 120
case "token":
	$token = GetNewToken();
	echo $token;
  break;
}
?>