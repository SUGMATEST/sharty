<?php

/*
 *  Copyright (c) 2010-2013 Tinyboard Development Group
 *  
 *  WARNING: This is a project-wide configuration file and is overwritten when upgrading to a newer
 *  version of vichan. Please leave this file unchanged, or it will be a lot harder for you to upgrade.
 *  If you would like to make instance-specific changes to your own setup, please use secrets.php.
 *
 *  This is the default configuration. You can copy values from here and use them in
 *  your secrets.php
 *
 *  You can also create per-board configuration files. Once a board is created, locate its directory and
 *  create a new file named config.php (eg. b/config.php). Like secrets.php, you can copy values
 *  from here and use them in your per-board configuration files.
 *
 *  Some directives are commented out. This is either because they are optional and examples, or because
 *  they are "optionally configurable", and given their default values by vichan's code later if unset.
 *
 *  More information: https://github.com/vichan-devel/vichan/wiki/config
 *
 *  vichan documentation: https://github.com/vichan-devel/vichan/wiki/ fuck niggers
 *
 */

	defined('TINYBOARD') or exit;

/*
 * =======================
 *  General/misc settings
 * =======================
 */

	// Global announcement -- the very simple version.
	// This used to be wrongly named $config['blotter'] (still exists as an alias).
	// $config['global_message'] = 'This is an important announcement!';
	$config['blotter'] = &$config['global_message'];

	// Automatically check if a newer version of vichan is available when an administrator logs in.
	$config['check_updates'] = false;
	// How often to check for updates
	$config['check_updates_time'] = 43200; // 12 hours

	// Shows some extra information at the bottom of pages. Good for development/debugging.
	$config['debug'] = false;
	// For development purposes. Displays (and "dies" on) all errors and warnings. Turn on with the above.
	$config['verbose_errors'] = false;
	// Warn about deprecations? See vichan-devel/vichan#363 and https://www.youtube.com/watch?v=9crnlHLVdno
	$config['deprecation_errors'] = false;
	// Skip cache in twig. this is already enabled with debug
	$config['twig_auto_reload'] = false;

	// EXPLAIN all SQL queries (when in debug mode).
	$config['debug_explain'] = false;

	// Directory where temporary files will be created.
	$config['tmp'] = sys_get_temp_dir();

	// The HTTP status code to use when redirecting. http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
	// Can be either 303 "See Other" or 302 "Found". (303 is more correct but both should work.)
	// There is really no reason for you to ever need to change this.
	$config['redirect_http'] = 303;

	// A tiny text file in the main directory indicating that the script has been ran and the board(s) have
	// been generated. This keeps the script from querying the database and causing strain when not needed.
	$config['has_installed'] = '.installed';

	// Use syslog() for logging all error messages and unauthorized login attempts.
	$config['syslog'] = false;

	// Use `host` via shell_exec() to lookup hostnames, avoiding query timeouts. May not work on your system.
	// Requires safe_mode to be disabled.
	$config['dns_system'] = false;

	// Check validity of the reverse DNS of IP addresses. Highly recommended.
	$config['fcrdns'] = true;

	// When executing most command-line tools (such as `convert` for ImageMagick image processing), add this
	// to the environment path (seperated by :).
	$config['shell_path'] = '/usr/local/bin';

/*
 * ====================
 *  Database settings
 * ====================
 */

	// Database driver (http://www.php.net/manual/en/pdo.drivers.php)
	// Only MySQL is supported by vichan at the moment, sorry.
	$config['db']['type'] = 'mysql';
	// Hostname, IP address or Unix socket (prefixed with ":")
	$config['db']['server'] = 'localhost';
	// Example: Unix socket
	// $config['db']['server'] = ':/tmp/mysql.sock';
	// Login
	$config['db']['user'] = '';
	$config['db']['password'] = '';
	// vichan database
	$config['db']['database'] = '';
	// Table prefix (optional)
	$config['db']['prefix'] = '';
	// Use a persistent database connection when possible
	$config['db']['persistent'] = false;
	// Anything more to add to the DSN string (eg. port=xxx;foo=bar)
	$config['db']['dsn'] = '';
	// Connection timeout duration in seconds
	$config['db']['timeout'] = 30;

/*
 * ====================
 *  Cache, lock and queue settings
 * ====================
 */

	/*
	 * On top of the static file caching system, you can enable the additional caching system which is
	 * designed to minimize SQL queries and can significantly increase speed when posting or using the 
	 * moderator interface. APC is the recommended method of caching.
	 *
	 * https://github.com/vichan-devel/vichan/wiki/cache
	 */

	// $config['cache']['enabled'] = 'php';
	// $config['cache']['enabled'] = 'xcache';
	// $config['cache']['enabled'] = 'apc';
	// $config['cache']['enabled'] = 'memcached';
	$config['cache']['enabled'] = 'redis';
	// $config['cache']['enabled'] = 'fs';

	// Timeout for cached objects such as posts and HTML.
	$config['cache']['timeout'] = 60 * 60 * 48; // 48 hours

	// Optional prefix if you're running multiple vichan instances on the same machine.
	$config['cache']['prefix'] = '';

	// Memcached servers to use. Read more: http://www.php.net/manual/en/memcached.addservers.php
	$config['cache']['memcached'] = array(
		array('localhost', 11211)
	);

	// Redis server to use. Location, port, password, database id.
	// Note that vichan may clear the database at times, so you may want to pick a database id just for
	// vichan to use.
	$config['cache']['redis'] = array('localhost', 6379, '', 1);

	// EXPERIMENTAL: Should we cache configs? Warning: this changes board behaviour, i'd say, a lot.
	// If you have any lambdas/includes present in your config, you should move them to instance-functions.php
	// (this file will be explicitly loaded during cache hit, but not during cache miss).
	$config['cache_config'] = false;

	// Define a lock driver.
	$config['lock']['enabled'] = 'fs';

	// Define a queue driver.
	$config['queue']['enabled'] = 'fs'; // xD

/*
 * ====================
 *  Cookie settings
 * ====================
 */

	// Used for moderation login.
	$config['cookies']['mod'] = 'mod';

	// Used for communicating with Javascript; telling it when posts were successful.
	$config['cookies']['js'] = 'serv';

	// Cookies path. Defaults to $config['root']. If $config['root'] is a URL, you need to set this. Should
	// be '/' or '/board/', depending on your installation.
	// $config['cookies']['path'] = '/';
	// Where to set the 'path' parameter to $config['cookies']['path'] when creating cookies. Recommended.
	$config['cookies']['jail'] = true;

	// How long should the cookies last (in seconds). Defines how long should moderators should remain logged
	// in (0 = browser session).
	$config['cookies']['expire'] = 60 * 60 * 24 * 30 * 6; // ~6 months

	// Make this something long and random for security.
	$config['cookies']['salt'] = 'abcdefghijklmnopqrstuvwxyz09123456789!@#$%^&*()';

	// Whether or not you can access the mod cookie in JavaScript. Most users should not need to change this.
	$config['cookies']['httponly'] = true;

	// Used to salt secure tripcodes ("##trip") and poster IDs (if enabled).
	$config['secure_trip_salt'] = ')(*&^%$#@!98765432190zyxwvutsrqponmlkjihgfedcba';

/*
 * ====================
 *  Flood/spam settings
 * ====================
 */

	/*
	 * To further prevent spam and abuse, you can use DNS blacklists (DNSBL). A DNSBL is a list of IP
	 * addresses published through the Internet Domain Name Service (DNS) either as a zone file that can be
	 * used by DNS server software, or as a live DNS zone that can be queried in real-time.
	 *
	 * Read more: https://github.com/vichan-devel/vichan/wiki/dnsbl
	 */

	// Prevents most Tor exit nodes from making posts. Recommended, as a lot of abuse comes from Tor because
	// of the strong anonymity associated with it.
	// Example: $config['dnsbl'][] = 'another.blacklist.net';
	// $config['dnsbl'][] = array('tor.dnsbl.sectoor.de', 1); //sectoor.de site is dead. the number stands for (an) ip adress(es) I guess. 

	// Replacement for sectoor.de
	$config['dnsbl'][] = array('rbl.efnetrbl.org', 0);

	// http://www.sorbs.net/using.shtml
	// $config['dnsbl'][] = array('dnsbl.sorbs.net', array(2, 3, 4, 5, 6, 7, 8, 9));

	// http://www.projecthoneypot.org/httpbl.php
	// $config['dnsbl'][] = array('<your access key>.%.dnsbl.httpbl.org', function($ip) {
	//	$octets = explode('.', $ip);
	//	
	//	// days since last activity
	//	if ($octets[1] > 14)
	//		return false;
	//	
	//	// "threat score" (http://www.projecthoneypot.org/threat_info.php)
	//	if ($octets[2] < 5)
	//		return false;
	//	
	//	return true;
	// }, 'dnsbl.httpbl.org'); // hide our access key

	// Skip checking certain IP addresses against blacklists (for troubleshooting or whatever)
	$config['dnsbl_exceptions'][] = '127.0.0.1';

	// To prevent bump attacks; returns the thread to last position after the last post is deleted.
	$config['anti_bump_flood'] = true;

	/*
	 * Introduction to vichan's spam filter:
	 *
	 * In simple terms, whenever a posting form on a page is generated (which happens whenever a
	 * post is made), vichan will add a random amount of hidden, obscure fields to it to
	 * confuse bots and upset hackers. These fields and their respective obscure values are
	 * validated upon posting with a 160-bit "hash". That hash can only be used as many times
	 * as you specify; otherwise, flooding bots could just keep reusing the same hash.
	 * Once a new set of inputs (and the hash) are generated, old hashes for the same thread
	 * and board are set to expire. Because you have to reload the page to get the new set
	 * of inputs and hash, if they expire too quickly and more than one person is viewing the
	 * page at a given time, vichan would return false positives (depending on how long the
	 * user sits on the page before posting). If your imageboard is quite fast/popular, set
	 * $config['spam']['hidden_inputs_max_pass'] and $config['spam']['hidden_inputs_expire'] to
	 * something higher to avoid false positives.
	 *
	 * See also: https://github.com/vichan-devel/vichan/wiki/your_request_looks_automated
	 *
	 */

	// Number of hidden fields to generate.
	$config['spam']['hidden_inputs_min'] = 4;
	$config['spam']['hidden_inputs_max'] = 12;

	// How many times can a "hash" be used to post?
	$config['spam']['hidden_inputs_max_pass'] = 12;

	// How soon after regeneration do hashes expire (in seconds)?
	$config['spam']['hidden_inputs_expire'] = 60 * 60 * 3; // three hours

	// Whether to use Unicode characters in hidden input names and values.
	$config['spam']['unicode'] = true;

	// These are fields used to confuse the bots. Make sure they aren't actually used by vichan, or it won't work.
	$config['spam']['hidden_input_names'] = array(
		'user',
		'username',
		'login',
		'search',
		'q',
		'url',
		'firstname',
		'lastname',
		'text',
		'message'
	);

	// Always update this when adding new valid fields to the post form, or EVERYTHING WILL BE DETECTED AS SPAM!
	$config['spam']['valid_inputs'] = array(
		'hash',
		'board',
		'thread',
		'mod',
		'name',
		'email',
		'subject',
		'post',
		'body',
		'password',
		'sticky',
		'lock',
		'raw',
		'embed',
		'g-recaptcha-response',
                'g-recaptcha-response-v3',
		'h-captcha-response',
		'captcha_cookie',
		'captcha_text',
		'spoiler',
		'page',
		'file_url',
		'json_response',
		'user_flag',
		'no_country',
		'tag',
		"captchaChallenge",
		"captchaNonce",
		'_KAPTCHA',
		'_KAPTCHA_NOJS',
		'_KAPTCHA_KEY',
		"x",
		"y",
		"guid",
		"captcha_x",
		"captcha_y",
		"captcha_guid",
		"show_ids",
		"images_only",
		"geo_flags",
	);

	//A panic button of some sorts, which bans any new ips from posting if there is no post history for them on /soy/.
	$config['mandate_soy_history'] = false;

	// Enable reCaptcha to make spam even harder. Rarely necessary.
	$config['recaptcha'] = false;
	// Enable hCaptcha
	$config['hcaptcha'] = false;
	// Enable POWCaptcha
	$config['powcaptcha'] = false;

	// Public and private key pair from https://www.google.com/recaptcha/admin/create
	$config['recaptcha_public'] = '6Lc4uZ8nAAAAAODtCjTlGN5g0MKV5TFksAH6VaGA';
	$config['recaptcha_private'] = '6Lc4uZ8nAAAAAKLsW4Dhsc0Cdi6uk4LIekXZvjOQ';

	// Public and private key pair from https://www.google.com/recaptcha/admin/create for recaptchav3
	$config['hcaptcha_public'] = 'c9fe13d9-efc5-4e17-b2c9-805de852c782';
	$config['hcaptcha_private'] = '0x628037fF874A023e542e93B78071499E56898ff3';

	// Enable Custom Captcha you need to change a couple of settings 
	//Read more at: /inc/captcha/readme.md
	$config['captcha'] = array();

	// Enable custom captcha provider
	$config['captcha']['enabled'] = false;

	//New thread captcha
 	//Require solving a captcha to post a thread. 
 	//Default off.
 	$config['new_thread_capt'] = false;

	// Custom captcha get provider path (if not working get the absolute path aka your url.)
	$config['captcha']['provider_get'] = '../inc/captcha/entrypoint.php';
	// Custom captcha check provider path
	$config['captcha']['provider_check'] = '../inc/captcha/entrypoint.php';

	// Custom captcha extra field (eg. charset)
	$config['captcha']['extra'] = 'abcdefghijklmnopqrstuvwxyz';
	
	// Ability to lock a board for normal users and still allow mods to post.  Could also be useful for making an archive board
	$config['board_locked'] = false;

	// Prevent normal users from making threads whilst allowing replies
	$config['board_thread_creation_locked'] = false;

	// If poster's proxy supplies X-Forwarded-For header, check if poster's real IP is banned.
	$config['proxy_check'] = false;

	// If poster's proxy supplies X-Forwarded-For header, save it for further inspection and/or filtering.
	$config['proxy_save'] = false;
	//fuck niggers
	/*
	 * Custom filters detect certain posts and reject/ban accordingly. They are made up of a condition and an
	 * action (for when ALL conditions are met). As every single post has to be put through each filter,
	 * having hundreds probably isn't ideal as it could slow things down.
	 *
	 * By default, the custom filters array is populated with basic flood prevention conditions. This
	 * includes forcing users to wait at least 5 seconds between posts. To disable (or amend) these flood
	 * prevention settings, you will need to empty the $config['filters'] array first. You can do so by
	 * adding "$config['filters'] = array();" to inc/instance-config.php. Basic flood prevention used to be
	 * controlled solely by config variables such as $config['flood_time'] and $config['flood_time_ip'], and
	 * it still is, as long as you leave the relevant $config['filters'] intact. These old config variables
	 * still exist for backwards-compatability and general convenience.
	 *
	 * Read more: https://github.com/vichan-devel/vichan/wiki/flood_filters
	 */

	// Minimum time between between each post by the same IP address.
	$config['flood_time'] = 10;
	// Minimum time between between each post with the exact same content AND same IP address.
	$config['flood_time_ip'] = 120;
	// Same as above but by a different IP address. (Same content, not necessarily same IP address.)
	$config['flood_time_same'] = 30;

	// Minimum time between bumps by the same IP
	$config['bump_cooldown'] = 90;
	// Minimum time between super sages by the same IP
	$config['slide_cooldown'] = 30 * 60;

	// Adds a fake lag to making posts ranging from 0-X seconds, good for stopping GET scripts
	$config['artifical_posting_lag'] = 0;

	// Minimum time between posts by the same IP address (all boards).
	$config['filters'][] = array(
		'condition' => array(
			'flood-match' => array('ip'), // Only match IP address
			'flood-time' => &$config['flood_time']
		),
		'action' => 'reject',
		'message' => &$config['error']['flood']
	);

	// Minimum time between posts by the same IP address with the same text.
	$config['filters'][] = array(
		'condition' => array(
			'flood-match' => array('ip', 'body'), // Match IP address and post body
			'flood-time' => &$config['flood_time_ip'],
			'!body' => '/^$/', // Post body is NOT empty
		),
		'action' => 'reject',
		'message' => &$config['error']['flood']
	);

	// Minimum time between posts with the same text. (Same content, but not always the same IP address.)
	$config['filters'][] = array(
		'condition' => array(
			'flood-match' => array('body'), // Match only post body
			'flood-time' => &$config['flood_time_same']
		),
		'action' => 'reject',
		'message' => &$config['error']['flood']
	);

	//max threads per hour
	$config['filters'][] = array(
		'condition' => array(
			'custom' => 'check_thread_limit'
		),
		'action' => 'reject',
		'message' => &$config['error']['too_many_threads']
	);

	// Example: Minimum time between posts with the same file hash.
	// $config['filters'][] = array(
	// 	'condition' => array(
	// 		'flood-match' => array('file'), // Match file hash
	// 		'flood-time' => 60 * 2 // 2 minutes minimum
	// 	),
	// 	'action' => 'reject',
	// 	'message' => &$config['error']['flood']
	// );

	// Example: Use the "flood-count" condition to only match if the user has made at least two posts with
	// the same content and IP address in the past 2 minutes.
	// $config['filters'][] = array(
	// 	'condition' => array(
	// 		'flood-match' => array('ip', 'body'), // Match IP address and post body
	// 		'flood-time' => 60 * 2, // 2 minutes
	// 		'flood-count' => 2 // At least two recent posts
	// 	),
	// 	'!body' => '/^$/',
	// 	'action' => 'reject',
	// 	'message' => &$config['error']['flood']
	// );

	// Example: Blocking an imaginary known spammer, who keeps posting a reply with the name "surgeon",
	// ending his posts with "regards, the surgeon" or similar.
	// $config['filters'][] = array(
	// 	'condition' => array(
	// 		'name' => '/^surgeon$/',
	// 		'body' => '/regards,\s+(the )?surgeon$/i',
	// 		'OP' => false
	// 	),
	// 	'action' => 'reject',
	// 	'message' => 'Go away, spammer.'
	// );

	// Example: Same as above, but issuing a 3-hour ban instead of just reject the post and
	// add an IP note with the message body
	// $config['filters'][] = array(
	// 	'condition' => array(
	// 		'name' => '/^surgeon$/',
	// 		'body' => '/regards,\s+(the )?surgeon$/i',
	// 		'OP' => false
	// 	),
	// 	'action' => 'ban',
	//	'add_note' => true,
	// 	'expires' => 60 * 60 * 3, // 3 hours
	// 	'reason' => 'Go away, spammer.'
	// );

	// Example: PHP 5.3+ (anonymous functions)
	// There is also a "custom" condition, making the possibilities of this feature pretty much endless.
	// This is a bad example, because there is already a "name" condition built-in.
	// $config['filters'][] = array(
	// 	'condition' => array(
	// 		'body' => '/h$/i',
	// 		'OP' => false,
	// 		'custom' => function($post) {
	// 			if($post['name'] == 'Anonymous')
	// 				return true;
	// 			else
	// 				return false;
	// 		}
	// 	),
	// 	'action' => 'reject'
	// );
	
	// Filter flood prevention conditions ("flood-match") depend on a table which contains a cache of recent
	// posts across all boards. This table is automatically purged of older posts, determining the maximum
	// "age" by looking at each filter. However, when determining the maximum age, vichan does not look
	// outside the current board. This means that if you have a special flood condition for a specific board
	// (contained in a board configuration file) which has a flood-time greater than any of those in the
	// global configuration, you need to set the following variable to the maximum flood-time condition value.
	// Set to -1 to disable.
	// $config['flood_cache'] = 60 * 60 * 24; // 24 hours
	$config['flood_cache'] = -1;

