<?php

/*
 *  Copyright (c) 2010-2013 Tinyboard Development Group
 */
require_once 'inc/bootstrap.php';
defined('TINYBOARD') or exit;

$twig = false;

function load_twig() {
	global $twig, $config;

	$loader = new Twig\Loader\FilesystemLoader($config['dir']['template']);
	$loader->setPaths($config['dir']['template']);
	$twig = new Twig\Environment($loader, array(
		'autoescape' => false,
		'cache' => is_writable('templates') || (is_dir('templates/cache') && is_writable('templates/cache')) ?
			new Twig_Cache_TinyboardFilesystem("{$config['dir']['template']}/cache") : false,
		'debug' => $config['debug'],
		'auto_reload' => $config['twig_auto_reload']
	));
	if ($config['debug'])
		$twig->addExtension(new \Twig\Extension\DebugExtension());
	$twig->addExtension(new Tinyboard());
	$twig->addExtension(new PhpMyAdmin\Twig\Extensions\I18nExtension());
}

function Element($templateFile, array $options) {
	global $config, $debug, $twig, $build_pages;
	
	if (!$twig)
		load_twig();
	
	if (function_exists('create_pm_header') && ((isset($options['mod']) && $options['mod']) || isset($options['__mod'])) && !preg_match('!^mod/!', $templateFile)) {
		$options['pm'] = create_pm_header();
	}
	
	if (isset($options['body']) && $config['debug']) {
		$_debug = $debug;
		
		if (isset($debug['start'])) {
			$_debug['time']['total'] = '~' . round((microtime(true) - $_debug['start']) * 1000, 2) . 'ms';
			$_debug['time']['init'] = '~' . round(($_debug['start_debug'] - $_debug['start']) * 1000, 2) . 'ms';
			unset($_debug['start']);
			unset($_debug['start_debug']);
		}
		if ($config['try_smarter'] && isset($build_pages) && !empty($build_pages))
			$_debug['build_pages'] = $build_pages;
		$_debug['included'] = get_included_files();
		$_debug['memory'] = round(memory_get_usage(true) / (1024 * 1024), 2) . ' MiB';
		$_debug['time']['db_queries'] = '~' . round($_debug['time']['db_queries'] * 1000, 2) . 'ms';
		$_debug['time']['exec'] = '~' . round($_debug['time']['exec'] * 1000, 2) . 'ms';
		$options['body'] .=
			'<h3>Debug</h3><pre style="white-space: pre-wrap;font-size: 10px;">' .
				str_replace("\n", '<br/>', utf8tohtml(print_r($_debug, true))) .
			'</pre>';
	}
	
	// Read the template file
	if (@file_get_contents("{$config['dir']['template']}/{$templateFile}")) {
		$body = $twig->render($templateFile, $options);
		
		if ($config['minify_html'] && preg_match('/\.html$/', $templateFile)) {
			$body = trim(preg_replace("/[\t\r\n]/", '', $body));
		}
		
		return $body;
	} else {
		throw new Exception("Template file '{$templateFile}' does not exist or is empty in '{$config['dir']['template']}'!");
	}
}

class Tinyboard extends Twig\Extension\AbstractExtension
{
	/**
	* Returns a list of filters to add to the existing list.
	*
	* @return array An array of filters
	*/
	public function getFilters()
	{
		return array(
			new Twig\TwigFilter('filesize', 'format_bytes'),
			new Twig\TwigFilter('truncate', 'twig_truncate_filter'),
			new Twig\TwigFilter('truncate_body', 'truncate'),
			new Twig\TwigFilter('truncate_filename', 'twig_filename_truncate_filter'),
			new Twig\TwigFilter('extension', 'twig_extension_filter'),
			new Twig\TwigFilter('sprintf', 'sprintf'),
			new Twig\TwigFilter('capcode', 'capcode'),
			new Twig\TwigFilter('remove_modifiers', 'remove_modifiers'),
			new Twig\TwigFilter('hasPermission', 'twig_hasPermission_filter'),
			new Twig\TwigFilter('date', 'twig_date_filter'),
			new Twig\TwigFilter('poster_id', 'poster_id'),
			new Twig\TwigFilter('count', 'count'),
			new Twig\TwigFilter('ago', 'ago'),
			new Twig\TwigFilter('until', 'until'),
			new Twig\TwigFilter('push', 'twig_push_filter'),
			new Twig\TwigFilter('bidi_cleanup', 'bidi_cleanup'),
			new Twig\TwigFilter('addslashes', 'addslashes'),
			new Twig\TwigFilter('cloak_ip', 'cloak_ip'),
			new Twig\TwigFilter('force_cloak_ip', 'force_cloak_ip'),
			new Twig\TwigFilter('cloak_mask', 'cloak_mask'),
			new Twig\TwigFilter('seconds_to_human', 'seconds_to_human'),
		);
	}
	
