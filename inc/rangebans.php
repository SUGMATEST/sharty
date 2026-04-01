<?php

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            if (preg_match('/333 Lindenwood/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            if (preg_match('/4516 Calhoun/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            // Check if the post body contains the word "imgbb.com" (case-insensitive)
        
            if (str_contains(strtolower($post['body']), "imgbb.com")) {
                return true; // Match found, return true
            } else {
                return false; // No match, return false
            }
        }
    ),
    'action' => 'reject',
    'message' => 'The site "imgbb.com" is banned due to CSAM.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            // Check if the post body contains the word "tinyurl.com" (case-insensitive)
            $bodyNoSpace = str_replace(' ', '', $post['body']);
            if (str_contains(strtolower($bodyNoSpace), "tinyurl.com")) {
                return true; // Match found, return true
            } else {
                return false; // No match, return false
            }
        }
    ),
    'action' => 'reject',
    'message' => 'The site "tinyurl.com" is banned due to CSAM.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            // Check if the post body contains the word "ibb.co" (case-insensitive)
        
            if (str_contains(strtolower($post['body']), "ibb.co")) {
                return true; // Match found, return true
            } else {
                return false; // No match, return false
            }
        }
    ),
    'action' => 'reject',
    'message' => 'The site "ibb.co" is banned due to CSAM.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            // Check if the post body contains the word "ibb.co" (case-insensitive)
        
            if (str_contains(strtolower($post['body']), "tli.su")) {
                return true; // Match found, return true
            } else {
                return false; // No match, return false
            }
        }
    ),
    'action' => 'reject',
    'message' => 'The site "tli.su" is banned due to CSAM.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            // Check if the post body contains the word "ibb.co" (case-insensitive)
        
            if (str_contains(strtolower($post['body']), "tiny.tw")) {
                return true; // Match found, return true
            } else {
                return false; // No match, return false
            }
        }
    ),
    'action' => 'reject',
    'message' => 'The site "tiny.tw" is banned due to CSAM.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            // Check if the post body contains the word "ibb.co" (case-insensitive)
        
            if (str_contains(strtolower($post['body']), "matrix.to")) {
                return true; // Match found, return true
            } else {
                return false; // No match, return false
            }
        }
    ),
    'action' => 'reject',
    'message' => 'The site "matrix.to" is banned due to CSAM.'
);
//
$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            // Check if the post body contains the word "ibb.co" (case-insensitive)
        
            if (str_contains(strtolower($post['body']), "dawgvideo.rf.gd")) {
                return true; // Match found, return true
            } else {
                return false; // No match, return false
            }
        }
    ),
    'action' => 'reject',
    'message' => 'The site "dawgvideo.rf.gd" is banned due to CSAM.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            $stringWithoutSpaces = str_replace(' ', '', strtolower($post['body']));
            if (str_contains(strtolower($stringWithoutSpaces), "skajyos")) {
                return true; // Match found, return true
            }
            if (str_contains(strtolower($stringWithoutSpaces), "jassy")) {
                return true; // Match found, return true
            }
            if (str_contains(strtolower($stringWithoutSpaces), "sync-tube.de")) {
                return true; // Match found, return true
            }
            if (str_contains(strtolower($stringWithoutSpaces), "jartybooru")) {
                return true; // Match found, return true
            }
            if (str_contains(strtolower($stringWithoutSpaces), "foodist")) {
                return true; // Match found, return true
            }
            if (str_contains(strtolower($stringWithoutSpaces), "bu5t")) {
                return true; // Match found, return true
            }
            if (str_contains(strtolower($stringWithoutSpaces), "skibidifarms")) {
                return true; // Match found, return true
            }
            if (str_contains(strtolower($stringWithoutSpaces), "transchan")) {
                return true; // Match found, return true
            }
	    if (str_contains(strtolower($stringWithoutSpaces), "sy26getjFV")) {
                return true; // Match found, return true
            }
            if (str_contains(strtolower($stringWithoutSpaces), "deadnigger")) {
                return true; // Match found, return true
            }
            else {
                return false; // No match, return false
            }
        }
    ),
    'action' => 'reject',
    'message' => 'Spam detected. Post discarded.'
);