/*
 * ====================
 *  Post settings
 * ====================
 */

	// Do you need a body for your reply posts?
	$config['force_body'] = false;
	// Do you need a body for new threads?
	$config['force_body_op'] = true;
	// Require an image for threads?
	$config['force_image_op'] = true;

	// Strip superfluous new lines at the end of a post.
	$config['strip_superfluous_returns'] = true;
	/// Strip combining characters from Unicode strings (eg. "Zalgo").  This will impact some non-English languages.
	$config['strip_combining_chars'] = true;
    // Maximum number of combining characters in a row allowed in Unicode strings so that they can still be used in moderation.
    // Requires $config['strip_combining_chars'] = true;
    $config['max_combining_chars'] = 3;

	// Maximum numbers of threads that can be created every hour on a board. Set to false to disable
	$config['max_threads_per_hour'] = 150;
	// Maximum post body length.
	$config['max_body'] = 1800;
	// Maximum number of lines allowed in a post.
	$config['maximum_lines'] = 100;
	// Maximum number of post body lines to show on the index page.
	$config['body_truncate'] = 10;
	// Maximum number of characters to show on the index page.
	$config['body_truncate_char'] = 2500;

	// Typically spambots try to post many links. Refuse a post with X links?
	$config['max_links'] = 2000;
	// Maximum number of cites per post (prevents abuse, as more citations mean more database queries).
	$config['max_cites'] = 60;
	// Maximum number of cross-board links/citations per post.
	$config['max_cross'] = $config['max_cites'];

	// Track post citations (>>XX). Rebuilds posts after a cited post is deleted, removing broken links.
	// Puts a little more load on the database.
	$config['track_cites'] = true;

	// Maximum filename length (will be truncated).
	$config['max_filename_len'] = 255;
	// Maximum filename length to display (the rest can be viewed upon mouseover).
	$config['max_filename_display'] = 30;

	// Allow users to delete their own posts?
	$config['allow_delete'] = true;
	// Allow users to delete files from their own posts?
	$config['allow_file_delete'] = false;
	// How long after posting should you have to wait before being able to delete that post? (In seconds.)
	$config['delete_time'] = 1;
	// How long should a user be able to delete their post for? (In seconds. 0 to disable.)
	$config['max_delete_time'] = 300; //Ronald change then ROOT change
	// Reply limit (stops bumping thread when this is reached).
	$config['reply_limit'] = 24000;

	// Image hard limit (stops allowing new image replies when this is reached if not zero).
	$config['image_hard_limit'] = 0;
	// Reply hard limit (stops allowing new replies when this is reached if not zero).
	$config['reply_hard_limit'] = 0;


	$config['robot_enable'] = false;
	// Strip repeating characters when making hashes.
	$config['robot_strip_repeating'] = true;
	// Enabled mutes? vichan uses ROBOT9000's original 2^x implementation where x is the number of times
	// you have been muted in the past.
	$config['robot_mute'] = true;
	// How long before vichan forgets about a mute?
	$config['robot_mute_hour'] = 336; // 2 weeks
	// If you want to alter the algorithm a bit. Default value is 2.
	$config['robot_mute_multiplier'] = 2; // (n^x where x is the number of previous mutes)
	$config['robot_mute_descritpion'] = _('You have been muted for unoriginal content.');

	// Automatically convert things like "..." to Unicode characters ("Ö").
	$config['auto_unicode'] = true;
	// Whether to turn URLs into functional links.
	$config['markup_urls'] = true;

	// Optional URL prefix for links (eg. "http://anonym.to/?").
	$config['link_prefix'] = '';
	$config['url_ads'] = &$config['link_prefix'];	 // leave alias

	// Allow "uploading" images via URL as well. Users can enter the URL of the image and then vichan will
	// download it. Not usually recommended.
	$config['allow_upload_by_url'] = false;
	// The timeout for the above, in seconds.
	$config['upload_by_url_timeout'] = 15;

	// Enable early 404? With default settings, a thread would 404 if it was to leave page 3, if it had less
	// than 3 replies.
	$config['early_404'] = false;

	$config['early_404_page'] = 35;
	$config['early_404_replies'] = 5;
	$config['early_404_staged'] = false;

	// Block posting from Tor?
	$config['block_tor_posting'] = true;
	// Block uploading from Tor?
	$config['block_tor_uploads'] = false;
	// Block embedding from Tor?
	$config['block_tor_embeds'] = false;
	// Give posts from Tor a signature
	$config['tor_signature'] = false;

	// Block posting from VPNs?
	$config['block_vpn_posting'] = false;
	// Block embedding from VPNs?
	$config['block_vpn_embeds'] = true;
	// Block uploading from VPNs?
	$config['block_vpn_uploads'] = true;

	// Only allow posters with passes to post
	$config['pass_only'] = false;

	// Only allow posting from desktops
	$config['desktop_only'] = false;

	// Country code blacklist. Format is lowercase ISO 3166-1 alpha-2
	$config['blocked_countries'] = array();
	// Country code whitelist, same format as the blacklist, disabled by default
	$config['allowed_countries'] = false;

	$config['blocked_states'] = array();
	$config['allowed_states'] = false;

	$config['blocked_locales'] = array();

	// A wordfilter (sometimes referred to as just a "filter" or "censor") automatically scans usersí posts
	// as they are submitted and changes or censors particular words or phrases.

	// For a normal string replacement:
	// $config['wordfilters'][] = array('cat', 'dog');	
	// Advanced raplcement (regular expressions):
	// $config['wordfilters'][] = array('/ca[rt]/', 'dog', true); // 'true' means it's a regular expression

	// Always act as if the user had typed "noko" into the email field.
	$config['always_noko'] = true;

	// Example: Custom tripcodes. The below example makes a tripcode of "#test123" evaluate to "!HelloWorld".
	// $config['custom_tripcode']['#test123'] = '!HelloWorld';
	// Example: Custom secure tripcode.
	// $config['custom_tripcode']['##securetrip'] = '!!somethingelse';

	// Allow users to mark their image as a "spoiler" when posting. The thumbnail will be replaced with a
	// static spoiler image instead (see $config['spoiler_image']).
	$config['spoiler_images'] = true;

	// With the following, you can disable certain superfluous fields or enable "forced anonymous".

	// When true, all names will be set to $config['anonymous']. Set this to 'selectbox' to have a selectbox instead.
	$config['field_disable_name'] = false;
	$config['selectable_names'] = ['Chud', 'Soyjak', 'Cobson', 'Feraljak'];
	$config['tripcodes_disabled'] = true;
	// When true, there will be no email field.
	$config['field_disable_email'] = false;
	// When true, there will be no subject field.
	$config['field_disable_subject'] = false;
	// When true, there will be no subject field for replies.
	$config['field_disable_reply_subject'] = false;
	// When true, a blank password will be used for files (not usable for deletion).
	$config['field_disable_password'] = false;

	// When true, users are instead presented a selectbox for email. Contains, blank, noko and sage.
	$config['field_email_selectbox'] = false;

	// When true, the sage won't be displayed
	$config['hide_sage'] = false;

	// Don't display user's email when it's not "sage"
	$config['hide_email'] = false;

	// Allow users to post as "Anonymous" and bypass things like post IDs
	$config['allow_anonymous_email'] = true;

	// Attach country flags to posts.
	$config['country_flags'] = false;
	// Use state flags instead of the American flag for American posters
	$config['state_flags'] = false;

	//$config['freeze_posts'] = 1731912000;

	// Allow the user to decide whether or not he wants to display his country
	$config['allow_no_country'] = false;
	// Allow the user to optionally display his state instead of his country. Enabling $config['state_flags'] overrides this and forces state flags
	$config['optional_state_flags'] = true;

	// Load all country flags from one file
	$config['country_flags_condensed'] = false;
	$config['country_flags_condensed_css'] = 'static/flags/flags.css';

	// Allow the user choose a /pol/-like user_flag that will be shown in the post. For the user flags, please be aware
	// that you will have to disable BOTH country_flags and contry_flags_condensed optimization (at least on a board
	// where they are enabled).
	$config['user_flag'] = false;

	// List of user_flag the user can choose. Flags must be placed in the directory set by $config['uri_flags']
	/*
	$config['user_flags'] = array (
		'soot' => 'Sootist',
        'pirate' => 'Captain Coalist',
		'kuz' => 'Kuzist',
        'il' => 'Maxist',
        'doll' => 'Dollist',
        'lgbt' => 'Redist',
		'soyumverite' => 'Soyumverite',
		'froot' => 'Frootist'
	);*/

	// Require selecting a user flag to post
	$config['require_user_flag'] = false;

	// Allow dice rolling: an email field of the form "dice XdY+/-Z" will result in X Y-sided dice rolled and summed,
	// with the modifier Z added, with the result displayed at the top of the post body.
	$config['allow_roll'] = false;

	// Use semantic URLs for threads, like /b/res/12345/daily-programming-thread.html
	$config['slugify'] = false;

	// Max size for slugs
	$config['slug_max_size'] = 80;

	// Allow creating polls
	$config['enable_polls'] = true;
	// Maximum amount of choices for polls created by regular users
	$config['max_poll_choices'] = 30;
	// Maximum amount of characters for an individual poll choice's text
	$config['max_poll_choice_length'] = 25;

	// Change name to unique identifier on ## Mod posts
	$config['mod_ids'] = true;
	// Force mods to tripfag with their unique identifiers
	$config['force_mod_ids'] = false;

