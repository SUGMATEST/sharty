/*
 * expand-all-images.js
 * https://github.com/savetheinternet/Tinyboard/blob/master/js/expand-all-images.js
 *
 * Adds an "Expand all images" button to the top of the page.
 *
 * Released under the MIT license
 * Copyright (c) 2012-2013 Michael Save <savetheinternet@tinyboard.org>
 * Copyright (c) 2013-2014 Marcin Łabanowski <marcin@6irc.net>
 * Copyright (c) 2014 sinuca <#55ch@rizon.net>
 *
 * Usage:
 *   $config['additional_javascript'][] = 'js/jquery.min.js';
 *   $config['additional_javascript'][] = 'js/inline-expanding.js';
 *   $config['additional_javascript'][] = 'js/expand-all-images.js';
 *
 */

if (active_page == 'ukko' || active_page == 'thread' || active_page == 'index')
onready(function(){
	$('#thread-links').append('<a id="expand-all-images" href="javascript:void(0)"></a>');
	$('#expand-all-images')
		.text(_('[Expand all images]'))
		.on('click', function() {
			$('a img.post-image').each(function() {
				// Don't expand YouTube embeds
				if ($(this).parent().parent().hasClass('video-container'))
					return;

				// or WEBM
				if (/^\/player\.php\?/.test($(this).parent().attr('href')))
					return;

				if (!$(this).parent().data('expanded'))
					$(this).parent().trigger('click');
			});

			if (!$('#shrink-all-images').length) {
				$('#thread-links').append('<a id="shrink-all-images" href="javascript:void(0)"></a>');
			}

			$('#shrink-all-images')
				.text(_('[Shrink all images]'))
				.on('click', function(){
					$('a img.full-image').each(function() {
						if ($(this).parent().data('expanded'))
							$(this).parent().trigger('click');
					});
					$(this).remove();
				});
		});
});
