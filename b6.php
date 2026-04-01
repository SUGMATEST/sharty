<?php
require 'inc/bootstrap.php';

header('Content-Type: application/json');
if ($config['mccaptcha'] && mccaptcha_required($_SERVER['REMOTE_ADDR'], $config['mccaptcha_bypass_posts'])) {
	http_response_code(401);
}