/*
//Baby Bot patterns
$config['filters'][] = array(
    'condition' => array(
        'filename' => '/^ClipboardImage.png$/',
        'OP' => false,
    ),
    'action' => 'reject',
    'message' => 'Possible spam detected.'
);

$config['filters'][] = array(
    'condition' => array(
        'filename' => '/frog/',
        'OP' => false,
    ),
    'action' => 'ban',
    'reason' => 'Ban evasion.'
);
$config['filters'][] = array(
    'condition' => array(
        'filename' => '/jpg/',
        'OP' => false,
    ),
    'action' => 'ban',
    'reason' => 'Ban evasion (2).'
);
$config['filters'][] = array(
    'condition' => array(
        'filename' => '/pep/',
        'OP' => false,
    ),
    'action' => 'ban',
    'reason' => 'Ban evasion.'
);
$config['filters'][] = array(
    'condition' => array(
        'filename' => '/ond/',
        'OP' => false,
    ),
    'action' => 'ban',
    'reason' => 'Ban evasion.'
);

$config['filters'][] = array(
    'condition' => array(
        'filename' => '/^[a-z][0-9]{8,10}\.jpg$/',
        'OP' => false,
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);
$config['filters'][] = array(
    'condition' => array(
        'filename' => '/^[0-9]{6,12}\.(jpg|jpeg|png)$/',
        'OP' => false,
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);
$config['filters'][] = array(
    'condition' => array(
        'filename' => '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}.(png)$/',
        'OP' => false,
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);

$config['filters'][] = array(
    'condition' => array(
        'filename' => '/^ClipboardImage.png$/',
        'OP' => false,
        'custom' => function($post) {
            if (preg_match('/caca/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);
*/

