<?php

require_once 'inc/bootstrap.php';

echo get_ip_post_count("146.70.61.131", false, false, time() - (3600 * 0.1));
