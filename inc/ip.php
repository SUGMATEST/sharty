<?php

if (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
	$_SERVER['REMOTE_ADDR'] = preg_replace('/^((?:.+?:){4}).*/', '$1:', $_SERVER['REMOTE_ADDR']);
}

echo $_SERVER['REMOTE_ADDR'];
