<?php
$mode = @$_GET['mode'];
function httpPost($url, $data)
{

	$header = array();
	
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
function httpGet($url) {
    $header = array();
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    $response = curl_exec($curl);
    $httpcode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    curl_close($curl);
    return array("response" => $response, "httpcode" => $httpcode);
}

function GetNewMcCaptcha($ip) {
    $result = httpGet("http://localhost:5000/captcha/get?ip=" . $ip);
    return $result;
}

function GetNewMcIntegrity($ip) {
    $result = httpGet("http://localhost:5000/integrity/get?ip=" . $ip);
    return $result;
}

switch ($mode) {
    case "captcha":
        $result = GetNewMcCaptcha($_SERVER['REMOTE_ADDR']);
        http_response_code($result["httpcode"]); // Set HTTP response code
        echo $result["response"];
        break;
    case "integrity":
        $result = GetNewMcIntegrity($_SERVER['REMOTE_ADDR']);
        http_response_code($result["httpcode"]); // Set HTTP response code
        echo $result["response"];
        break;
    case "test":
        echo "OK";
        break;
        
}
?>
