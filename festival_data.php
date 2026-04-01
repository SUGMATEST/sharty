<?php
header('Cache-Control: public, max-age=30');

/*
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
*/

require_once 'inc/bootstrap.php';


// Configuration for Splatfest teams
// $config['splatfest_teams'] = array(
//     'Water Park' => array('/static/festival/waterpark.png', "#00BFFF"),
//     'Beach'      => array('/static/festival/beach.png', "#FFD700"),
// );

// Initialize Redis
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);


// Fetch the scores for each team
$scores = array();
foreach ($config['splatfest_teams'] as $team => $details) {
    $score = $redis->get("splatfest_team_score:$team");
    if ($score === false) {
        $score = 0;
    }
	$score = floatval($score);
	$score *= 10.0;
	//reduce to .2 decimal places
	$score = round($score, 2);
    $scores[] = array('name' => $team, 'score' => ($score), 'color' => $details[1], 'black_text' => !empty($details[2]));
}

// Return scores as JSON
header('Content-Type: application/json');
echo json_encode($scores);
?>