	/**
	* Returns a list of functions to add to the existing list.
	*
	* @return array An array of filters
	*/
	public function getFunctions()
	{
		return array(
			new Twig\TwigFunction('time', 'time'),
			new Twig\TwigFunction('floor', 'floor'),
			new Twig\TwigFunction('timezone', 'twig_timezone_function'),
			new Twig\TwigFunction('hiddenInputs', 'hiddenInputs'),
			new Twig\TwigFunction('hiddenInputsHash', 'hiddenInputsHash'),
			new Twig\TwigFunction('ratio', 'twig_ratio_function'),
			new Twig\TwigFunction('secure_link_confirm', 'twig_secure_link_confirm'),
			new Twig\TwigFunction('secure_link', 'twig_secure_link'),
			//twig_bitwise_and
			new Twig\TwigFunction('bitwise_and', 'twig_bitwise_and'),
			new Twig\TwigFunction('link_for', 'link_for'),
			new Twig\TwigFunction('ip_id', 'twig_get_ip_id'),
			new Twig\TwigFunction('ip_color_code', 'twig_get_ip_colorcode'),
			new Twig\TwigFunction('white_or_black_color', 'twig_white_or_black_color'),
			new Twig\TwigFunction('get_identifier_code_for_number', 'get_identifier_code_for_number')
		);
	}
	
	/**
	* Returns the name of the extension.
	*
	* @return string The extension name
	*/
	public function getName()
	{
		return 'tinyboard';
	}
}

function twig_timezone_function() {
	return 'Z';
}

function twig_push_filter($array, $value) {
	array_push($array, $value);
	return $array;
}

function twig_date_filter($date, $format) {
	return @gmstrftime($format, $date);
}

function twig_hasPermission_filter($mod, $permission, $board = null) {
	return hasPermission($permission, $board, $mod);
}

function twig_extension_filter($value, $case_insensitive = true) {
	$ext = mb_substr($value, mb_strrpos($value, '.') + 1);
	if($case_insensitive)
		$ext = mb_strtolower($ext);		
	return $ext;
}

function twig_sprintf_filter( $value, $var) {
	return sprintf($value, $var);
}

function twig_truncate_filter($value, $length = 30, $preserve = false, $separator = '…') {
	if (mb_strlen($value) > $length) {
		if ($preserve) {
			if (false !== ($breakpoint = mb_strpos($value, ' ', $length))) {
				$length = $breakpoint;
			}
		}
		return mb_substr($value, 0, $length) . $separator;
	}
	return $value;
}

function twig_filename_truncate_filter($value, $length = 30, $separator = '…') {
	if (mb_strlen($value) > $length) {
		$value = strrev($value);
		$array = array_reverse(explode(".", $value, 2));
		$array = array_map("strrev", $array);
		
		$filename = &$array[0];
		$extension = isset($array[1]) ? $array[1] : false;

		$filename = mb_substr($filename, 0, $length - ($extension ? mb_strlen($extension) + 1 : 0)) . $separator;

		return implode(".", $array);
	}
	return $value;
}

function twig_ratio_function($w, $h) {
	return fraction($w, $h, ':');
}
function twig_secure_link_confirm($text, $title, $confirm_message, $href) {
	global $config;

	return '<a onclick="if (event.which==2) return true;if (confirm(\'' . htmlentities(addslashes($confirm_message)) . '\')) document.location=\'?/' . htmlspecialchars(addslashes($href . '/' . make_secure_link_token($href))) . '\';return false;" title="' . htmlentities($title) . '" href="?/' . $href . '">' . $text . '</a>';
}
function twig_secure_link($href) {
	return $href . '/' . make_secure_link_token($href);
}

function twig_bitwise_and($a, $b) {
	return $a & $b;
}


function convert6BytesToChars($hash) {
    $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!^";
    
    $chunks = [];

    $bitOffset = 0;
    for ($i = 0; $i < 8; $i++) {
        $byteIndex = (int)($bitOffset / 8);
        $bitIndex = $bitOffset % 8;

        $chunk = ((ord($hash[$byteIndex]) << 8) | ord($hash[$byteIndex + 1])) >> (8 - $bitIndex);

        $chunk &= 0b00111111;

        $chunks[] = $chunk;

        $bitOffset += 6;
    }

    $result = "";

    foreach ($chunks as $chunk) {
        $result .= $charset[$chunk];
    }

    return $result;
}

function twig_get_ip_id($ip, $extra = 0) {
	$ipn = $ip  . "s9gu34hg934hgy394uhgy3";
	if ($extra != 0){
		$ipn = $ipn . $extra;
	}
	$hash = md5($ipn, true);
	$id = convert6BytesToChars($hash);
	return $id;
}

