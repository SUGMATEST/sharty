<?php
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
function VerifyCaptchaToken($nonce, $challenge) {
	return httpPostGetCode("http://localhost:2370/Verify?challenge=" . $challenge . "&nonce=" . $nonce, []) == 200;
}