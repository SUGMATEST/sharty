<?php
	$theme = Array();
	
	// Theme name
	$theme['name'] = 'HomePage';
	// Description (you can use Tinyboard markup here)
	$theme['description'] = 'A home page with boards ranked by activity.';
	$theme['version'] = 'v1.0';
	
	// Theme configuration	
	$theme['config'] = Array();
	
	$theme['config'][] = Array(
		'title' => 'Title',
		'name' => 'title',
		'type' => 'text',
		'default' => 'Home'
	);
	
	$theme['config'][] = Array(
		'title' => 'Excluded boards',
		'name' => 'exclude',
		'type' => 'text',
		'comment' => '(space seperated)'
	);
	
	$theme['config'][] = Array(
		'title' => '# of recent images',
		'name' => 'limit_images',
		'type' => 'text',
		'default' => '3',
		'comment' => '(maximum images to display)'
	);
	
	$theme['config'][] = Array(
		'title' => '# of recent posts',
		'name' => 'limit_posts',
		'type' => 'text',
		'default' => '30',
		'comment' => '(maximum posts to display)'
	);

	$theme['config'][] = Array(
		'title' => '# of recent news entries',
		'name' => 'limit_news',
		'type' => 'text',
		'default' => '3',
		'comment' => '(maximum news entries to display)'
	);
	
	$theme['config'][] = Array(
		'title' => 'HTML file',
		'name' => 'html',
		'type' => 'text',
		'default' => 'homepage.html',
		'comment' => '(eg. "homepage.html")'
	);
	
	$theme['config'][] = Array(
		'title' => 'CSS file',
		'name' => 'css',
		'type' => 'text',
		'default' => 'homepage.css',
		'comment' => '(eg. "recent.css")'
	);

	$theme['config'][] = Array(
		'title' => 'CSS stylesheet name',
		'name' => 'basecss',
		'type' => 'text',
		'default' => 'homepage.css',
		'comment' => '(eg. "recent.css" - see templates/themes/recent for details)'
	);
	
	// Unique function name for building everything
	$theme['build_function'] = 'homepage_build';
	$theme['install_callback'] = 'homepage_install';

	if (!function_exists('homepage_install')) {
		function homepage_install($settings) {
			if (!is_numeric($settings['limit_images']) || $settings['limit_images'] < 0)
				return Array(false, '<strong>' . utf8tohtml($settings['limit_images']) . '</strong> is not a non-negative integer.');
			if (!is_numeric($settings['limit_posts']) || $settings['limit_posts'] < 0)
				return Array(false, '<strong>' . utf8tohtml($settings['limit_posts']) . '</strong> is not a non-negative integer.');
		}
	}
	