/*
* ====================
*  Ban settings
* ====================
*/

	// Require users to see the ban page at least once for a ban even if it has since expired.
	$config['require_ban_view'] = true;

	// Show the post the user was banned for on the "You are banned" page.
	$config['ban_show_post'] = true;

	// Optional HTML to append to "You are banned" pages. For example, you could include instructions and/or
	// a link to an email address or IRC chat room to appeal the ban.
	$config['ban_page_extra'] = '<b>Explain why you believe you should be unbanned. Rude, poorly written, or offensive appeals will be rejected. Submitting an appeal does not guarantee your ban will be lifted prior to its listed expiration date.</b>';

	// Allow users to appeal bans through vichan.
	$config['ban_appeals'] = true;

	// Max characters per ban appeal
	$config['ban_appeals_max_characters'] = 1000;

	// Do not allow users to appeal bans that are shorter than this length (in seconds).
	$config['ban_appeals_min_length'] = 3600; // 1 hour

	// Do not allow users to appeal bans younger than this.
	$config['ban_appeals_min_age'] = 180; // 3 minutes

	// How many ban appeals can be made for a single ban?
	$config['ban_appeals_max'] = 32; // high because we have a button to make bans unappealable

	// Show moderator name on ban page.
	$config['show_modname'] = false;

	// Fields to use for automatically creating integrity bans
	$config['integrity_ban_fields'] = 'cd,dm,hc,tz,ww,wh,lan,loc,cf';

	// Fields to use when searching for IPs by integrity data
	$config['integrity_search_fields'] = 'ww,wh,dpr,tz,lan,loc,hc,ur,cf,np,pdc,ss,lsf';

/*
 * ====================
 *  Markup settings
 * ====================
 */

	// "Wiki" markup syntax ($config['wiki_markup'] in pervious versions):
	$config['markup'][] = array("/'''(.+?)'''/", "<strong>\$1</strong>");
	$config['markup'][] = array("/''(.+?)''/", "<em>\$1</em>");
	$config['markup'][] = array("/\*\*(.+?)\*\*/", "<span class=\"spoiler\">\$1</span>");
	$config['markup'][] = array("/==(.+?)==/", "<span class=\"heading\">$1</span>");
	//$config['markup'][] = array("/\[latex\](.+?)\[\/latex\]/", "<div class=\"math-container\">\$1</div>");
	//$config['markup'][] = array("/\$\$(.+?)\$\$/", "<div class=\"math-container\">\$1</div>");
	//$config['markup'][] = array("/\\\\\[(.+?)\\\\\]/", "<div class=\"math-container\">\$1</div>");
	// Code markup. This should be set to a regular expression, using tags you want to use. Examples:
	// "/\[code\](.*?)\[\/code\]/is"
	// "/```([a-z0-9-]{0,20})\n(.*?)\n?```\n?/s"
	$config['markup_code'] = false;

	// Repair markup with HTML Tidy. This may be slower, but it solves nesting mistakes. vichan, at the
	// time of writing this, can not prevent out-of-order markup tags (eg. "**''test**'') without help from
	// HTML Tidy.
	$config['markup_repair_tidy'] = false;

	// Use 'bare' config option of tidy::repairString.
	// This option replaces some punctuation marks with their ASCII counterparts.
	// Dashes are replaced with (single) hyphens, for example.
	$config['markup_repair_tidy_bare'] = true;

	// Always regenerate markup. This isn't recommended and should only be used for debugging; by default,
	// vichan only parses post markup when it needs to, and keeps post-markup HTML in the database. This
	// will significantly impact performance when enabled.
	$config['always_regenerate_markup'] = false;

/*
 * ====================
 *  Image settings
 * ====================
 */
	// Maximum number of images allowed. Increasing this number enabled multi image.
	// If you make it more than 1, make sure to enable the below script for the post form to change.
	// $config['additional_javascript'][] = 'js/multi-image.js';
	$config['max_images'] = 4;

	// Method to use for determing the max filesize. 
	// "split" means that your max filesize is split between the images. For example, if your max filesize
	// is 2MB, the filesizes of all files must add up to 2MB for it to work. 
	// "each" means that each file can be 2MB, so if your max_images is 3, each post could contain 6MB of 
	// images. "split" is recommended.
	$config['multiimage_method'] = 'split';

	// For resizing, maximum thumbnail dimensions.
	$config['thumb_width'] = 255;
	$config['thumb_height'] = 255;
	// Maximum thumbnail dimensions for thread (OP) images.
	$config['thumb_op_width'] = 255;
	$config['thumb_op_height'] = 255;

	// Thumbnail extension ("png" recommended). Leave this empty if you want the extension to be inherited
	// from the uploaded file.
	$config['thumb_ext'] = 'webp';

	// Maximum amount of animated GIF frames to resize (more frames can mean more processing power). A value
	// of "1" means thumbnails will not be animated. Requires $config['thumb_ext'] to be 'gif' (or blank) and
	//  $config['thumb_method'] to be 'imagick', 'convert', or 'convert+gifsicle'. This value is not
	// respected by 'convert'; will just resize all frames if this is > 1.
	$config['thumb_keep_animation_frames'] = 600;

	/*
	 * Thumbnailing method:
	 *
	 *   'gd'		   PHP GD (default). Only handles the most basic image formats (GIF, JPEG, PNG).
	 *				  GD is a prerequisite for vichan no matter what method you choose.
	 *
	 *   'imagick'	  PHP's ImageMagick bindings. Fast and efficient, supporting many image formats. 
	 *				  A few minor bugs. http://pecl.php.net/package/imagick
	 *
	 *   'convert'	  The command line version of ImageMagick (`convert`). Fixes most of the bugs in
	 *				  PHP Imagick. `convert` produces the best still thumbnails and is highly recommended.
	 *
	 *   'gm'		   GraphicsMagick (`gm`) is a fork of ImageMagick with many improvements. It is more
	 *				  efficient and gets thumbnailing done using fewer resources.
	 *
	 *   'convert+gifscale'
	 *	OR  'gm+gifsicle'  Same as above, with the exception of using `gifsicle` (command line application)
	 *					   instead of `convert` for resizing GIFs. It's faster and resulting animated
	 *					   thumbnails have less artifacts than if resized with ImageMagick.
	 */
	// 'libvips' mogs all of the above btw
	$config['thumb_method'] = 'libvips';
	// $config['thumb_method'] = 'convert';

	// Command-line options passed to ImageMagick when using `convert` for thumbnailing. Don't touch the
	// placement of "%s" and "%d".
	$config['convert_args'] = '-size %dx%d %s -thumbnail %dx%d -auto-orient +profile "*" %s';

	// Strip EXIF metadata from JPEG files.
	$config['strip_exif'] = true;
	// Use the command-line `exiftool` tool to strip EXIF metadata without decompressing/recompressing JPEGs.
	// Ignored when $config['redraw_image'] is true. This is also used to adjust the Orientation tag when
	//  $config['strip_exif'] is false and $config['convert_manual_orient'] is true.
	$config['use_exiftool'] = false;
	
	// Redraw the image to strip any excess data (commonly ZIP archives) WARNING: This might strip the
	// animation of GIFs, depending on the chosen thumbnailing method. It also requires recompressing
	// the image, so more processing power is required.
	$config['redraw_image'] = true;
	
	// Automatically correct the orientation of JPEG files using -auto-orient in `convert`. This only works
	// when `convert` or `gm` is selected for thumbnailing. Again, requires more processing power because
	// this basically does the same thing as $config['redraw_image']. (If $config['redraw_image'] is enabled,
	// this value doesn't matter as $config['redraw_image'] attempts to correct orientation too.)
	$config['convert_auto_orient'] = false;
	
	// Is your version of ImageMagick or GraphicsMagick old? Older versions may not include the -auto-orient
	// switch. This is a manual replacement for that switch. This is independent from the above switch;
	// -auto-orrient is applied when thumbnailing too.
	$config['convert_manual_orient'] = false;

	// Regular expression to check for an XSS exploit with IE 6 and 7. To disable, set to false.
	// Details: https://github.com/savetheinternet/Tinyboard/issues/20
	$config['ie_mime_type_detection'] = '/<(?:body|head|html|img|plaintext|pre|script|table|title|a href|channel|scriptlet)/i';

	// Allowed image file extensions.
	$config['allowed_ext'][] = 'jpg';
	$config['allowed_ext'][] = 'jpeg';
	$config['allowed_ext'][] = 'jfif';
	//$config['allowed_ext'][] = 'bmp';
	$config['allowed_ext'][] = 'gif';
	$config['allowed_ext'][] = 'png';
	//$config['allowed_ext'][] = 'bmp';
	// $config['allowed_ext'][] = 'svg';
	$config['allowed_ext'][] = 'webp';

	// Allowed extensions for OP. Inherits from the above setting if set to false. Otherwise, it overrides both allowed_ext and
	// allowed_ext_files (filetypes for downloadable files should be set in allowed_ext_files as well). This setting is useful
	// for creating fileboards.
	$config['allowed_ext_op'] = false;

	// Allowed additional file extensions (not images; downloadable files).
	$config['allowed_ext_files'][] = 'txt';
	$config['allowed_ext_files'][] = 'css';
	//$config['allowed_ext_files'][] = 'svg';
	$config['allowed_ext_files'][] = 'mp4';
	$config['allowed_ext_files'][] = 'm4a';
	$config['allowed_ext_files'][] = 'mp3';

        $config['allowed_ext_files'][] = 'wav';
	$config['allowed_ext_files'][] = 'flac';
	$config['allowed_ext_files'][] = 'pdf';
	$config['allowed_ext_files'][] = 'mov';
	$config['allowed_ext_files'][] = 'webm';
	$config['allowed_ext_files'][] = 'swf';
	//$config['allowed_ext_files'][] = 'mkv';

	$config['video_ext'] = array();
	$config['video_ext'][] = 'mp4';
	$config['video_ext'][] = 'webm';
	$config['video_ext'][] = 'mov';
	$config['video_ext'][] = 'm4a';
	$config['video_ext'][] = 'mp3';
	$config['video_ext'][] = 'wav';
	$config['video_ext'][] = 'flac';

	// An alternative function for generating image filenames, instead of the default UNIX timestamp.
	// $config['filename_func'] = function($post) {
	//	  return sprintf("%s", time() . substr(microtime(), 2, 3));
	// };

	// Thumbnail to use for the non-image file uploads.
	$config['file_icons']['default'] = 'file.png';
	$config['file_icons']['zip'] = 'zip.png';
	$config['file_icons']['swf'] = 'swf.png';
	$config['file_icons']['mp3'] = 'speaker.gif';
        $config['file_icons']['wav'] = 'speaker.gif';
	$config['file_icons']['flac'] = 'speaker.gif';
	$config['file_icons']['m4a'] = 'speaker.gif';
	//$config['file_icons']['webm'] = 'video.png';
	//$config['file_icons']['mp4'] = 'video.png';
	// Example: Custom thumbnail for certain file extension.
	// $config['file_icons']['extension'] = 'some_file.png';

	// Location of above images.
	$config['file_thumb'] = 'static/%s';
	// Location of thumbnail to use for spoiler images.
	$config['spoiler_image'] = 'static/spoiler-gem2.png';
	// Location of thumbnail to use for deleted images.
	$config['image_deleted'] = 'static/deleted.png';
	// Location of thumbnail to use for media pending approval.
	$config['approval_image'] = 'static/approval/classic.png';

	// When a thumbnailed image is going to be the same (in dimension), just copy the entire file and use
	// that as a thumbnail instead of resizing/redrawing.
	$config['minimum_copy_resize'] = false;

	// Maximum image upload size in bytes.
	$config['max_filesize'] = 50 * 1024 * 1024; // 50MB
	// Maximum image dimensions.
	$config['max_width'] = 10000;
	$config['max_height'] = $config['max_width'];
	// Reject duplicate image uploads.
	$config['image_reject_repost'] = false;
	// Reject duplicate image uploads within the same thread. Doesn't change anything if
	//  $config['image_reject_repost'] is true.
	$config['image_reject_repost_in_thread'] = false;

	// Maximum amount of bytes a user's files can consume before they are prevented from uploading any more
	$config['max_filesize_across_posts'] = 10000 * 1024 * 1024; // 10000MB

	// Display the aspect ratio of uploaded files.
	$config['show_ratio'] = false;
	// Display the file's original filename.
	$config['show_filename'] = true;

	// WebM Settings
	$config['webm']['use_ffmpeg'] = true;
	$config['webm']['allow_audio'] = true;
	$config['webm']['max_length'] = 72000;
	$config['webm']['ffmpeg_path'] = 'ffmpeg';
	$config['webm']['ffprobe_path'] = 'ffprobe';

	// Display image identification links for ImgOps, regex.info/exif, Google Images and iqdb.
	$config['image_identification'] = true;
	// Which of the identification links to display. Only works if $config['image_identification'] is true.
	$config['image_identification_imgops'] = true;
	$config['image_identification_exif'] = false;
	$config['image_identification_google'] = false;
	$config['image_identification_yandex'] = false;
	// Anime/manga search engine.
	$config['image_identification_iqdb'] = false;
	
	// Set this to true if you're using a BSD
	$config['bsd_md5'] = false;

	// Set this to true if you're using Linux and you can execute `md5sum` binary.
	$config['gnu_md5'] = false;

	// Use Tesseract OCR to retrieve text from images, so you can use it as a spamfilter.
	$config['tesseract_ocr'] = false;

	// Tesseract parameters
	$config['tesseract_params'] = '';

	// Tesseract preprocess command
	$config['tesseract_preprocess_command'] = 'convert -monochrome %s -';

	// Number of posts in a "View Last X Posts" page
	$config['noko50_count'] = 50;
	// Number of posts a thread needs before it gets a "View Last X Posts" page.
	// Set to an arbitrarily large value to disable.
	$config['noko50_min'] = 100;
/*
 * ====================
 *  Board settings
 * ====================
 */

	// Maximum amount of threads to display per page.
	$config['threads_per_page'] = 15;
	// Maximum number of pages. Content past the last page is automatically purged.
	$config['max_pages'] = 40;
	// Replies to show per thread on the board index page.
	$config['threads_preview'] = 5;
	// Same as above, but for stickied threads.
	$config['threads_preview_sticky'] = 1;

	// How to display the URI of boards. Usually '/%s/' (/b/, /mu/, etc). This doesn't change the URL. Find
	//  $config['board_path'] if you wish to change the URL.
	$config['board_abbreviation'] = '/%s/';

	// The default name (ie. Anonymous). Can be an array - in that case it's picked randomly from the array.
	// Example: $config['anonymous'] = array('Bernd', 'Senpai', 'Jonne', 'ChanPro');
	$config['anonymous'] = 'Chud';

	// Number of reports you can create at once.
	$config['report_limit'] = 3;

	// Allow unfiltered HTML in board subtitle. This is useful for placing icons and links.
	$config['allow_subtitle_html'] = true;