// CSAM filenames
$config['filters'][] = array(
    'condition' => array(
        'filename' => '/retep\.mp4/'
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '1. You will not post, link to, or request illegal content. (1)'
);
$config['filters'][] = array(
    'condition' => array(
        'filename' => '/1691461532398\.mp4/'
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '1. You will not post, link to, or request illegal content. (1)'
);
$config['filters'][] = array(
    'condition' => array(
        'filename' => '/linkedlinkedlinked/'
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '1. You will not post, link to, or request illegal content. (1)'
);

$config['filters'][] = array(
    'condition' => array(
        'filename' => '/^1661971134106.png$/',
        'OP' => true,
    ),
    'action' => 'ban',
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);
$config['filters'][] = array(
    'condition' => array(
        'filename' => '/^1642103887217.png$/',
        'OP' => true,
    ),
    'action' => 'ban',
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);

/*
//Ronald edit: probably doesn't need to exist anymore.
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) use ($config) {
            if (isset($post['image']) && isset($post['image']->size) && isset($post['image']->size->width) && isset($post['image']->size->height)) {
                $width = $post['image']->size->width;
                $height = $post['image']->size->height;
                if ($width == 93 && $height == 125) {
                    return true;
                }
            }
            return false;
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Your post contains text that appears to be spam.'
);
*/

//Robux kids
/*
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/(r|b)(o|0|u)bux/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
		 'expires' => 60 * 60 * 24, // 24 hours
    'reason' => 'There is no free robux here, the video lied to you.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/(r|b)(o|0|u)bux/i', $post['subject'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
		 'expires' => 60 * 60 * 24, // 24 hours
    'reason' => 'There is no free robux here, the video lied to you.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/soyjakzombietime/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
		 'expires' => 60 * 60 * 24, // 24 hours
    'reason' => 'There is no free robux here, the video lied to you.'
);
*/


//More baby bot stuff. Very aggressive. Only keep on for a short period of time. 
/*
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/W\s*[^a-zA-Z0-9]*\s*e\s*[^a-zA-Z0-9]*\s*i\s*[^a-zA-Z0-9]*\s*m\s*[^a-zA-Z0-9]*\s*a\s*[^a-zA-Z0-9]*\s*r/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/E\s*[^a-zA-Z0-9]*\s*u\s*[^a-zA-Z0-9]*\s*r\s*[^a-zA-Z0-9]*\s*o\s*[^a-zA-Z0-9]*\s*p\s*[^a-zA-Z0-9]*\s*a/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            // Modified regex pattern with space considerations
            $pattern = '/\b(A\s*m\s*a\s*r\s*i\s*a\s*h|A\s*b\s*i\s*m\s*e\s*l\s*e\s*c\s*h|A\s*h\s*i\s*t\s*u\s*b|C\s*h\s*r\s*i\s*s\s*t|M\s*e\s*s\s*h\s*o\s*b\s*a\s*b|J\s*a\s*m\s*l\s*e\s*c\s*h|J\s*o\s*s\s*h\s*a\s*h|A\s*m\s*a\s*z\s*i\s*a\s*h|E\s*l\s*i\s*e\s*z\s*e\s*r|R\s*e\s*h\s*a\s*b\s*i\s*a\s*h|J\s*e\s*s\s*u\s*s|J\s*o\s*r\s*a\s*m|Z\s*i\s*c\s*h\s*r\s*i|H\s*i\s*t\s*t\s*i\s*t\s*e\s*s|I\s*s\s*r\s*a\s*e\s*l|G\s*o\s*d|L\s*o\s*r\s*d|T\s*h\s*e\s*\s*f\s*a\s*t\s*h\s*e\s*r|H\s*i\s*s\s*\s*s\s*o\s*(\s*n\s*|\s*n\s*s\s*)|H\s*i\s*s\s*\s*d\s*a\s*u\s*g\s*h\s*t\s*e\s*(\s*r\s*|\s*r\s*s)|S\s*h\s*e\s*l\s*o\s*m\s*o\s*t\s*h|T\s*i\s*r\s*a\s*t\s*h\s*i\s*t\s*e\s*s|S\s*h\s*i\s*m\s*e\s*a\s*t\s*h\s*i\s*t\s*e\s*s|S\s*u\s*c\s*a\s*t\s*h\s*i\s*t\s*e\s*s|K\s*e\s*n\s*i\s*t\s*e\s*s|H\s*a\s*m\s*m\s*a\s*t\s*h|R\s*e\s*c\s*h\s*a\s*b|B\s*i\s*l\s*h\s*a\s*h|E\s*z\s*e\s*m|T\s*o\s*l\s*a\s*d)\b/i';

            if (preg_match($pattern, $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/heil trump/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);
//Yo Mama Botnet
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/y+o*u*\s*m+o*m+a+\s*\'*s*\s*so+s*\s*f+a+t+/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/y+o*u+\s*mo*m*a*m*a*\s*so*s*\s*ip+[aho]*[ndo]*[eo]*\s*it*\s*sa*id*i*\s*.*i\s*p+a*p+d+a/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/~i+\s*[phio]*\s*p+\s*[hio]*\s*h+\s*[pio]*\s*o+\s*[pni]*\s*n+\s*[phe]*\s*e+~/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);
/*
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/kZwqJ6vrp90/i', $post['embed'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/^(i|î|ï|í|i|i|ì)+ (a|à|á|â|ä|æ|ã|å|a)+(m)+ (b)+(a|à|á|â|ä|æ|ã|å|a)+(b)+(y)+$/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/^(c|ç|c|c)(a|à|á|â|ä|æ|ã|å|a)(c|ç|c|c)(a|à|á|â|ä|æ|ã|å|a)$/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
*/
//Thefrogpond
/*
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/clittywin/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/frogpond/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/pondwin/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/SO1CUCKS/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/OH NONONONONO/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/clitty won/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/frogwin/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/WAHT THE FUCK/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/LET ME SHOW YOU HOW TO RAID/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/bantgod yet/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/CANT EVEN STOP A SINGLE IMAGEBOARD RAID/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/CANT RAID/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/tfp won/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/raid like frogposters/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/frog on the log/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/GEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEG/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/frogpond win/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/LET ME SHOW YOU HOW TO RAAAAAIIIIIID/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/IS THIS A REAL RAID/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/so1cacas/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/NUISOISLUTTAS REALLY THINK THEY CAN RAID/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
$config['filters'][] = array(
    'condition' => array(
        'custom' => function($post) {
            if (preg_match('/pepe on the log/i', $post['body'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '9. Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);
*/

//Trooncord
$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            if (
                array_key_exists('filehash', $post) && in_array(
                    $post['filehash'],
                    array(
                        '7f37203f3f3f03e1',
                        'ffcf0f0f8790b226',
                        'ff0f8fff0707cfff',
                        'ffd90f0f8b90b0b6',
                        'ffd98f0f8b90b0b6',
                        'ff8383ffffffffff',
                        '30101c1c7c3c1818',
                        'd89f0f0f8f8190b8',
                        'bff1f0f0f0f89606',
                        '7c7c7c7c7c780000',
                        '7c7c7074707c7c00',
                        '007e7a7e7e7c0000',
                        '3e7e7a7e7e7c0000',
                        '7e70f0f0f0703c04',
                        '7c7c707074707038',
                        '7e7c707870787c3c',
                        '007e70f072787c04',
                        '7878707878787800',
                        '1078787878787c3c',
                        '9181818181777f0f',
                        'ffff8787878fffff',
                        '000000000000fefe',
                        'be925c44e4f0b580c3a6eda80e5aeefa',
                        '69518a4fb80b7e36a0ded99e8513ab4e',
                        '60233b390d8c8fff',
                        '7f7f034f2f1e1e06', //soygem.party
                        'dff7ff0000ffcddb',
                        'f9e1ff060007ff8b',
                        '007f7f7f7f3f0000', //backjack is da coooooord! derailment ss
                        'f9f9f0f0f0f08000', //shemmy
                        'fbf0f0f8f0f0b000',
                        'ff5e5b5d202d0900',
                        '9f9180ff888fffe0',
                        '72f8f8f8f8f87004',
                        '02f8f8f8f8f87004',
                        'fdfdd79115171909', //rapecord??????
                        'fdfdd79111171959',
                        '0000e1edede6e4c0', //invite i was told to hashban
//'efe7878780939387',
//'ef87878782939387',
                        '003c3e3f7e7effff',
                        'ed8d8787829393cf',
                        'e7ffe58191c3a360',


                    )
                )
            )
                return true;
            else
                return false;
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Advertising for imageboards, discord servers, telegram channels, crypto projects, etc. is not permitted.'
);


$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            if (
                array_key_exists('filehash', $post) && in_array(
                    $post['filehash'],
                    array(
                        '00000018b8ffffff',
                        '9d081c1e3eb3b9d3',
                        '3c3c7c6c2038b800',
                        '9f09181e3eb3b9d3',
                        '303878682f7ffefc',
                        '0038786c2ffffffc',
                        '003878682ffffefc',
                        '3f373f3908d89818',
                        '003878682ffffefc',
                        '0038786c2ffffefc',
                        '10181c3c3c3effc1',
                        '10181c3c3c3cffc1',
                        '00181c3c3c3cffc7',
                        'c7e3c3edd9d980d8',
                        'c7e3c3edd9d9805f',
                        'fe6c40e0c40000d2',
                        'c7c3c3cdd9d9805b',
                        'c7c3c3c9d9d9005b',
                        'e4e0f0f0f0e0c0c0',
                        'fefaf8f0f0c080c0',
			'c3c700afe23421a7138a0414f0f455b5',
                        '484481030a82333d7669948b0d17d154',
                        'c0e79d6d96a9fd2c0e345359a53e9d19',
                    )
                )
            )
                return true;
            else
                return false;
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '1. - You WILL NOT upload, post, request, or link to illegal content.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            if (
                in_array(
                    $post['password'],
                    array(
                        'Dh+xHaO)',
                        '*_Y6BB1p',
                        '7)FZcNW8',
                        'dsf3l',
                        'YwrYYJ$6',
                        '3rn8U2$N',
                        's9FfKlLV',
                        'VH(Xp!Jf',
                        ')&YZOSPd',
                        'EbjMj7yA',
                        'nU+awrSM', // Soygem.party spammer
                        'irHdHd$8', // Ban evading pol spammer
                        'dyrJRXhd', // mediator that spammed the site with masssive lines
                        '^2hapVOg',
                        'x_Yu$Lid',
                        'sHUa5_)i', // random skid
                        't4+^uZif',
                        '0@sXHRoL',
                        '(163oqlQ',
                        'a%lnWlyI',
                        'kN__LrXx',
                        '_ioXB)_C',
                        'lH6Fi##O',
			'+XkZy#2x',
			'8u_A97Ey'
                    )
                )
            )
                return true;
            else
                return false;
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            if (
                in_array(
                    $post['password'],
                    array(
                        'oEy(JTYx',
                        'LGWITw8l',
                        '*m8aFvRv',
                        '9B%60zO6',
                        'v4^nes_X',
                        '+oa9UjkM',
			'(NX&g_t(',
			'Kk%KNM3o'
                    )
                )
            )
                return true;
            else
                return false;
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '1. You will not post, link to, or request illegal content.'
);
//slash : /
//baskslash: \

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            $transliterated = AnyAscii::transliterate($post['body']);
            $spaces_removed = str_replace(' ', '', $transliterated);
            $spaces_removed = str_replace('-', '', $spaces_removed);
            $spaces_removed = str_replace('.', '', $spaces_removed);
            $spaces_removed = str_replace('_', '', $spaces_removed);
            $spaces_removed = str_replace('~', '', $spaces_removed);
            $spaces_removed = str_replace('`', '', $spaces_removed);
            $spaces_removed = str_replace('@', '', $spaces_removed);
            $spaces_removed = str_replace('#', '', $spaces_removed);
            $spaces_removed = str_replace('$', '', $spaces_removed);
            $spaces_removed = str_replace('+', '', $spaces_removed);
            $spaces_removed = preg_replace('/[^a-zA-Z0-9]/', '', $spaces_removed);
		$spaces_removed = str_replace('0', 'o', $spaces_removed);
		$spaces_removed = str_replace('1', 'i', $spaces_removed);
		$spaces_removed = str_replace('3', 'e', $spaces_removed);
		$spaces_removed = str_replace('4', 'a', $spaces_removed);
		$spaces_removed = str_replace('5', 's', $spaces_removed);
		$spaces_removed = str_replace('dot', '', $spaces_removed);

            if (str_contains(strtolower($transliterated), 'nofile.org'))
                return true;
            if (str_contains(strtolower($transliterated), 'telegra.ph'))
                return true;

            if (str_contains(strtolower($transliterated), 'fuck collection'))
                return true;
            if (str_contains(strtolower($transliterated), 'smallurl.ca'))
                return true;
            if (str_contains(strtolower($transliterated), '*p*r*e*w*'))
                return true;
            if (str_contains(strtolower($transliterated), 'goto.now'))
                return true;

            if (str_contains(strtolower($transliterated), "'ecker"))
                return true;

            //Remove all alphanumerics
            $spaces_removed = preg_replace('/[^A-Za-z0-9]/', '', $spaces_removed);

            if (str_contains(strtolower($spaces_removed), 'pomftv'))
                return true;

            if (str_contains(strtolower($spaces_removed), 'meta4chan'))
                return true;

            if (str_contains(strtolower($spaces_removed), 'owovg'))
                return true;

            if (str_contains(strtolower($spaces_removed), 'awoocf'))
                return true;

            if (str_contains(strtolower($spaces_removed), 'jassy'))
                return true;

            if (str_contains(strtolower($spaces_removed), 'jaksoyparty'))
                return true;

            if (str_contains(strtolower($spaces_removed), 'partyjakst'))
                return true;

            if (str_contains(strtolower($spaces_removed), 'fridaynightfunkinparty'))
                return true;

            if (str_contains(strtolower($spaces_removed), 'cunnysoy'))
                return true;
	/*
            if (str_contains(strtolower($spaces_removed), 'sextort'))
                return true;
	*/

            if (str_contains(strtolower($spaces_removed), 'suicideitcom'))
                return true;

            if (str_contains(strtolower($spaces_removed), 'kiwifarmsfun'))
                return true;

            if (str_contains(strtolower($spaces_removed), 'gofileio'))
                return true;

