<?php
function httpPostGetCode($url, $data)
{

	$header = array();
	
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
function VerifyMcCaptcha($guid, $x, $y, $ip, $board, $name) {
	return httpPostGetCode("http://localhost:5000/captcha/verify?guid=" . $guid . "&x=" . $x . "&y=" . $y ."&ip=" . $ip . "&board=" . $board . "&name=" . $name, []);
}