/*
 * ====================
 *  Display settings
 * ====================
 */

	// vichan has been translated into a few langauges. See inc/locale for available translations.
	$config['locale'] = 'en'; // (en, ru_RU.UTF-8, fi_FI.UTF-8, pl_PL.UTF-8)

	// Timezone to use for displaying dates/times.
	$config['timezone'] = 'UTC';
	// The format string passed to strftime() for displaying dates.
	// http://www.php.net/manual/en/function.strftime.php
	$config['post_date'] = '%m/%d/%y (%a) %H:%M:%S';
	// Same as above, but used for "you are banned' pages.
	$config['ban_date'] = '%A %e %B, %Y';

	// The names on the post buttons. (On most imageboards, these are both just "Post").
	$config['button_newtopic'] = _('Post');
	$config['button_reply'] = _('Post');

	// Assign each poster in a thread a unique ID, shown by "ID: xxxxx" before the post number.
	$config['poster_ids'] = false;
	// Number of characters in the poster ID (maximum is 40).
	$config['poster_id_length'] = 6;

	// Show thread subject in page title.
	$config['thread_subject_in_title'] = false;

	// Additional lines added to the footer of all pages.
	$config['footer'][] = _('Hidden service: <a href="http://soyjakcoox7ji3jg6mj3z2bibvtpxietygbp22wq3lokmkwplsmmxrid.onion">soyjakcoox7ji3jg6mj3z2bibvtpxietygbp22wq3lokmkwplsmmxrid.onion</a>');
	$config['footer'][] = _('All trademarks, copyrights, comments, and images on this page are owned by and are the responsibility of their respective parties.');
	$config['footer'][] = _('Legal inquiries, concerns, and complaints should be emailed to <a href="mailto:legal@soyjak.st">legal@soyjak.st</a>.');

	// Characters used to generate a random password (with Javascript).
	$config['genpassword_chars'] = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-><.,¬£?;:/[]{}=~|¬¨';

	// Banner settings.
	// Banners are rotating, random images displayed to users at the top of thread pages and the catalog.
	// You should upload your banners to static/banners.
	$config['url_banner'] = '/b.php';	// Custom script may be used.
	// Setting the banner dimensions stops the page shifting as it loads. If you have banners of various different sizes, unset these.
	#$config['banner_width'] = 300;
	#$config['banner_height'] = 100;

	// Ban image settings.
	// Ban images are rotating, random images displayed to users at the top of thread pages and the catalog.
	// You should upload your ban images to static/banimages.
	$config['url_banimage'] = '/b.php?banned';	// Custom script may be used.
	// Setting the ban image dimensions stops the page shifting as it loads. If you have ban images of various different sizes, unset these.
	$config['banimage_width'] = 250;
	#$config['banimage_height'] = 250;

	// Custom stylesheets available for the user to choose. See the "stylesheets/" folder for a list of
	// available stylesheets (or create your own).
	$config['stylesheets']['Yotsoyba B'] = ''; // Default; there is no additional/custom stylesheet for this.

        $config['stylesheets']['Mint'] = 'mint.css';

        $config['stylesheets']['Win7'] = 'win7.css';
	$config['stylesheets']['Photon'] = 'photon.css?v2';
	$config['stylesheets']['Spooky'] = 'spooky.css?v2';
	$config['stylesheets']['Yotsoyba'] = 'yotsuba.css';
	$config['stylesheets']['Yotsoybatrue'] = 'yotsoybatrue.css';
	 $config['stylesheets']['Futaba'] = 'futaba+vichan.css';
	 $config['stylesheets']['Burichan'] = 'burichan.css';
	 $config['stylesheets']['Dark'] = 'dark.css';
	 $config['stylesheets']['Glow'] = 'glow.css';
	 $config['stylesheets']['Midnight'] = 'dark2.css';
	 $config['stylesheets']['Mutt'] = 'mutt.css';
	 $config['stylesheets']['Christmas4'] = 'christmas4.css';
	 $config['stylesheets']['Chadparty'] = 'chadparty.css';
	 $config['stylesheets']['FrootigerAerthough'] = 'frootiger_aerthough.css';
         $config['stylesheets']['Pina Coalada'] = 'pinacoalada.css';
         $config['stylesheets']['His Theme'] = 'histheme.css';
         $config['stylesheets']['Calm'] = 'calm.css';
         $config['stylesheets']['Rage'] = 'rage.css';
         $config['stylesheets']['Pina Coalada - Sunset'] = 'pinacoaladasunset.css';
         $config['stylesheets']['Independence'] = 'independence.css';
         $config['stylesheets']['Skibidi'] = 'skibidi.css';

	$config['stylesheets']['Frooty'] = 'froot.css';
	$config['stylesheets']['Thanos'] = 'thanos.css';
	$config['stylesheets']['J*rtycvck'] = 'jarty.css';

	$config['stylesheets']['Soya'] = 'soya.css?v1';
	$config['stylesheets']['Eater'] = 'eater.css';

	$config['stylesheets']['Thanksgiving'] = 'thanksgiving.css?v2';
	$config['stylesheets']['Christmas 2'] = 'christmas2.css';

	$config['stylesheets']['Kosher'] = 'kosher.css';

	$config['stylesheets']['Shaved Ice'] = 'dem.css';

	$config['stylesheets']['Workaholic'] = 'workaholic.css';

	$config['stylesheets']['Win95'] = 'win95.css';

	$config['stylesheets']['America'] = 'america.css';

	$config['stylesheets']['Solunar'] = 'solunar.css';
	$config['stylesheets']['Solunar - Night'] = 'solunar/night.css';
	$config['stylesheets']['Solunar - Day'] = 'solunar/day.css';

	$config['stylesheets']['Soylent'] = 'soylent.css';
	$config['stylesheets']['The Ribbit Rally'] = 'trr.css';

	$config['stylesheets']['New Year'] = 'newyear.css';

	//$config['stylesheets']['Pride'] = 'pride.css';
	// The prefix for each stylesheet URI. Defaults to $config['root']/stylesheets/
	// $config['uri_stylesheets'] = 'http://static.example.org/stylesheets/';

	// The default stylesheet to use.
	$config['default_stylesheet'] = array('Yotsoyba B', $config['stylesheets']['Yotsoyba B']);
	// Make stylesheet selections board-specific.
	$config['stylesheets_board'] = false;

	// Use Font-Awesome for displaying lock and pin icons, instead of the images in static/.
	// http://fortawesome.github.io/Font-Awesome/icon/pushpin/
	// http://fortawesome.github.io/Font-Awesome/icon/lock/
	$config['font_awesome'] = false;
	$config['font_awesome_css'] = 'stylesheets/font-awesome/css/font-awesome.min.css';

	/*
	 * For lack of a better name, ìboardlinksî are those sets of navigational links that appear at the top
	 * and bottom of board pages. They can be a list of links to boards and/or other pages such as status
	 * blogs and social network profiles/pages.
	 *
	 * "Groups" in the boardlinks are marked with square brackets. vichan allows for infinite recursion
	 * with groups. Each array() in $config['boards'] represents a new square bracket group.
	 */