//            if (str_contains(strtolower($spaces_removed), 'kiwi st'))
//                return true;

            if (str_contains(strtolower($spaces_removed), '4fuckorg'))
                return true;

            if (preg_match('/goon\d*bot/i', $spaces_removed))
                return true;

            if (str_contains(strtolower($spaces_removed), 'ilovecp'))
                return true;

            if (str_contains(strtolower($spaces_removed), 'candyhub'))
                return true;

            if (str_contains(strtolower($spaces_removed), 'heemyspace'))
                return true;

            return false;
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '1. You will not post, link to, or request illegal content.'
);

//Subject
$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {

            $transliterated = AnyAscii::transliterate($post['subject']);
            if (preg_match('/gor23xya/i', $transliterated))
                return true;
            if (preg_match('/grove5kk6/i', $transliterated))
                return true;
            if (preg_match('/gor78arx/i', $transliterated))
                return true;
            if (preg_match('/ezsigedup32/i', $transliterated))
                return true;
            if (preg_match('/ezsignedip32232/i', $transliterated))
                return true;
            if (preg_match('/__rapecel/i', $transliterated))
                return true;
            if (preg_match('/_rapecel/i', $transliterated))
                return true;
            if (preg_match('/hacktheman123/i', $transliterated))
                return true;
            if (preg_match('/hacktheman/i', $transliterated))
                return true;
            if (preg_match('/discorrd.gg/i', $transliterated))
                return true;
            if (preg_match('/6qk5MADa/i', $transliterated))
                return true;
            if (preg_match('/tyny.to/i', $transliterated))
                return true;
            if (str_contains(strtolower($transliterated), 'gg\kiwifarms'))
                return true;
            if (str_contains(strtolower($transliterated), 'dercord,'))
                return true;
            if (str_contains(strtolower($transliterated), 'dercord,'))
                return true;
            if (str_contains(strtolower($transliterated), 'decord,gg'))
                return true;
            $spaces_removed = str_replace(' ', '', $transliterated);
            if (str_contains(strtolower($spaces_removed), 'gg/kiwifarms'))
                return true;
            if (str_contains(strtolower($transliterated), '|kiwifarms'))
                return true;
            if (str_contains(strtolower($transliterated), 'nofile.org'))
                return true;
            if (str_contains(strtolower($transliterated), 'telegra.ph'))
                return true;
            //
        
            if (str_contains(strtolower($transliterated), 'invite/i=10'))
                return true;

            if (str_contains(strtolower($transliterated), 'ovz6yw'))
                return true;

            if (str_contains(strtolower($spaces_removed), 'wormholeapp'))
                return true;

            return false;
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '1. You will not post, link to, or request illegal content.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            if (
                array_key_exists('filehash', $post) && in_array(
                    $post['filehash'],
                    array(
                        'd443450f458ca8c98eff9eb0c1480a33',
                        '06f54f2e0b91061804616df7ba0dfd55', // Cat gore
                        '71c6bc10ba3bf081ef0ef126e873c18f', //Shoveldog
                        'e03e767a0e69d23e52fe1fc17534f8701bc109917c94b7e4896a601f268797e8',
                        '437ae919001b526d7acadaa769e5314d',
                        'fbb59af8905282183f20eb02c99b68b5', //Turtle
                        '695ae623b95ad0ecab3bb54a92ac4233a5628a8c54f5aab5d485caf5cab5354a',
                        'be31c068e142d19425065670d04f5503', // CSAM
                        'c81fc66651c93bba39e461c6704fe486c9c2b85326ce838ec38ec78eaf193b39', // discord spam
                        'c19d841a611f793abd892962d0d40229',
                        '0d1efe0ff1cfa9439e21421c21f646a109f9ea5e50291de6f417f49ece6121f1', // Traced csam
                        'b86fe3cd87b42f689d89462bacc7e51b44388df15a4e3b98d363298e54931568', // Discord spam
			'dcdeec99f4d9d00fb7d96c0dec09c499602d602913e5120c37f8143e137617fe'
                    )
                )
            )
                return true;
            else
                return false;
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Evading bans may result in longer or permanent ones on both IPs. Instead, appeal it.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            if (preg_match('/sandaryan/i', $post['name'])) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            $transliterated = strtolower(AnyAscii::transliterate($post['body']));
            $transliterated = str_replace('@', 'a', $transliterated);
            $transliterated = str_replace('$', 's', $transliterated);
            $spaces_removed = preg_replace('/[^a-z0-9]/', '', $transliterated);
            $spaces_removed = str_replace('0', 'o', $spaces_removed);
            $spaces_removed = str_replace('1', 'i', $spaces_removed);
            $spaces_removed = str_replace('3', 'e', $spaces_removed);
            $spaces_removed = str_replace('4', 'a', $spaces_removed);
            $spaces_removed = str_replace('5', 's', $spaces_removed);
            $spaces_removed = str_replace('dot', '', $spaces_removed);

            if (preg_match('/georgegameseducate.com/i', $transliterated)) {
                return true;
            }
            if (preg_match('/georgegameseducate.com/i', $post['subject'])) {
                return true;
            }
            if (preg_match('/jaksoyparty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/catchantop/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/partyjak\.soy/i', $transliterated)) {
                return true;
            }
            if (preg_match('/jartycuck\.moe/i', $transliterated)) {
                return true;
            }
            if (preg_match('/https:\/\/www\.youtube\.com\/watch\?v=-547JxBInyE/i', $transliterated)) {
                return true;
            }
            if (preg_match('/3whj3P5qkV/i', $transliterated)) {
                return true;
            }
            if (preg_match('/allindiachat/i', $transliterated)) {
                return true;
            }
            if (preg_match('/r8FdvCZA/i', $transliterated)) {
                return true;
            }
            if (preg_match('/pastebin\.pl/i', $transliterated)) {
                return true;
            }
            if (preg_match('/QhABbwm6FJ/i', $transliterated)) {
                return true;
            }
            if (preg_match('/nPHE7M5M/i', $transliterated)) {
                return true;
            }
            if (preg_match('/thatsnutsonline/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/swedishwincom/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/88nusoicaca88/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/skibidifarms/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/soyjakkersnet/i', $spaces_removed)) {
		return true;
	    }
            if (preg_match('/kuzzywin/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/basedjakcom/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/soyjakkingsoy/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/fellasfarm/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/rochanchannel/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/D2YDNm4f2Q/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/xttZZmQ/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/vwqvZa6v/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/glowjakparty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/zelligpartysoy/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/doordashknocks/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/Wnc1BSRZ/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/dDTeTXRN/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/ownsthisshittysite/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/86174190162/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/86174110122/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/deadniggershop/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/tiaraabanquets/i', $spaces_removed)) {
                return true;
            }
            if ($post['password'] == '59ENoMnT') {
		return true;
            }
            if ($post['password'] == ']b)vJAl52d#q') {
                return true;
            }
            if ($post['browser_hash'] == '675ab1f3b73b36bd8fae011f6ae0ea98') {
                return true;
            }
            else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '3. Participation in hostile or disruptive off-site communities or servers is forbidden.'
);