function twig_get_ip_colorcode($ip, $extra = 0) {
	//ChatGPT award
	// Calculate the MD5 hash

	$ipn = $ip  . "hE0IO4d2ItbeZKZzd1sjETyhZ1eJpy5O";
	if ($extra != 0){
		$ipn = $ipn . $extra;
	}
	$md5_hash = md5($ipn);
	
	// Convert the hexadecimal hash to binary
	$binary_hash = hex2bin($md5_hash);
	
	$byte_array = unpack("C", $binary_hash);

	// The result of unpack() is an array, and the first element contains the value of the first byte.
	$first_byte = $byte_array[1];

	

	
	$color_codes = array("#000000","#800000","#008000","#808000","#000080","#800080","#008080","#c0c0c0","#808080","#ff0000","#00ff00","#ffff00","#0000ff","#ff00ff","#00ffff","#ffffff","#000000","#00005f","#000087","#0000af","#0000d7","#0000ff","#005f00","#005f5f","#005f87","#005faf","#005fd7","#005fff","#008700","#00875f","#008787","#0087af","#0087d7","#0087ff","#00af00","#00af5f","#00af87","#00afaf","#00afd7","#00afff","#00d700","#00d75f","#00d787","#00d7af","#00d7d7","#00d7ff","#00ff00","#00ff5f","#00ff87","#00ffaf","#00ffd7","#00ffff","#5f0000","#5f005f","#5f0087","#5f00af","#5f00d7","#5f00ff","#5f5f00","#5f5f5f","#5f5f87","#5f5faf","#5f5fd7","#5f5fff","#5f8700","#5f875f","#5f8787","#5f87af","#5f87d7","#5f87ff","#5faf00","#5faf5f","#5faf87","#5fafaf","#5fafd7","#5fafff","#5fd700","#5fd75f","#5fd787","#5fd7af","#5fd7d7","#5fd7ff","#5fff00","#5fff5f","#5fff87","#5fffaf","#5fffd7","#5fffff","#870000","#87005f","#870087","#8700af","#8700d7","#8700ff","#875f00","#875f5f","#875f87","#875faf","#875fd7","#875fff","#878700","#87875f","#878787","#8787af","#8787d7","#8787ff","#87af00","#87af5f","#87af87","#87afaf","#87afd7","#87afff","#87d700","#87d75f","#87d787","#87d7af","#87d7d7","#87d7ff","#87ff00","#87ff5f","#87ff87","#87ffaf","#87ffd7","#87ffff","#af0000","#af005f","#af0087","#af00af","#af00d7","#af00ff","#af5f00","#af5f5f","#af5f87","#af5faf","#af5fd7","#af5fff","#af8700","#af875f","#af8787","#af87af","#af87d7","#af87ff","#afaf00","#afaf5f","#afaf87","#afafaf","#afafd7","#afafff","#afd700","#afd75f","#afd787","#afd7af","#afd7d7","#afd7ff","#afff00","#afff5f","#afff87","#afffaf","#afffd7","#afffff","#d70000","#d7005f","#d70087","#d700af","#d700d7","#d700ff","#d75f00","#d75f5f","#d75f87","#d75faf","#d75fd7","#d75fff","#d78700","#d7875f","#d78787","#d787af","#d787d7","#d787ff","#d7af00","#d7af5f","#d7af87","#d7afaf","#d7afd7","#d7afff","#d7d700","#d7d75f","#d7d787","#d7d7af","#d7d7d7","#d7d7ff","#d7ff00","#d7ff5f","#d7ff87","#d7ffaf","#d7ffd7","#d7ffff","#ff0000","#ff005f","#ff0087","#ff00af","#ff00d7","#ff00ff","#ff5f00","#ff5f5f","#ff5f87","#ff5faf","#ff5fd7","#ff5fff","#ff8700","#ff875f","#ff8787","#ff87af","#ff87d7","#ff87ff","#ffaf00","#ffaf5f","#ffaf87","#ffafaf","#ffafd7","#ffafff","#ffd700","#ffd75f","#ffd787","#ffd7af","#ffd7d7","#ffd7ff","#ffff00","#ffff5f","#ffff87","#ffffaf","#ffffd7","#ffffff","#080808","#121212","#1c1c1c","#262626","#303030","#3a3a3a","#444444","#4e4e4e","#585858","#606060","#666666","#767676","#808080","#8a8a8a","#949494","#9e9e9e","#a8a8a8","#b2b2b2","#bcbcbc","#c6c6c6","#d0d0d0","#dadada","#e4e4e4","#eeeeee");

	return $color_codes[$first_byte % count($color_codes)];
}


function twig_white_or_black_color($ip, $extra = 0) {
	$hexColor = twig_get_ip_colorcode($ip, $extra );
    // Remove the '#' symbol if present
    $hexColor = ltrim($hexColor, '#');

    // Convert hex to RGB
    $r = hexdec(substr($hexColor, 0, 2));
    $g = hexdec(substr($hexColor, 2, 2));
    $b = hexdec(substr($hexColor, 4, 2));

    // Calculate luminance using formula for relative luminance
    $luminance = (0.2126 * $r + 0.7152 * $g + 0.0722 * $b) / 255;

    // Determine the threshold for choosing black or white text
    $threshold = 0.5;

    // Return whether black or white text should be used based on luminance
    return $luminance > $threshold ? 'black' : 'white';
}
