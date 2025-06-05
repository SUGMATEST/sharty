/*
 * show-op
 * https://github.com/savetheinternet/Tinyboard/blob/master/js/show-op.js
 *
 * Adds "(OP)" to >>X links when the OP is quoted.
 *
 * Released under the MIT license
 * Copyright (c) 2012 Michael Save <savetheinternet@tinyboard.org>
 * Copyright (c) 2014 Marcin Łabanowski <marcin@6irc.net>
 *
 * Usage:
 *   $config['additional_javascript'][] = 'js/jquery.min.js';
 *   $config['additional_javascript'][] = 'js/show-op.js';
 *
 */

$(function(){
	var showOPLinks = function() {
		var OP;
		
		if ($('div.banner').length == 0) {
			OP = parseInt($(this).parent().find('div.post.op a.post_no:eq(1)').text());
		} else {
			OP = parseInt($('div.post.op a.post_no:eq(1)').text());
		}
		
		var posts = $(this).find('div.body a:not([rel="nofollow"])');
		var i = 0;
		var update = function() {
			if (i < posts.length) {
				var postID;
				var post = $(posts[i]);
				if(postID = post.text().match(/^>>(\d+)$/))
					postID = postID[1];
				else
					return;
				
				if (postID == OP) {
					post.after(' <small>(OP)</small>');
				}
				
				i++;
				setTimeout(update, 0);
			}
		};
		update();
	};
	
	$('div.post.reply').each(showOPLinks);
	
	// allow to work with auto-reload.js, etc.
	$(document).on('new_post', function(e, post) {
		if ($(post).is('div.post.reply')) {
			$(post).each(showOPLinks);
		}
		else {
			$(post).find('div.post.reply').each(showOPLinks);
		}
	});
});