$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            $transliterated = strtolower(AnyAscii::transliterate($post['body']));
            $transliterated = str_replace('@', 'a', $transliterated);
            $transliterated = str_replace('$', 's', $transliterated);
            $transliterated = str_replace('(', 'c', $transliterated);
            $spaces_removed = preg_replace('/[^a-zA-Z0-9]/', '', $transliterated);
            $spaces_removed = str_replace('0', 'o', $spaces_removed);
            $spaces_removed = str_replace('1', 'i', $spaces_removed);
            $spaces_removed = str_replace('3', 'e', $spaces_removed);
            $spaces_removed = str_replace('4', 'a', $spaces_removed);
            $spaces_removed = str_replace('5', 's', $spaces_removed);
            $spaces_removed = str_replace('dot', '', $spaces_removed);

            if (preg_match('/anthrofoo/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/anthrodotfoo/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/gemjakparty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/8PK2Aa6Wmr/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/drunkstreamsfun/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/heemstreams/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/vodkastreams/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/streamsfun/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/shrimpstreams/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/shrimpcast/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/theworkpccom/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/SRGqF5Y5/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/vwE9wYTXzh/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/webredirectorg/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/mywireorg/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/wwestreampagesdev/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/gunslol/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/librechan/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/gigachadsfit/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/joyjakst/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/67chanst/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/gigachade/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/gempartysoy/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/intcultureparty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/joyjackparty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/soyjakclub/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/czchan/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/nojanniesallowedonline/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/trinititeparty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/gigachadparty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/gigachadst/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/ruzlycomtr/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/ctws/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/shemmylol/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/geckoxyz/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/gordyrfgd/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/gigaboorucom/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/gigachadsflt/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/glgachadsfit/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/niggaparty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/gigabooru/i', $spaces_removed)) {
                return true;
            }
	    if(preg_match('/gigachadsf1t/i',$spaces_removed)) {
		return true;
	    }
            if (preg_match('/glgachadsflt/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/soyjaktycoon/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/chudwin/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/chudjakparty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/chvdwin/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/8chanclub/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/8chanmoe/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/8kuntop/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/reinchanorg/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/kptfukbyzg/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/kernung/i', $spaces_removed)) {
                return true;
            }
	    if (preg_match('/gempartyst/i', $spaces_removed)) {
		return true;
	    }
            else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '3. Advertising for imageboards, discord servers, telegram channels, crypto projects, etc. is not permitted.'
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            if (str_contains($post['body'], 'â£¿')) {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'reject',
    'message' => 'Spam detected. Post discarded.'
);


