<?php
function httpPost($url, $data)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, ($data));
	
	curl_setopt($curl, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain')); 
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

$entityBody = file_get_contents('php://input');


httpPost("http://localhost:5000/integrity/submit?ip=" . $_SERVER['REMOTE_ADDR'], $entityBody);