//top bar
	 $config['boards'] = array(
		array('home' => '/', 'overboard' => '/o'),

//		array('soy', 'mtv', 'int', 'a', 'pol', 'r9k', 'x', 'nate', 'qa', 'q'),
//		array('a', 'fit', 'g', 'int', 'mtv', 'nate', 'pol', 'qa', 'q', 'r9k', 'soy', 'tech', 'tv', 'v', 'x'),
                array('soy', 'qa', 'raid', 'r'),
                array('craft'),
                array('int', 'pol'),
                array('a', 'an', 'asp', 'biz', 'mtv', 'r9k', 'tech', 'v', 'sude', 'x'),
		array('q', 'news', 'chive', 'rules' => '/rules.html', 'pass' => '/pass.php', 'bans' => '/bans.php', 'status' => 'https://status.soyjak.st'),
		array('wiki' => 'https://soyjakwiki.org', 'booru' => 'https://soybooru.com', 'irc' => 'https://webirc.soyjak.st'),
		/*
		array('soy', 'qa'),
		array('pol', 'int'),
		array('craft', 'dem', 'sn'),
		array('a', 'mtv', 'r', 'r9k', 'sude', 'swa', 'tech'),
		array('q', 'news', 'chive'),
		array('rules' => '/rules.html', 'pass' => '/pass.php', 'bans' => '/bans.php'),
		*/
		//array('irc' => '/irc.html', 'wiki' => 'https://soyjakwiki.net/', 'booru' => 'https://soybooru.com', 'blog' => 'https://soyjak.blog/', 'soysylum' => 'https://soysylum.org/', 'dailyjak' => 'https://t.me/thedailyjak'),
		//array('1488', '2988', 'a', 'an', 'anthro', 'au', 'bait', 'baldi', 'bar', 'bbc', 'biz', 'blepe', 'brim', 'c', 'caca', 'cel', 'chad', 'chive', 'chuck', 'clash', 'cn', 'co', 'craft', 'crb', 'data', 'deadnigger', 'dino', 'dnb', 'drizzy', 'dsp', 'f', 'f2', 'fnac', 'fort', 'fpe', 'froot', 'g', 'geg', 'gem', 'gen', 'gfc', 'giga5', 'hell', 'hf', 'hobby', 'int', 'jak', 'jarty', 'jew', 'jiren', 'joel', 'k', 'kiwi', 'lgbt', 'lime', 'mare', 'mex', 'mo', 'mol', 'mpa', 'mtv', 'nate', 'news', 'ng', 'noel', 'nu', 'off', 'ohio', 'p', 'plier', 'pol', 'pond', 'ps', 'ptb', 'q', 'qa', 'qa4', 'r', 'r9k', 'rage', 'raid', 'rbx', 'ru', 's', 'sc', 'sch', 'sci', 'skibidi', 'sneed', 'soy', 'sp', 'spl', 'sude', 'tan', 'tech', 'tttt', 'tw', 'twi', 'u', 'ud', 'un', 'uni', 'voice', 'vw', 'w', 'wef', 'wiki', 'wm', 'woj', 'wp', 'x', 'yyyyyyy', 'zellig'),
		//array('1488', '2988', 'a', 'an', 'anthro', 'bait', 'baldi', 'bbc', 'biz', 'blepe', 'caca', 'chive', 'chuck', 'clash', 'craft', 'drizzy', 'dsp', 'fnac', 'fort', 'fpe', 'g', 'gem', 'giga5', 'hobby', 'int', 'j', 'jak', 'jew', 'jiren', 'joel', 'lgbt', 'lime', 'mediator', 'mtv', 'nate', 'news', 'ng', 'nu', 'off', 'ohio', 'plier', 'pol', 'pond', 'ptb', 'q', 'qa', 'qa4', 'r', 'r9k', 'rage', 'raid', 'rbx', 'sci', 'skibidi', 'sneed', 'soy', 'sude', 'tan', 'tech', 'test', 'tttt', 'uni', 'voice', 'w', 'x', 'yyyyyyy', 'zellig'),
		//array('a', 'anthro', 'chive', 'craft', 'fpe', 'g', 'gem', 'int', 'mtv', 'news', 'pol', 'pond', 'q', 'qa', 'r', 'raid', 'skibidi', 'soy', 'sude', 'tech', 'tttt', 'uni'),
		//array('wiki' => 'https://wiki.soyjak.party/')
		//array('booru' => 'https://booru.soy'),
		//array('soysylum' => 'https://soysylum.org/'),
		//array('dailyjak' => 'https://t.me/thedailyjak'),
		//array('soycraft' => 'https://wiki.soyjak.party/Soycraft', fnac demo => 'https://soyjak.party/fnac.html', tf2' => 'https://wiki.soyjak.party/SOYTOPIA'),
		//make everything spin
		//array('<style>@keyframes spin {   0% {     transform: rotate(0deg);   }   100% {     transform: rotate(360deg);   } }</style><script>document.querySelectorAll(\'img\').forEach((img) => {   img.style.animation = "spin 7400s linear infinite"; });</script>' => ''),
		//array('log warehouse' => 'https://archive.soyjaks.party/'),
		//array('merch' => 'https://www.redbubble.com/people/shirtteen/shop?asc=u'),
		//array('donate' => 'https://soyjaks.party/donate.html'),

	);

	// Whether or not to put brackets around the whole board list
	$config['boardlist_wrap_bracket'] = false;

	// Show page navigation links at the top as well.
	$config['page_nav_top'] = false;

	// Show "Catalog" link in page navigation. Use with the Catalog theme. Set to false to disable.
	$config['catalog_link'] = 'catalog.html';

	// Board categories. Only used in the "Categories" theme.
	// $config['categories'] = array(
	// 	'Group Name' => array('a', 'b', 'c'),
	// 	'Another Group' => array('d')
	// );
	// Optional for the Categories theme. This is an array of name => (title, url) groups for categories
	// with non-board links.
	// $config['custom_categories'] = array(
	// 	'Links' => array(
	// 		'Github' => 'https://github.com/my/project',
	// 		'Donate' => 'donate.html'
	// 	)
	// );

	// Automatically remove unnecessary whitespace when compiling HTML files from templates.
	$config['minify_html'] = true;

	/*
	 * Advertisement HTML to appear at the top and bottom of board pages.
	 */

	 $config['ad'] = array(
		'top' => '
		<!--<hr><style>
		#adContainer img {
			max-width: 100%;
			max-height: 150px;
			display: block; 
			margin: 0 auto;
		}
	</style>
		<script>
		document.addEventListener("DOMContentLoaded", function() {
			fetch(\'//soyjak.party/bannerssa.php\')
			.then(response => {
				const link = response.headers.get(\'X-Ad-Link\');
				return response.blob().then(blob => {
					return {
						imageBlob: blob,
						link: link
					};
				});
			})
			.then(data => {
				const blobUrl = URL.createObjectURL(data.imageBlob);
		
				const container = document.getElementById(\'adContainer\');
				const img = document.createElement(\'img\');
				img.src = blobUrl;
				img.alt = "Ad Image";
		
				const anchor = document.createElement(\'a\');
				anchor.href = data.link;
				anchor.appendChild(img);
		
				container.appendChild(anchor);
			})
			.catch(error => console.error(\'Error fetching ad:\', error));
		});
		
</script>		
		<hr><center><div id="adContainer"></div></center>-->
		',
		// 'bottom' => '',
	);
	
	
	 

	// Display flags (when available). This config option has no effect unless poster flags are enabled (see
	// $config['country_flags']). Disable this if you want all previously-assigned flags to be hidden.
	$config['display_flags'] = true;

	// Location of post flags/icons (where "%s" is the flag name). Defaults to static/flags/%s.png.
	// $config['uri_flags'] = 'http://static.example.org/flags/%s.png';

	// Width and height (and more?) of post flags. Can be overridden with the vichan post modifier:
	// <tinyboard flag style>.
	$config['flag_style'] = 'height:11px;';

/*
 * ====================
 *  Javascript
 * ====================
 */

	// Additional Javascript files to include on board index and thread pages. See js/ for available scripts.
	//$config['additional_javascript'][] = 'js/jquery.min.js';
	//$config['additional_javascript'][] = 'js/inline-expanding.js';
	// $config['additional_javascript'][] = 'js/local-time.js';

	// Some scripts require jQuery. Check the comments in script files to see what's needed. When enabling
	// jQuery, you should first empty the array so that "js/query.min.js" can be the first, and then re-add
	// "js/inline-expanding.js" or else the inline-expanding script might not interact properly with other
	// scripts.
	// $config['additional_javascript'] = array();
	// $config['additional_javascript'][] = 'js/jquery.min.js';
	// $config['additional_javascript'][] = 'js/inline-expanding.js';
	// $config['additional_javascript'][] = 'js/auto-reload.js';
	// $config['additional_javascript'][] = 'js/post-hover.js';
	// $config['additional_javascript'][] = 'js/style-select.js';
	// $config['additional_javascript'][] = 'js/captcha.js';

	// Where these script files are located on the web. Defaults to $config['root'].
	// $config['additional_javascript_url'] = 'http://static.example.org/vichan-javascript-stuff/';

	// Compile all additional scripts into one file ($config['file_script']) instead of including them seperately.
	$config['additional_javascript_compile'] = false;

	// Minify Javascript using http://code.google.com/p/minify/.
	$config['minify_js'] = false;

	// Dispatch thumbnail loading and image configuration with JavaScript. It will need a certain javascript
	// code to work.
	$config['javascript_image_dispatch'] = false;

/*
 * ====================
 *  Video embedding
 * ====================
 */

	// Enable embedding (see below).
	$config['enable_embedding'] = true;

	// Youtube.js embed HTML code
	$config['youtube_js_html'] = '<div class="video-container" data-video="$2">'.
		'<a href="https://youtu.be/$2" target="_blank" class="file">'.
		'<img style="width:252px;height:189px;" src="https://img.youtube.com/vi/$2/0.jpg" class="post-image"/>'.
		'</a></div>';

	// Custom embedding (YouTube, vimeo, etc.)
	// It's very important that you match the entire input (with ^ and $) or things will not work correctly.
	// Be careful when creating a new embed, because depending on the URL you end up exposing yourself to an XSS.
	$config['embedding'] = array(
		array(
			'/^https?:\/\/(\w+\.)?youtube\.com\/watch\?v=([a-zA-Z0-9\-_]{10,11})?$/i',
//			'<iframe allow="cross-origin-isolated" style="float: left; margin: 10px 20px;" width="%%tb_width%%" height="%%tb_height%%" frameborder="0" id="ytplayer" src="https://invidious.fdn.fr/embed/$2"></iframe>'
			$config['youtube_js_html']
		),
		array(
			'/^https?:\/\/(\w+\.)?youtu\.be\/([a-zA-Z0-9\-_]{10,11})?$/i',
//			'<iframe allow="cross-origin-isolated" style="float: left; margin: 10px 20px;" width="%%tb_width%%" height="%%tb_height%%" frameborder="0" id="ytplayer" src="https://invidious.fdn.fr/embed/$2"></iframe>'
			$config['youtube_js_html']
		),
		array(
			'/^https?:\/\/(\w+\.)?vimeo\.com\/(\d{2,10})(\?.+)?$/i',
			'<iframe allow="cross-origin-isolated" style="float: left; margin: 10px 20px;" width="%%tb_width%%" height="%%tb_height%%" frameborder="0" src="https://player.vimeo.com/video/$2"></iframe>'
		),
		array(
			'/^https?:\/\/(\w+\.)?dailymotion\.com\/video\/([a-zA-Z0-9]{2,10})(_.+)?$/i',
			'<iframe allow="cross-origin-isolated" style="float: left; margin: 10px 20px;" width="%%tb_width%%" height="%%tb_height%%" frameborder="0" src="https://www.dailymotion.com/embed/video/$2" allowfullscreen></iframe>'
		),
		array(
			'/^https?:\/\/(\w+\.)?metacafe\.com\/watch\/(\d+)\/([a-zA-Z0-9_\-.]+)\/(\?[^\'"<>]+)?$/i',
			'<iframe allow="cross-origin-isolated" style="float: left; margin: 10px 20px;" width="%%tb_width%%" height="%%tb_height%%" frameborder="0"  src="https://www.metacafe.com/embed/$2/$3/" allowfullscreen></iframe>'
		),
		array(
                        '/^https?:\/\/(\w+\.)?vocaroo\.com\/([a-zA-Z0-9]{2,12})$/i',
                        '<iframe allow="cross-origin-isolated" style="float: left; margin: 10px 20px;" width="300" height="60" frameborder="0" src="https://vocaroo.com/embed/$2"></iframe>'
		)
	);

	// Embedding width and height.
	$config['embed_width'] = 300;
	$config['embed_height'] = 250;

/*
 * ====================
 *  Error messages
 * ====================
 */

	// Error messages
	$config['error']['bot']			= _('You look like a bot.');
	$config['error']['referer']		= _('Your browser sent an invalid or no HTTP referer.');
	$config['error']['toolong']		= _('The %s field was too long.');
	$config['error']['toolong_body']	= _('The body was too long.');
	$config['error']['tooshort_body']	= _('The body was too short or empty.');
	$config['error']['toomanylines']	= _('Your post contains too many lines!');
	$config['error']['noimage']		= _('You must upload an image.');
	$config['error']['noimage_op']		= _('You must upload an image. This thread is in image only mode.');
	$config['error']['toomanyimages'] = _('You have attempted to upload too many images!');
	$config['error']['nomove']		= _('The server failed to handle your upload.');
	$config['error']['fileext']		= _('Unsupported image format.');
	$config['error']['noboard']		= _('Invalid board!');
	$config['error']['nonexistant']		= _('Thread specified does not exist.');
	$config['error']['locked']		= _('Thread locked. You may not reply at this time.');
	$config['error']['board_locked']	= _('Board locked.');
	$config['error']['reply_hard_limit']	= _('Thread has reached its maximum reply limit.');
	$config['error']['image_hard_limit']	= _('Thread has reached its maximum image limit.');
	$config['error']['nopost']		= _('You didn\'t make a post.');
	$config['error']['flood']		= _('Flood detected; Post discarded.');
	$config['error']['too_many_threads']		= _('To prevent raids, the maximum number of threads has been limited per hour. Please check back later or post in an existing thread.');
	$config['error']['spam']		= _('Your request looks automated; Post discarded.');
	$config['error']['unoriginal']		= _('Unoriginal content!');
	$config['error']['muted']		= _('Unoriginal content! You have been muted for %d seconds.');
	$config['error']['youaremuted']		= _('You are muted! Expires in %d seconds.');
	$config['error']['dnsbl']		= _('Your IP address is listed in %s.');
	$config['error']['toomanylinks']	= _('Too many links; flood detected.');
	$config['error']['toomanycites']	= _('Too many cites; post discarded.');
	$config['error']['toomanycross']	= _('Too many cross-board links; post discarded.');
	$config['error']['nodelete']		= _('You didn\'t select anything to delete.');
	$config['error']['noreport']		= _('You didn\'t select anything to report.');
	$config['error']['invalidreport']	= _('The reason was too long.');
	$config['error']['toomanyreports']	= _('You can\'t report that many posts at once.');
	$config['error']['invalidpassword']	= _('Wrong password!');
	$config['error']['invalidimg']		= _('Invalid image.');
	$config['error']['phpfileserror']	= _('Upload failure (file #%index%): Error code %code%. Refer to <a href="http://php.net/manual/en/features.file-upload.errors.php">http://php.net/manual/en/features.file-upload.errors.php</a>; post discarded.');
	$config['error']['unknownext']		= _('Unknown file extension.');
	$config['error']['filesize']		= _('Maximum file size: %maxsz% bytes<br>Your file\'s size: %filesz% bytes');
	$config['error']['maxsize']		= _('The file was too big.');
	$config['error']['genwebmerror']	= _('There was a problem processing your webm.');
	$config['error']['webmerror'] 		= _('There was a problem processing your webm.');//Is this error used anywhere ?
	$config['error']['invalidwebm'] 	= _('Invalid webm/mp4 uploaded. Try re-encoding. If you need help, look here for a tutorial: https://soyjak.party/static/encoding.mp4');
	$config['error']['webmhasaudio'] 	= _('The uploaded webm contains an audio or another type of additional stream.');
	$config['error']['webmtoolong']		=_('The uploaded webm is longer than %d seconds.');
	$config['error']['fileexists']		= _('That file <a href="%s">already exists</a>!');
	$config['error']['fileexistsinthread']	= _('That file <a href="%s">already exists</a> in this thread!');
	$config['error']['delete_too_soon']	= _('You\'ll have to wait another %s before deleting that.');
	$config['error']['delete_too_late']	= _('You cannot delete a post this old.');
	$config['error']['mime_exploit']	= _('MIME type detection XSS exploit (IE) detected; post discarded.');
	$config['error']['invalid_embed']	= _('Couldn\'t make sense of the URL of the video you tried to embed.');
	$config['error']['captcha']		= _('You seem to have mistyped the verification.');
	$config['error']['flag_undefined']	= _('The flag %s is undefined, your PHP version is too old!');
	$config['error']['flag_wrongtype']	= _('defined_flags_accumulate(): The flag %s is of the wrong type!');
	$config['error']['ipblock']		= _('Your IP address has been flagged as a VPN. If this was a mistake, please appeal <a href="/survey/?r=survey/index&sid=526468&lang=en">here</a>.');
	$config['error']['no_post_history']	= _('You look like a bot.');
	$config['error']['countryblock']	= _('Your country has been blocked from posting on this board.');


	// Moderator errors
	$config['error']['toomanyunban']	= _('You are only allowed to unban %s users at a time. You tried to unban %u users.');
	$config['error']['invalid']		= _('Invalid username and/or password.');
	$config['error']['notamod']		= _('You are not a mod!');
	$config['error']['invalidafter']	= _('Invalid username and/or password. Your user may have been deleted or changed.');
	$config['error']['malformed']		= _('Invalid/malformed cookies.');
	$config['error']['missedafield']	= _('Your browser didn\'t submit an input when it should have.');
	$config['error']['required']		= _('The %s field is required.');
	$config['error']['invalidfield']	= _('The %s field was invalid.');
	$config['error']['boardexists']		= _('There is already a %s board.');
	$config['error']['noaccess']		= _('You don\'t have permission to do that.');
	$config['error']['invalidpost']		= _('That post doesn\'t exist!');
	$config['error']['404']			= _('Page not found.');
	$config['error']['modexists']		= _('That mod <a href="?/users/%d">already exists</a>!');
	$config['error']['invalidtheme']	= _('That theme doesn\'t exist!');
	$config['error']['csrf']		= _('Invalid security token! Please go back and try again.');
	$config['error']['badsyntax']		= _('Your code contained PHP syntax errors. Please go back and correct them. PHP says: ');

/*
 * =========================
 *  Directory/file settings
 * =========================
 */

	// The root directory, including the trailing slash, for vichan.
	// Examples: '/', 'http://boards.chan.org/', '/chan/'.
	if (isset($_SERVER['REQUEST_URI'])) {
		$request_uri = $_SERVER['REQUEST_URI'];
		if (isset($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING'] !== '')
			$request_uri = substr($request_uri, 0, - 1 - strlen($_SERVER['QUERY_STRING']));
		$config['root']	 = str_replace('\\', '/', dirname($request_uri)) == '/'
			? '/' : str_replace('\\', '/', dirname($request_uri)) . '/';
		unset($request_uri);
	} else
		$config['root'] = '/'; // CLI mode

	// The scheme and domain. This is used to get the site's absolute URL (eg. for image identification links).
	// If you use the CLI tools, it would be wise to override this setting.
	$config['domain'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'https://';
	$config['domain'] .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';

	// If for some reason the folders and static HTML index files aren't in the current working direcotry,
	// enter the directory path here. Otherwise, keep it false.
	$config['root_file'] = false;

	// Location of primary files.
	$config['file_index'] = 'index.html';
	$config['file_page'] = '%d.html'; // NB: page is both an index page and a thread
	$config['file_catalog'] = 'catalog.html';
	$config['file_page50'] = '%d+50.html';
	$config['file_page_slug'] = '%d-%s.html';
	$config['file_page50_slug'] = '%d-%s+50.html';
	$config['file_page_paged'] = '%d-page_%d.html';
	$config['file_mod'] = 'mod.php';
	$config['file_post'] = 'post.php';
	$config['file_script'] = '_main.js';

	$config['file_board_index'] = 'index.html';
	$config['file_page_template'] = 'page.html';
	$config['file_report'] = 'report.html';
	$config['file_error'] = 'error.html';
	$config['file_login'] = 'login.html';
	$config['file_banned'] = 'banned.html';
	$config['file_fileboard'] = 'fileboard.html';
	$config['file_thread'] = 'thread.html';
	$config['file_post_reply'] = 'post_reply.html';
	$config['file_post_thread'] = 'post_thread.html';
	$config['file_post_thread_fileboard'] = 'post_thread_fileboard.html';

	$config['file_poll_vote'] = 'poll_vote.html';
	$config['file_poll_result'] = 'poll_result.html';

	$config['file_ip_token'] = 'ip_token.html';

	$config['file_pass'] = 'pass.html';

	$config['file_public_ban_list'] = 'public_ban_list.html';

	// Mod page file settings
	$config['file_mod_dashboard'] = 'mod/dashboard.html';
	$config['file_mod_login'] = 'mod/login.html';
	$config['file_mod_confim'] = 'mod/confirm.html';
	$config['file_mod_board'] = 'mod/board.html';
	$config['file_mod_news'] = 'mod/news.html';
	$config['file_mod_log'] = 'mod/log.html';

	$config['file_mod_view_ip'] = 'mod/view_ip.html';
	$config['file_mod_ban_form'] = 'mod/ban_form.html';
	$config['file_mod_ban_list'] = 'mod/ban_list.html';
	$config['file_mod_ban_appeals'] = 'mod/ban_appeals.html';
	$config['file_mod_ban_requests'] = 'mod/ban_requests.html';
	//$config['file_mod_cloak_ips'] = 'mod/cloak_ips.html';

	$config['file_mod_noticeboard'] = 'mod/noticeboard.html';
	$config['file_mod_search_results'] = 'mod/search_results.html';

	$config['file_mod_move'] = 'mod/move.html';
	$config['file_mod_move_reply'] = 'mod/move_reply.html';
	$config['file_mod_edit_post_form'] = 'mod/edit_post_form.html';

	$config['file_mod_user'] = 'mod/user.html';
	$config['file_mod_users'] = 'mod/users.html';

	$config['file_mod_pm'] = 'mod/pm.html';
	$config['file_mod_new_pm'] = 'mod/new_pm.html';
	$config['file_mod_inbox'] = 'mod/inbox.html';

	$config['file_mod_rebuilt'] = 'mod/rebuilt.html';
	$config['file_mod_rebuild'] = 'mod/rebuild.html';
	$config['file_mod_report'] = 'mod/report.html';
	$config['file_mod_reports'] = 'mod/reports.html';
	$config['file_mod_recent_posts'] = 'mod/recent_posts.html';

	$config['file_mod_config_editor'] = 'mod/config-editor.html';
	$config['file_mod_config_editor_php'] = 'mod/config-editor-php.html';

	$config['file_mod_themes'] = 'mod/themes.html';
	$config['file_mod_theme_installed'] = 'mod/theme_installed.html';
	$config['file_mod_theme_config'] = 'mod/theme_config.html';
	$config['file_mod_theme_rebuilt'] = 'mod/theme_rebuilt.html';

	$config['file_mod_pages'] = 'mod/pages.html';
	$config['file_mod_edit_page'] = 'mod/edit_page.html';

	$config['file_mod_debug_antispam'] = 'mod/debug/antispam.html';
	$config['file_mod_debug_recent_posts'] = 'mod/debug/recent_posts.html';
	$config['file_mod_debug_sql'] = 'mod/debug/sql.html';
	$config['file_mod_debug_apc'] = 'mod/debug/apc.html';

	// Board directory, followed by a forward-slash (/).
	$config['board_path'] = '%s/';
	// Misc directories.
	$config['dir']['img'] = 'src/';
	$config['dir']['thumb'] = 'thumb/';
	$config['dir']['res'] = 'thread/';

	// For load balancing, having a seperate server (and domain/subdomain) for serving static content is
	// possible. This can either be a directory or a URL. Defaults to $config['root'] . 'static/'.
	// $config['dir']['static'] = 'http://static.example.org/';

	// Where to store the .html templates. This folder and the template files must exist.
	$config['dir']['template'] = getcwd() . '/templates';
	// Location of vichan "themes".
	$config['dir']['themes'] = getcwd() . '/templates/themes';
	// Same as above, but a URI (accessable by web interface).
	$config['dir']['themes_uri'] = 'templates/themes';
	// Home directory. Used by themes.
	$config['dir']['home'] = '';

	// Location of a blank 1x1 gif file. Only used when country_flags_condensed is enabled
	// $config['image_blank'] = 'static/blank.gif';

	// Static images. These can be URLs OR base64 (data URI scheme). These are only used if
	// $config['font_awesome'] is false (default).
	$config['image_sticky']	= '/static/sticky.gif';
	$config['image_locked']	= '/static/closed.png';
	$config['image_bumplocked']	= '/static/locked.gif';
	$config['image_cyclical']	= '/static/cycle.png';
	$config['image_imagesonly']	= '/static/images_only.png';
	$config['image_loop']	= '/static/loop.png';
	$config['image_desktop'] = '/static/desktop.png';
	$config['image_encrypted'] = '/static/restricted.png';

	// If you want to put images and other dynamic-static stuff on another (preferably cookieless) domain.
	// This will override $config['root'] and $config['dir']['...'] directives. "%s" will get replaced with
	//  $board['dir'], which includes a trailing slash.
	// $config['uri_thumb'] = 'http://images.example.org/%sthumb/';
	// $config['uri_img'] = 'http://images.example.org/%ssrc/';

	// Set custom locations for stylesheets and the main script file. This can be used for load balancing
	// across multiple servers or hostnames.
	$config['url_stylesheet'] = '/stylesheets/style.css?v57'; // main/base stylesheet
	$config['url_javascript'] = '/_main.js?v56';

	// Website favicon.
	$config['url_favicon'] = '/favicon.ico?v2';
	
	// Try not to build pages when we shouldn't have to.
	$config['try_smarter'] = true;

/*
 * ====================
 *  Advanced build
 * ====================
 */

	// Strategies for file generation. Also known as an "advanced build". If you don't have performance
	// issues, you can safely ignore that part, because it's hard to configure and won't even work on
	// your free webhosting.
	//
	// A strategy is a function, that given the PHP environment and ($fun, $array) variable pair, returns
	// an $action array or false.
	//
	// $fun - a controller function name, see inc/controller.php. This is named after functions, so that
	//        we can generate the files in daemon.
	//
	// $array - arguments to be passed
	//
	// $action - action to be taken. It's an array, and the first element of it is one of the following:
	//   * "immediate" - generate the page immediately
	//   * "defer" - defer page generation to a moment a worker daemon gets to build it (serving a stale
	//               page in the meantime). The remaining arguments are daemon-specific. Daemon isn't
	//               implemented yet :DDDD inb4 while(true) { generate(Queue::Get()) }; (which is probably it).
	//   * "build_on_load" - defer page generation to a moment, when the user actually accesses the page.
	//                       This is a smart_build behaviour. You shouldn't use this one too much, if you
	//                       use it for active boards, the server may choke due to a possible race condition.
	//                       See my blog post: https://engine.vichan.net/blog/res/2.html
	//
	// So, let's assume we want to build a thread 1324 on board /b/, because a new post appeared there.
	// We try the first strategy, giving it arguments: 'sb_thread', array('b', 1324). The strategy will
	// now return a value $action, denoting an action to do. If $action is false, we try another strategy.
	//
	// As I said, configuration isn't easy.
	//
	// 1. chmod 0777 directories: tmp/locks/ and tmp/queue/.
	// 2. serve 403 and 404 requests to go thru smart_build.php
	//    for nginx, this blog post contains config snippets: https://engine.vichan.net/blog/res/2.html
	// 3. disable indexes in your webserver
	// 4. launch any number of daemons (eg. twice your number of threads?) using the command:
	//    $ tools/worker.php
	//    You don't need to do that step if you are not going to use the "defer" option.
	// 5. enable smart_build_helper (see below)
	// 6. edit the strategies (see inc/functions.php for the builtin ones). You can use lambdas. I will test
	//    various ones and include one that works best for me.
	$config['generation_strategies'] = array();
	// Add a sane strategy. It forces to immediately generate a page user is about to land on. Otherwise,
	// it has no opinion, so it needs a fallback strategy.
	$config['generation_strategies'][] = 'strategy_sane';
	// Add an immediate catch-all strategy. This is the default function of imageboards: generate all pages
	// on post time.
	$config['generation_strategies'][] = 'strategy_immediate';
	// NOT RECOMMENDED: Instead of an all-"immediate" strategy, you can use an all-"build_on_load" one (used
	// to be initialized using $config['smart_build']; ) for all pages instead of those to be build
	// immediately. A rebuild done in this mode should remove all your static files
	// $config['generation_strategies'][1] = 'strategy_smart_build';

	// Deprecated. Leave it false. See above.
	$config['smart_build'] = false;

	// Use smart_build.php for dispatching missing requests. It may be useful without smart_build or advanced
	// build, for example it will regenerate the missing files.
	$config['smart_build_helper'] = true;

	// smart_build.php: when a file doesn't exist, where should we redirect?
	$config['page_404'] = '/404.html';

	// Extra controller entrypoints. Controller is used only by smart_build and advanced build.
	$config['controller_entrypoints'] = array();

/*
 * ====================
 *  Mod settings
 * ====================
 */

	// Limit how many bans can be removed via the ban list. Set to false (or zero) for no limit.
	$config['mod']['unban_limit'] = false;

	// Whether or not to lock moderator sessions to IP addresses. This makes cookie theft ineffective.
	$config['mod']['lock_ip'] = true;

	// The page that is first shown when a moderator logs in. Defaults to the dashboard (?/).
	$config['mod']['default'] = '/';

	// Mod links (full HTML).
	$config['mod']['link_delete'] = '[D]';
	$config['mod']['link_ban'] = '[B]';
	$config['mod']['link_threadban'] = '[TB]';
	$config['mod']['link_bandelete'] = '[B&amp;D]';
	$config['mod']['link_deletefile'] = '[F]';
	$config['mod']['link_spoilerimage'] = '[S]';
	$config['mod']['link_marknsfw'] = '[NSFW]';
	$config['mod']['link_approvefile'] = '[Approve]';
	$config['mod']['link_rejectfile'] = '[Reject]';
	$config['mod']['link_deletebyip'] = '[D+]';
	$config['mod']['link_deletebyip_global'] = '[D++]';
	$config['mod']['link_deletebyip_thread'] = '[DT]';
	$config['mod']['link_sticky'] = '[Sticky]';
	$config['mod']['link_desticky'] = '[-Sticky]';
	$config['mod']['link_lock'] = '[Lock]';
	$config['mod']['link_unlock'] = '[-Lock]';
	$config['mod']['link_bumplock'] = '[Sage]';
	$config['mod']['link_bumpunlock'] = '[-Sage]';
	$config['mod']['link_editpost'] = '[Edit]';
	$config['mod']['link_move'] = '[Move]';
	$config['mod']['link_cycle'] = '[Cycle]';
	$config['mod']['link_uncycle'] = '[-Cycle]';
	$config['mod']['link_invincible'] = '[Loop]';
	$config['mod']['link_uninvincible'] = '[-Loop]';

	$config['mod']['link_banrequest'] = '[BR]';

	$config['mod']['link_mediator_vote'] = '[V]';
	$config['mod']['link_approve_news'] = '[AN]';
	$config['mod']['link_unapprove_news'] = '[-AN]';
	// Moderator capcodes.
	$config['capcode'] = ' <span class="capcode">## %s</span>';

	// "## Mod" makes everything purple, including the name and tripcode:
	$config['custom_capcode']['Mod'] = array(
		'<span class="capcode" style="color:purple"> ## %s</span>',
		'color:purple', // Change name style; optional
		'color:purple' // Change tripcode style; optional
	);

	$config['custom_capcode']['Boomer'] = array(
		'<span class="capcode" style="color:grey; font-weight:bold"> ## Boomer</span>',
		'color:grey', // Change name style; optional
		'color:grey' // Change tripcode style; optional
	);

	// "## Nigger" makes everything brown and bold, including the name and tripcode:
        $config['custom_capcode']['Nigger'] = array(
			'<span class="capcode" style="color:#964B00"> ## Nigger</span>',
			'color:#964B00; font-weight:bold', // Change name style; optional
			'color:#964B00;', // Change tripcode style; optional
							'margin-left:0;' // Change tripcode style; optional
	);
        // "## Admin" makes everything red and bold, including the name and tripcode:
        $config['custom_capcode']['Admin'] = array(
			'<span class="capcode" style="color:#ff0000"> ## Admin</span>',
			'color:#ff0000; font-weight:bold', // Change name style; optional
	//		'color:#ff0000;', // Change tripcode style; optional
	//		'margin-left:0;' // Change tripcode style; optional
	);

	$config['custom_capcode']['Chairman'] = array(
			'<span class="capcode" style="color:#ff0000"> ## Chairman</span>',
			'color:#ff0000; font-weight:bold', // Change name style; optional
			'color:#ff0000;', // Change tripcode style; optional
			'margin-left:0;' // Change tripcode style; optional
	);

	$config['custom_capcode']['Ogre'] = array(
			'<span class="capcode" style="color:#cee919"> ## Ogre</span>',
			'color:#cee919; font-weight:bold', // Change name style; optional
			'color:#cee919;', // Change tripcode style; optional
			'margin-left:0;' // Change tripcode style; optional
	);

	$config['custom_capcode']['Claus'] = array(
                        '<span class="capcode" style="color:#ff0000"> ## Claus</span>',
                        'color:#ff0000; font-weight:bold', // Change name style; optional
                        'color:#ff0000;', // Change tripcode style; optional
			'margin-left:0;' // Change tripcode style; optional
        );

	        // "## BIG BUDDY" makes everything red and bold, including the name and tripcode:
			$config['custom_capcode']['BIG BUDDY'] = array(
				'<span class="capcode" style="color:#ff0000"> ## BIG BUDDY</span>',
				'color:#ff0000; font-weight:bold', // Change name style; optional
				'color:#ff0000;', // Change tripcode style; optional
								'margin-left:0;' // Change tripcode style; optional
		);
	// "## Epstein" makes everything red and bold, including the name and tripcode:
			$config['custom_capcode']['Epstein'] = array(
				'<span class="capcode" style="color:#ff0000"> ## Epstein</span>',
				'color:#ff0000; font-weight:bold', // Change name style; optional
				'color:#ff0000;', // Change tripcode style; optional
								'margin-left:0;' // Change tripcode style; optional
	);

        // "## Admin" makes everything red and bold, including the name and tripcode:
        $config['custom_capcode']['ADMIN'] = array(
			'<span class="capcode" style="color:#ff0000"> ## ADMIN</span>',
			'color:#ff0000; font-weight:bold', // Change name style; optional
			'color:#ff0000;', // Change tripcode style; optional
							'margin-left:0;' // Change tripcode style; optional
	);

        // "## Admin" makes everything red and bold, including the name and tripcode:
        $config['custom_capcode']['Admin2'] = array(
			'<span class="capcode" style="color:#ff0000"> ## Admin</span>',
			'color:#ff0000; font-weight:bold', // Change name style; optional
			'color:#ff0000;', // Change tripcode style; optional
							'margin-left:0;' // Change tripcode style; optional
        );

        // Froot:
        $config['custom_capcode']['Froot'] = array(
			'<span class="capcode" style="color:#db7500"> ## Froot</span>',
			'color:#db7500; font-weight:bold', // Change name style; optional
			'color:#db7500;', // Change tripcode style; optional
							'margin-left:0;' // Change tripcode style; optional
	);
	// Froot:
	$config['custom_capcode']['TRUMP'] = array(
		'<span class="capcode" style="color:#db7500"> ## TRUMP</span>',
		'color:#db7500; font-weight:bold', // Change name style; optional
		'color:#db7500;', // Change tripcode style; optional
						'margin-left:0;' // Change tripcode style; optional
);

	//background: linear-gradient(90deg, rgba(91,206,250,1) 0%, rgba(245,169,184,1) 25%, rgba(255,255,255,1) 50%, rgba(245,169,184,1) 75%, rgba(91,206,250,1) 100%);

	$config['custom_capcode']['Queen'] = array('## Queen</span>',
	'\"></span> <span class="capcode" style="background-image: linear-gradient(90deg, rgba(91,206,250,1) 0%, rgba(245,169,184,1) 25%, rgba(255,255,255,1) 50%, rgba(245,169,184,1) 75%, rgba(91,206,250,1) 100%);-webkit-background-clip: text;background-clip: text;color: transparent; font-weight:bold;"><span class="n" id=\"'
	);
	

	// FDL:
        $config['custom_capcode']['FDL'] = array(
			'<span class="capcode" style="color:#db7500"> ## FDL</span>',
			'color:#db7500; font-weight:bold', // Change name style; optional
			'color:#db7500;', // Change tripcode style; optional
							'margin-left:0;' // Change tripcode style; optional
	);

	// FDL:
        $config['custom_capcode']['Vaxxed'] = array(
			' <span class="capcode" style="color:#00ff00">#IGOTVACCINATED ü•≥üíâü´Éüèø</span>'
	);

        $config['custom_capcode']['Booster'] = array(
			' <span class="capcode" style="color:#ff0000">(BOOSTER SHOT DUE, SEEK MEDICAL ATTENTION)</span>'
	);

	// "## Developer" makes everything gold and bold, including the name and tripcode:
	$config['custom_capcode']['NewDeveloper'] = array(
		'<span class="capcode" style="color:#f5cd00;font-weight:bold"> ## Developer</span>',
		'color:#f5cd00; font-weight:bold', // Change name style; optional
		'color:#f5cd00;' // Change tripcode style; optional
	);

        // Blue Developer
        $config['custom_capcode']['oldDeveloper'] = array(
                '<span class="capcode" style="color:#0066cc;font-weight:bold"> ## Developer</span>',
                'color:#0066cc; font-weight:bold', // Change name style; optional
                'color:#0066cc;' // Change tripcode style; optional
        );

        $config['custom_capcode']['President'] = array(
                '<span class="capcode" style="color:#0066cc;font-weight:bold"> ## President</span>',
                'color:#0066cc; font-weight:bold', // Change name style; optional
                'color:#0066cc;' // Change tripcode style; optional
        );

	$config['custom_capcode']['Pope'] = array(
                '<span class="capcode" style="color:#498201;font-weight:bold"> ## Pope</span>',
                'color:#498201; font-weight:bold', // Change name style; optional
                'color:#498201;' // Change tripcode style; optional
        );

	// Manager
	$config['custom_capcode']['Manager'] = array(
		'<span class="capcode" style="color:#814a0d;font-weight:bold"> ## %s</span>',
		//'<span class="capcode" style="color:#ff3c9a;font-weight:bold"> ## %s</span>',
		'color:#814a0d; font-weight:bold', // Change name style; optional
		'color:#814a0d;' // Change tripcode style; optional
	);

        // Pink Manager
        $config['custom_capcode']['oldManager'] = array(
                '<span class="capcode" style="color:#ff3c9a;font-weight:bold"> ## Manager</span>',
                //'<span class="capcode" style="color:#ff3c9a;font-weight:bold"> ## %s</span>',
                'color:#ff3c9a; font-weight:bold', // Change name style; optional
                'color:#ff3c9a;' // Change tripcode style; optional
        );

	// Enable the moving of single replies
	$config['move_replies'] = false;

	// How often (minimum) to purge the ban list of expired bans (which have been seen). Only works when
	//  $config['cache'] is enabled and working.
	$config['purge_bans'] = 60 * 60 * 12; // 12 hours

	// Do DNS lookups on IP addresses to get their hostname for the moderator IP pages (?/IP/x.x.x.x).
	$config['mod']['dns_lookup'] = true;
	// How many recent posts, per board, to show in ?/IP/x.x.x.x.
	$config['mod']['ip_recentposts'] = 5;

	// Number of posts to display on the reports page.
	$config['mod']['recent_reports'] = 50;
	// Number of actions to show per page in the moderation log.
	$config['mod']['modlog_page'] = 350;
	// Number of bans to show per page in the ban list.
	$config['mod']['banlist_page'] = 350;
	// Number of news entries to display per page.
	$config['mod']['news_page'] = 40;
	// Number of results to display per page.
	$config['mod']['search_page'] = 1000;
	// Number of entries to show per page in the moderator noticeboard.
	$config['mod']['noticeboard_page'] = 50;
	// Number of entries to summarize and display on the dashboard.
	$config['mod']['noticeboard_dashboard'] = 5;

	// Check public ban message by default.
	$config['mod']['check_ban_message'] = false;
	// Default public ban message. In public ban messages, %length% is replaced with "for x days" or
	// "permanently" (with %LENGTH% being the uppercase equivalent).
	$config['mod']['default_ban_message'] = _('USER WAS BANNED FOR THIS POST');
	// $config['mod']['default_ban_message'] = 'USER WAS BANNED %LENGTH% FOR THIS POST';
	// HTML to append to post bodies for public bans messages (where "%s" is the message).
	$config['mod']['ban_message'] = '<span class="public_ban">(%s)</span>';

	// Reason used for temp bans
	$config['mod']['temp_ban_reason'] = "Pending ban request.";
	// Length used for temp bans
	$config['mod']['temp_ban_length'] = "15m";

	// When moving a thread to another board and choosing to keep a "shadow thread", an automated post (with
	// a capcode) will be made, linking to the new location for the thread. "%s" will be replaced with a
	// standard cross-board post citation (>>>/board/xxx)
	$config['mod']['shadow_mesage'] = _('Moved to %s.');
	// Capcode to use when posting the above message.
	$config['mod']['shadow_capcode'] = 'Mod';
	// Name to use when posting the above message. If false, $config['anonymous'] will be used.
	$config['mod']['shadow_name'] = false;

	// Boards put at the top of the move page for easy access
	$config['mod']['common_move_destination_boards'] = array('qa', 'pol', 'q', 'mtv', 'nate');

	// PHP time limit for ?/rebuild. A value of 0 should cause PHP to wait indefinitely.
	$config['mod']['rebuild_timelimit'] = 0;

	// PM snippet (for ?/inbox) length in characters.
	$config['mod']['snippet_length'] = 75;

	// Edit raw HTML in posts by default.
	$config['mod']['raw_html_default'] = false;

	// Automatically dismiss all reports regarding a thread when it is locked.
	$config['mod']['dismiss_reports_on_lock'] = true;

	// Replace ?/config with a simple text editor for editing inc/instance-config.php.
	$config['mod']['config_editor_php'] = false;

	// How many mediator votes must be made before a post is deleted.
	$config['mediator_threshold'] = 5;

	// Preset ban reasons and lengths
	$config['mod']['ban_presets'] = [
		['Illegal content', '1. - You WILL NOT upload, post, request, or link to illegal content.', [''], true],
		['Violence/Terrorism', '8. - You WILL NOT make credible threats or promote real-world violence or terrorism.', [''], true],
		['Swatting', '1. - Announcing or calling for "swattings" is FORBIDDEN.', [''], true],
		['Child abuse', '1. - Realistic depictions of child abuse are FORBIDDEN.', [''], true],
		['Pedophilia', '2. - You WILL NOT post, promote, or advocate for pedophilia or pedophilic content, including pedophilic jokes.', ['3d', '7d', ''], false],
		['Advertising', '3. - You WILL NOT advertise for imageboards, discord servers, telegram channels, crypto projects, etc.', ['1d', '7d', ''], true],
		['Offsiter', '3. - Participation in disruptive off-site communities is FORBIDDEN.', [''], true],
		//['Spam', '4. - You WILL NOT excessively spam.', ['15m', '1h', '12h', '3d'], false],
		['Lag post', '4. - You WILL NOT make posts intended to slow down others\' browsers.', ['15m', '1h', '12h', '3d'], true],
		['Off-topic', '5. - You WILL adhere to the general topic or theme of the board you are posting on. Off-topic posts may be moved or deleted.', ['15m', '1h', '12h', '3d'], false],
		['Animal abuse/bestiality', '6. - You WILL NOT post, promote, or advocate for animal abuse or bestiality.', [''], false],
		['Suicide encouragement/announcement', '7. - You WILL NOT post suicide announcements or genuinely attempt to push others towards suicide or self-harm.', [''], true],
		['Trying to take down the site', '9. - You WILL NOT attempt to get the site taken down.', [''], true],
		['Embedded content', '10. - You WILL NOT post files containing embedded content.', ['1d', ''], false],
		['Report spam', '11. - You WILL NOT spam false reports.', ['15m', '12h', '3d'], false],
		['Urgent report abuse', '11. - You WILL NOT abuse the urgent report feature.', ['15m', '12h', '3d'], false],
		['Botting', '12. - You WILL NOT use any sort of bot to automate posting on the site.', [''], false],
		['Underage', '13. - You WILL NOT use this website if you are under the age of 18.', [''], false],
		['Roblox', '13. - Roblox discussion and raids are FORBIDDEN.', ['3d', ''], false],
		['Porn/Gore', '14. - You WILL NOT post pornographic content or graphic gore.', ['12h', '3d', '7d', '30d'], false],
		['Ban evasion', 'Ban evasion.', [''], false],
	];
/*
 * ====================
 *  Mod permissions
 * ====================
 */

	// Probably best not to change this unless you are smart enough to figure out what you're doing. If you
	// decide to change it, remember that it is impossible to redefinite/overwrite groups; you may only add
	// new ones.
	$config['mod']['groups'] = array(
		5 	=> 'None',
		6 	=> 'Mediator',
		7	=> 'JokeJanny',
		8	=> 'President',
		10	=> 'Janitor',
		12	=> 'FDL',
		13	=> 'Superjanny',
		20	=> 'Mod',
		21	=> 'BoardManager',
		23	=> 'Soor',
		25	=> 'Manager',
		30	=> 'Admin',
		// 98	=> 'God',
		99	=> 'Disabled'
	);

	// If you add stuff to the above, you'll need to call this function immediately after.
	define_groups();

	// Example: Adding a new permissions group.
	// $config['mod']['groups'][0] = 'NearlyPowerless';
	// define_groups();

	// Capcode permissions.
	$config['mod']['capcode'] = array(
	//	JANITOR		=> array('Janitor'),
		JOKEJANNY	=> array('Councillor'),
		PRESIDENT	=> array('President', 'Pope'),
		MOD		=> array('Blue'),
		BOARDMANAGER	=> array('Mod'),
		SOOR		=> true,
		MANAGER		=> array('Mod', 'ModMod', 'Manager', 'Chairman', 'FDL', 'Thanos', 'Admin', 'Lord', 'Ogre', 'BIG BUDDY'),
		ADMIN		=> true
	);

	// Example: Allow mods to post with "## Moderator" as well
	// $config['mod']['capcode'][MOD][] = 'Moderator';
	// Example: Allow janitors to post with any capcode
	// $config['mod']['capcode'][JANITOR] = true;

	// Set any of the below to "DISABLED" to make them unavailable for everyone.

	// Don't worry about per-board moderators. Let all mods moderate any board.
	$config['mod']['skip_per_board'] = false;

	/* Post Controls */
	// Vote on a post for deletion
	$config['mod']['mediator_vote'] = MEDIATOR;
	// Extra votes for vote.php
	$config['mod']['extra_votes'] = JOKEJANNY;
	// View IP addresses
	$config['mod']['show_ip'] = SUPERJANNY;
	// View per-thread IDs in all threads if mod lacks permission show_ip
	$config['mod']['show_id_everywhere'] = DISABLED;
	// View file hashes
	$config['mod']['show_filehash'] = DISABLED;
	// View browser hashes
	$config['mod']['show_browserhash'] = MOD;
	// View integrity flags
	$config['mod']['show_integrity'] = MOD;
	// View [New] and [VPN]
	$config['mod']['show_scum'] = JANITOR;
	// Delete a post
	$config['mod']['delete'] = JOKEJANNY;
	// Request a ban for a post
	$config['mod']['ban_request'] = JOKEJANNY;
	// Give a user a temporary ban when requesting a ban
	$config['mod']['temp_ban'] = SUPERJANNY;
	// Ban a user for a post
	$config['mod']['ban'] = MOD;
	// Ban and delete (one click; instant)
	$config['mod']['bandelete'] = MOD;
	// Ban from a specific thread
	$config['mod']['threadban'] = ADMIN;
	// Remove bans
	$config['mod']['unban'] = MOD;
	// Ban multiple IPs with a subnet mask
	$config['mod']['rangeban'] = MANAGER;
	// Spoiler image
	$config['mod']['spoilerimage'] = MOD;
	// Mark files as NSFW
	$config['mod']['mark_nsfw'] = DISABLED;
	// Edit bans
	$config['mod']['edit_ban'] = MOD;
	// Delete file (and keep post)
	$config['mod']['deletefile'] = MOD;
	// Delete all posts by IP
	$config['mod']['deletebyip'] = SUPERJANNY;
	// Delete all posts by IP across all boards
	$config['mod']['deletebyip_global'] = SOOR;
	// Delete all posts by IP within a thread
	$config['mod']['deletebyip_thread'] = SUPERJANNY;
	// Hashban a file to prevent it from being posted again
	$config['mod']['hashbanfile'] = MOD;
	// Sticky a thread
	$config['mod']['sticky'] = BOARDMANAGER;
	// Invincible a thread
	$config['mod']['invincible'] = BOARDMANAGER;
	// Cycle a thread
	$config['mod']['cycle'] = SOOR;
	$config['cycle_limit'] = &$config['reply_limit'];
	// Post on locked boards
	$config['mod']['post_on_locked_board'] = JANITOR;
	// Lock a thread
	$config['mod']['lock'] = MOD;
	// Post in a locked thread
	$config['mod']['postinlocked'] = MOD;
	// Prevent a thread from being bumped
	$config['mod']['bumplock'] = MOD;
	// View whether a thread has been bumplocked ("-1" to allow non-mods to see too)
	$config['mod']['view_bumplock'] = MOD;
	// Edit any post
	$config['mod']['editpost'] = ADMIN;
	// Edit their own capcode posts
	$config['mod']['editownpost'] = MOD;
	// "Move" a thread to another board (EXPERIMENTAL; has some known bugs)
	$config['mod']['move'] = MOD;
	// Bypass "field_disable_*" (forced anonymity, etc.)
	$config['mod']['bypass_field_disable'] = MOD;
	// Post bypass unoriginal content check on robot-enabled boards
	$config['mod']['postunoriginal'] = MOD;
	// Bypass flood check
	$config['mod']['bypass_filters'] = DISABLED;
	$config['mod']['flood'] = DISABLED;
	// Use capcodes
	$config['mod']['use_capcode'] = NONE;
	// Select any flag on flag boards
	$config['mod']['falseflag'] = SUPERJANNY;
	// Raw HTML posting
	$config['mod']['rawhtml'] = ADMIN;
	// Bypass bans
	$config['mod']['bypass_bans'] = DISABLED;
	/* Administration */
	// View the report queue
	$config['mod']['reports'] = MEDIATOR;
	// Dismiss an abuse report
	$config['mod']['report_dismiss'] = JANITOR;
	// Dismiss all abuse reports by an IP
	$config['mod']['report_dismiss_ip'] = SUPERJANNY;
	// Dismiss all abuse reports for a post
	$config['mod']['report_dismiss_post'] = JANITOR;
	// View and interact with file approval queue
	$config['mod']['file_approval'] = MEDIATOR;
	// View list of bans
	$config['mod']['view_banlist'] = MOD;
	// View the username of the mod who made a ban
	$config['mod']['view_banstaff'] = SOOR;
	// If the moderator doesn't fit the $config['mod']['view_banstaff''] (previous) permission, show him just
	// a "?" instead. Otherwise, it will be "Mod" or "Admin".
	$config['mod']['view_banquestionmark'] = true;
	// Show expired bans in the ban list (they are kept in cache until the culprit returns)
	$config['mod']['view_banexpired'] = true;
	// View ban for IP address
	$config['mod']['view_ban'] = $config['mod']['show_ip'];
	// View IP address notes
	$config['mod']['view_notes'] = $config['mod']['show_ip'];
	// Create notes
	$config['mod']['create_notes'] = $config['mod']['view_notes'];
	// Remote notes
	$config['mod']['remove_notes'] = ADMIN;
	// Create a new board
	$config['mod']['newboard'] = SOOR;
	// Manage existing boards (change title, etc)
	$config['mod']['manageboards'] = SOOR;
	// Delete a board
	$config['mod']['deleteboard'] = ADMIN;
	// List/manage users
	$config['mod']['manageusers'] = SOOR;
	// Promote/demote users
	$config['mod']['promoteusers'] = ADMIN;
	// Edit any users' login information
	$config['mod']['editusers'] = ADMIN;
	// Change user's own password
	$config['mod']['change_password'] = NONE;
	// Delete a user
	$config['mod']['deleteusers'] = ADMIN;
	// Create a user
	$config['mod']['createusers'] = ADMIN;
	// View the moderation log
	$config['mod']['modlog'] = SOOR;
	// View IP addresses of other mods in ?/log
	$config['mod']['show_ip_modlog'] = SOOR;
	// View relevant moderation log entries on IP address pages (ie. ban history, etc.) Warning: Can be
	// pretty resource intensive if your mod logs are huge.
	$config['mod']['modlog_ip'] = SUPERJANNY;
	// Create a PM (viewing mod usernames)
	$config['mod']['create_pm'] = NONE;
	// Read any PM, sent to or from anybody
	$config['mod']['master_pm'] = MANAGER;
	// Rebuild everything
	$config['mod']['rebuild'] = MANAGER;
	// Search through posts, IP address notes and bans
	$config['mod']['search'] = JANITOR;
	// Allow searching posts (can be used with board configuration file to disallow searching through a
	// certain board)
	$config['mod']['search_posts'] = JANITOR;
	// Read the moderator noticeboard
	$config['mod']['noticeboard'] = JANITOR;
	// Post to the moderator noticeboard
	$config['mod']['noticeboard_post'] = MOD;
	// Delete entries from the noticeboard
	$config['mod']['noticeboard_delete'] = SOOR;
	// Public ban messages; attached to posts
	$config['mod']['public_ban'] = SOOR;
	// Manage and install themes for homepage
	$config['mod']['themes'] = ADMIN;
	// Post news entries
	$config['mod']['news'] = SOOR;
	// Custom name when posting news
	$config['mod']['news_custom'] = SOOR;
	// Delete news entries
	$config['mod']['news_delete'] = SOOR;
	// Execute un-filtered SQL queries on the database (?/debug/sql)
	$config['mod']['debug_sql'] = ADMIN;
	// Look through all cache values for debugging when APC is enabled (?/debug/apc)
	$config['mod']['debug_apc'] = ADMIN;
	// Edit the current configuration (via web interface)
	$config['mod']['edit_config'] = ADMIN;
	// View ban requests
	$config['mod']['view_ban_requests'] = JANITOR;
	// View ban appeals
	$config['mod']['view_ban_appeals'] = SOOR;
	// Accept and deny ban appeals
	$config['mod']['ban_appeals'] = SOOR;
	// View the recent posts page
	$config['mod']['recent'] = MEDIATOR;
	// Create pages
	$config['mod']['edit_pages'] = ADMIN;
	$config['pages_max'] = 10;
	// Show sensitive info, such as passwords
	$config['mod']['show_sensitive'] = MANAGER;
	// Approve new news
	$config['mod']['approve_news'] = MOD;
	// Activate the mandate
	$config['mod']['panic_button'] = JANITOR;
	// Bypass the choice limit for poll creation
	$config['mod']['bypass_poll_choice_limit'] = MOD;
	// Show the results of all polls, even when their results are hidden
	$config['mod']['poll_snooping'] = MANAGER;
	// Show which IPs voted for which choices on polls
	$config['mod']['show_poll_ips'] = MANAGER;
	// Flag IPs as VPNs
	$config['mod']['flag_vpn'] = $config['mod']['show_sensitive'];
	// Config editor permissions
	$config['mod']['config'] = array();

	// Disable the following configuration variables from being changed via ?/config. The following default
	// banned variables are considered somewhat dangerous.
	$config['mod']['config'][DISABLED] = array(
		'mod>config',
		'mod>config_editor_php',
		'mod>groups',
		'convert_args',
		'db>password',
	);
	
	$config['mod']['config'][JANITOR] = array(
		'!', // Allow editing ONLY the variables listed (in this case, nothing).
	);
	
	$config['mod']['config'][MOD] = array(
		'!', // Allow editing ONLY the variables listed (plus that in $config['mod']['config'][JANITOR]).
		'global_message',
	);
	
	// Example: Disallow ADMIN from editing (and viewing) $config['db']['password'].
	// $config['mod']['config'][ADMIN] = array(
	// 	'db>password',
	// );
	
	// Example: Allow ADMIN to edit anything other than $config['db']
	// (and $config['mod']['config'][DISABLED]).
	// $config['mod']['config'][ADMIN] = array(
	// 	'db',
	// );
	//This is primarily used for bots and other automated systems. It is not recommended to use this for regular users.
	$config['mod']['csrf_whitelist'] = array(109, 137);
	// Allow OP to remove arbitrary posts in his thread
	$config['user_moderation'] = false;

	// File board. Like 4chan /f/
	$config['file_board'] = false;

	// Thread tags. Set to false to disable
	// Example: array('A' => 'Chinese cartoons', 'M' => 'Music', 'P' => 'Pornography');
	$config['allowed_tags'] = false;

/*
 * ====================
 *  Public pages
 * ====================
 */

	// Public post search settings
	$config['search'] = array();

	// Enable the search form
	$config['search']['enable'] = true;

	// Enable search in the board index.
	$config['board_search'] = true;

	// Maximal number of queries per IP address per minutes
	$config['search']['queries_per_minutes'] = Array(15, 2);

	// Global maximal number of queries per minutes
	$config['search']['queries_per_minutes_all'] = Array(50, 2);

	// Limit of search results
	$config['search']['search_limit'] = 500;
		
	// Boards for searching
	//$config['search']['boards'] = array('a', 'b', 'c', 'd', 'e');

	// Enable public logs? 0: NO, 1: YES, 2: YES, but drop names
	$config['public_logs'] = 0;

/*
 * ====================
 *  Events (PHP 5.3.0+)
 * ====================
 */

	// https://github.com/vichan-devel/vichan/wiki/events

	// event_handler('post', function($post) {
	// 	// do something
	// });

	// event_handler('post', function($post) {
	// 	// do something else
	// 	
	// 	// return an error (reject post)
	// 	return 'Sorry, you cannot post that!';
	// });

/*
 * =============
 *  API settings
 * =============
 */

	// Whether or not to enable the 4chan-compatible API, disabled by default. See
	// https://github.com/4chan/4chan-API for API specification.
	$config['api']['enabled'] = true;

	// Extra fields in to be shown in the array that are not in the 4chan-API. You can get these by taking a
	// look at the schema for posts_ tables. The array should be formatted as $db_column => $translated_name.
	// Example: Adding the pre-markup post body to the API as "com_nomarkup".
	// $config['api']['extra_fields'] = array('body_nomarkup' => 'com_nomarkup');

/*
 * ==================
 *  NNTPChan settings
 * ==================
 */

/*
 * Please keep in mind that NNTPChan support in vichan isn't finished yet / is in an experimental
 * state. Please join #nntpchan on Rizon in order to peer with someone.
 */

	$config['nntpchan'] = array();

	// Enable NNTPChan integration
	$config['nntpchan']['enabled'] = false;

	// NNTP server
	$config['nntpchan']['server'] = "localhost:1119";

	// Global dispatch array. Add your boards to it to enable them. Please make
	// sure that this setting is set in a global context.
	$config['nntpchan']['dispatch'] = array(); // 'overchan.test' => 'test'

	// Trusted peer - an IP address of your NNTPChan instance. This peer will have
	// increased capabilities, eg.: will evade spamfilter.
	$config['nntpchan']['trusted_peer'] = '127.0.0.1';

	// Salt for message ID generation. Keep it long and secure.
	$config['nntpchan']['salt'] = 'change_me+please';

	// A local message ID domain. Make sure to change it.
	$config['nntpchan']['domain'] = 'example.vichan.net';

	// An NNTPChan group name.
	// Please set this setting in your board/config.php, not globally.
	$config['nntpchan']['group'] = false; // eg. 'overchan.test'



/*
 * ====================
 *  Other/uncategorized
 * ====================
 */

	// Meta keywords. It's probably best to include these in per-board configurations.
	// $config['meta_keywords'] = 'chan,anonymous discussion,imageboard,vichan';

	// Website name
	$config['site_name'] = 'soyjak.party';
	// Website domain
	$config['site_domain'] = 'soyjak.st';

	// Link imageboard to your Google Analytics account to track users and provide traffic insights.
	// $config['google_analytics'] = 'UA-xxxxxxx-yy';
	// Keep the Google Analytics cookies to one domain -- ga._setDomainName()
	// $config['google_analytics_domain'] = 'www.example.org';

	// Link imageboard to your Statcounter.com account to track users and provide traffic insights without the Google botnet.
	// Extract these values from Statcounter's JS tracking code:
	// $config['statcounter_project'] = '1234567';
	// $config['statcounter_security'] = 'acbd1234';

	// If you use Varnish, Squid, or any similar caching reverse-proxy in front of vichan, you can
	// configure vichan to PURGE files when they're written to.
	// $config['purge'] = array(
	// 	array('127.0.0.1', 80)
	// 	array('127.0.0.1', 80, 'example.org')
	// );

	/*
	$config['cf_purge'] = array();
	$config['cf_purge']['domain'] = $config['site_domain'];
	$config['cf_purge']['zone_id'] = '53c420074f8c77d3c7f89463a5cd76cb';
	$config['cf_purge']['token'] = '5C9FkfeRb-uUmps9RN39-n2qMgpYiAKStk31dh8V';
	*/

	// Connection timeout for $config['purge'], in seconds.
	$config['purge_timeout'] = 3;

	// Additional mod.php?/ pages. Look in inc/mod/pages.php for help.
	// $config['mod']['custom_pages']['/something/(\d+)'] = function($id) {
	// 	global $config;
	// 	if (!hasPermission($config['mod']['something']))
	// 		error($config['error']['noaccess']);
	// 	// ...
	// };

	// You can also enable themes (like ukko) in mod panel like this:
	require_once("templates/themes/ukko/theme.php");
	
	$config['mod']['custom_pages']['/o'] = function() {
		$ukko = new ukko();
	        $ukko->settings = array();
	        $ukko->settings['uri'] = 'o';
	        $ukko->settings['title'] = 'Overboard';
	        $ukko->settings['subtitle'] = '';
	        $ukko->settings['thread_limit'] = 15;
	        $ukko->settings['exclude'] = 'j mediator';
	
		echo $ukko->build(true);
	};

	// Example: Add links to dashboard (will all be in a new "Other" category).
	// $config['mod']['dashboard_links']['Something'] = '?/something';

	// Remote servers. I'm not even sure if this code works anymore. It might. Haven't tried it in a while.
	// $config['remote']['static'] = array(
	// 	'host' => 'static.example.org',
	// 	'auth' => array(
	// 		'method' => 'plain',
	// 		'username' => 'username',
	// 		'password' => 'password!123'
	// 	),
	// 	'type' => 'scp'
	// );

	// Create gzipped static files along with ungzipped.
	// This is useful with nginx with gzip_static on.
	$config['gzip_static'] = false;

	// Regex for board URIs. Don't add "`" character or any Unicode that MySQL can't handle. 58 characters
	// is the absolute maximum, because MySQL cannot handle table names greater than 64 characters.
	$config['board_regex'] = '[0-9a-zA-Z$_\x{0080}-\x{FFFF}]{1,58}';

	/* Invidious died
	$config['youtube_js_html'] = '<div class="embed-container">'.
		'<iframe src="https://invidious.fdn.fr/embed/$2" frameborder="0" allowfullscreen>'.
		'</iframe>'.
		'</div>';
	*/

	// Password hashing function
	//
	// $5$ <- SHA256
	// $6$ <- SHA512
	//
	// 25000 rounds make for ~0.05s on my 2015 Core i3 computer.
	//
	// https://secure.php.net/manual/en/function.crypt.php
	$config['password_crypt'] = '$6$rounds=25000$';

	// Password hashing method version
	// If set to 0, it won't upgrade hashes using old password encryption schema, only create new.
	// You can set it to a higher value, to further migrate to other password hashing function.
	$config['password_crypt_version'] = 1;

	// Use CAPTCHA for reports?
	$config['report_captcha'] = false;

	// Allowed HTML tags in ?/edit_pages.
	$config['allowed_html'] = 'a[href|title],p,br,li,ol,ul,strong,em,u,h2,b,i,tt,div,img[src|alt|title],hr';

	// Secret passphrase for IP cloaking
	// Disabled if empty.
	//$config['ipcrypt_key'] = '*%tHT6cSJkD!ma6j()K&iTd7GhA@PN8UuUxXRD*u';
	//$config['ipcrypt_key'] = 'HtGb107FnFKVol7H';
	//$config['ipcrypt_key'] = '';
	//$config['ipcrypt_key'] = 'CtHU7EH8BMldFzUZ';
	$config['ipcrypt_key'] = 'x1Vlo2M5MSh4PkNj4ZX20FdbaNJ5uLMrgMBq3mIdRMmqQK7zYdnQhkCOCIzBPmhqfgBatdcWK8nKhSXh1QRxB3V0LwTVYXqVimL2azX9fRfqvqWYdc5zhfxzyTLd0spw';

	// IP cloak prefix
	$config['ipcrypt_prefix'] = 'Cloak';

	// Whether to append domain names to IP cloaks
	$config['ipcrypt_dns'] = false;

	// McCaptcha
	$config['mccaptcha'] = false;
	$config['mccaptcha_bypass_posts'] = 1;

	// rDrama style item shop
	$config['item_shop'] = false;

	// REMOTE_ADDR used by hidden service connections
	$config['onion_addr'] = '0.0.0.0';

	$config['pride_month_2025'] = false;

	$config['time_soyfest'] = false;

	$config['require_quote_op'] = false;
