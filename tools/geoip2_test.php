<?php

require_once 'inc/bootstrap.php';

use GeoIp2\Database\Reader as GeoIp2Reader;

$reader = new GeoIp2Reader('inc/lib/geoip2/GeoLite2-City.mmdb');
$record = $reader->city('79.136.140.213');

echo var_dump($record);

$tz = timezone_open($record->location->timeZone);
$offset = (timezone_offset_get($tz, new DateTime("now", $tz)) / 60) * -1;

echo $offset;