$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            $transliterated = strtolower(AnyAscii::transliterate($post['body']));
            $transliterated = str_replace('@', 'a', $transliterated);
            $transliterated = str_replace('$', 's', $transliterated);
            $spaces_removed = preg_replace('/[^a-zA-Z0-9]/', '', $transliterated);
            $spaces_removed = str_replace('0', 'o', $spaces_removed);
            $spaces_removed = str_replace('1', 'i', $spaces_removed);
            $spaces_removed = str_replace('3', 'e', $spaces_removed);
            $spaces_removed = str_replace('4', 'a', $spaces_removed);
            $spaces_removed = str_replace('5', 's', $spaces_removed);
            $spaces_removed = str_replace('dot', '', $spaces_removed);

            if (preg_match('/foodist/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/jassy/i', $spaces_removed)) {
                return true;
            }
            else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Filter evasion.',
    'expires' => 60 * 5
);


$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            $transliterated = strtolower(AnyAscii::transliterate($post['body']));
            $transliterated = str_replace('@', 'a', $transliterated);
            $transliterated = str_replace('$', 's', $transliterated);
            $spaces_removed = preg_replace('/[^a-zA-Z0-9]/', '', $transliterated);
            $spaces_removed = str_replace('0', 'o', $spaces_removed);
            $spaces_removed = str_replace('1', 'i', $spaces_removed);
            $spaces_removed = str_replace('3', 'e', $spaces_removed);
            $spaces_removed = str_replace('4', 'a', $spaces_removed);
            $spaces_removed = str_replace('5', 's', $spaces_removed);
            $spaces_removed = str_replace('dot', '', $spaces_removed);

            if (preg_match('/foodist/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/jassy/i', $spaces_removed)) {
                return true;
            }
            else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Filter evasion.',
    'expires' => 60 * 5
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            if (str_contains($post['body_nomarkup'], "[thumb]")) {
		return true;
	    }

            $transliterated = strtolower(AnyAscii::transliterate($post['body']));
            $transliterated = str_replace('@', 'a', $transliterated);
            $transliterated = str_replace('$', 's', $transliterated);
            $spaces_removed = preg_replace('/[^a-zA-Z0-9]/', '', $transliterated);
            $spaces_removed = str_replace('0', 'o', $spaces_removed);
            $spaces_removed = str_replace('1', 'i', $spaces_removed);
            $spaces_removed = str_replace('3', 'e', $spaces_removed);
            $spaces_removed = str_replace('4', 'a', $spaces_removed);
            $spaces_removed = str_replace('5', 's', $spaces_removed);
            $spaces_removed = str_replace('dot', '', $spaces_removed);

            if (preg_match('/catboxmoe/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/pomf2lainla/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/gyotc/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/uguuse/i', $spaces_removed)) {
                return true;
            }
            else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'External filehosts are forbidden.',
    'expires' => 60 * 15
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            $transliterated = strtolower(AnyAscii::transliterate($post['body']));
            $transliterated = str_replace('@', 'a', $transliterated);
            $transliterated = str_replace('$', 's', $transliterated);
            $spaces_removed = preg_replace('/[^a-zA-Z0-9]/', '', $transliterated);
            $spaces_removed = str_replace('0', 'o', $spaces_removed);
            $spaces_removed = str_replace('1', 'i', $spaces_removed);
            $spaces_removed = str_replace('3', 'e', $spaces_removed);
            //$spaces_removed = str_replace('4', 'a', $spaces_removed);
            $spaces_removed = str_replace('5', 's', $spaces_removed);
            $spaces_removed = str_replace('dot', '', $spaces_removed);

            if (preg_match('/charty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/4rty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/4arty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/4chanparty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/4cuckorg/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/nusoiparty/i', $spaces_removed)) {
                return true;
            }
            if (preg_match('/netsuba/i', $spaces_removed)) {
                return true;
            }
            else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => '3. Advertising for imageboards, discord servers, telegram channels, crypto projects, etc. is not permitted.',
    'expires' => 60 * 60 * 12
);

$config['filters'][] = array(
    'condition' => array(
        'custom' => function ($post) {
            if ($post['trip'] == "!uFrn/9DZFY") {
                return true;
            } else {
                return false;
            }
        }
    ),
    'action' => 'ban',
    'add_note' => true,
    'all_boards' => true,
    'reason' => 'Ban evasion.'
);
