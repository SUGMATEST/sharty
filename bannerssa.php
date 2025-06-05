<?php
$dir = "static/ads/";
$files = scandir($dir, SCANDIR_SORT_NONE);
$images = array_diff($files, array('.', '..', ''));
$name = $images[array_rand($images)];
$filenameWithoutExtension = pathinfo($name, PATHINFO_FILENAME);

// Replace double underscores with slashes
$filenameWithoutExtension = str_replace("__", "/", $filenameWithoutExtension);

// Check for "mailto:" prefix
if (strpos($filenameWithoutExtension, "mailto:") === 0) {
    $link = $filenameWithoutExtension;
} else {
    $link = "http://" . $filenameWithoutExtension;
}

header('Content-Type: image/' . pathinfo($name, PATHINFO_EXTENSION));
header('Cache-Control: no-cache, no-store, must-revalidate'); 
header('Pragma: no-cache');
header('Expires: 0');

// Add a custom header for the link
header('X-Ad-Link: ' . $link);

echo file_get_contents($dir . $name);
exit;
?>
