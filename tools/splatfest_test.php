#!/usr/bin/php
<?php

//enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);



require dirname(__FILE__) . '/inc/cli.php';
                
$input = $_SERVER['argv'][1];
echo get_splatfest_score2($input);