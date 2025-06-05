/*
 * quick-posts-controls.js
 * https://github.com/savetheinternet/Tinyboard/blob/master/js/quick-posts-controls.js
 *
 * Released under the MIT license
 * Copyright (c) 2012 Michael Save <savetheinternet@tinyboard.org>
 * Copyright (c) 2013 undido <firekid109@hotmail.com>
 * Copyright (c) 2013-2014 Marcin Łabanowski <marcin@6irc.net>
 *
 * Usage:
 *   $config['additional_javascript'][] = 'js/jquery.min.js';
 *   $config['additional_javascript'][] = 'js/quick-post-controls.js';
 *
 */

$(function () {
	var open_form = function () {
		var thread = $(this).parent().parent().hasClass('op');
		var id = $(this).attr('name').match(/^delete_(\d+)$/)[1];
		var submitButton;

		var listOfReasons = [
			_('1. You WILL NOT post, link to, or request illegal content.'),
			_('1a. Attempting to get the site taken down via DDOS, false reports, etc. is FORBIDDEN.'),
			_('2. You WILL NOT advocate, promote, or post pedophilia or pedophilic content.'),
			_('2a. The posting of "soylita", "shoyta" and its derivatives is not permitted.'),
			_('3. You WILL NOT advertise for imageboards, discord servers, telegram channels, crypto projects, etc.'),
			_('3a. Participation in hostile or disruptive off-site communities or servers is FORBIDDEN.'),
			_('4. You WILL NOT excessively spam threads or boards via means of botting.'),
			_('4a. Sending false reports is FORBIDDEN.'),
			_('4b. Certain types of manual spam may still be punishable. See "Grey Areas"'),
			_('5. You WILL adhere to the general topic or theme of the board you are posting on. Posts that do not pertain to the topic or theme of the board WILL be moved or removed.'),
			_('6. You WILL NOT post in an identifiable manner on the site. This includes avatarfagging and namefagging.'),
			_('7. Residential proxies or residential VPNs are forbidden.'),
			_('7. Calling Jiren weak is forbidden.'),
			_('Hurt my feelings')
		]

		if (this.checked) {
			var select = '<select id="reason_' + id + '" name="reason">' +
				listOfReasons.map(function (reason) {
					return '<option value="' + reason + '">' + reason + '</option>';
				}).join('') +
				'</select>';

			var freeform = '<input id="reason_' + id + '" type="text" name="reason" size="20" maxlength="100">';


			var needed = freeform;
			if (window.location.href.indexOf("mod.php") > -1) {
				needed = freeform;
			}
			var post_form = $('<form class="post-actions" method="post" style="margin:10px 0 0 0">' +
				'<div style="text-align:right">' +
				(!thread ? '<hr>' : '') +

				'<input type="hidden" name="delete_' + id + '">' +

				'<label for="password_' + id + '">' + _("Password") + '</label>: ' +
				'<input id="password_' + id + '" type="password" name="password" size="11" maxlength="18">' +
				'<input title="' + _('Delete file only') + '" type="checkbox" name="file" id="delete_file_' + id + '">' +
				'<label for="delete_file_' + id + '">' + _('File') + '</label>' +
				' <input type="submit" name="delete" value="' + _('Delete') + '">' +

				'<br>' +
				/*		<label for="urgent-checkbox">Urgent report</label>
		<input type="checkbox" name="urgent" value="true" id="urgent-checkbox" />*/
				'<label for="reason_' + id + '">' + _('Reason') + '</label>: ' +
				needed +

				'<label for="urgent-checkbox"> Urgent report</label>' + '<input type="checkbox" name="urgent" value="true" id="urgent-checkbox" />' +
				' <input type="submit" name="report" value="' + _('Report') + '">' +
				'</div>' +
				'</form>');


			post_form
				.attr('action', $('form[name="post"]:first').attr('action'))
				.append($('input[name=board]:first').clone())
				.find('input:not([type="checkbox"]):not([type="submit"]):not([type="hidden"])').keypress(function (e) {
					if (e.which == 13) {
						e.preventDefault();
						if ($(this).attr('name') == 'password') {
							post_form.find('input[name=delete]').trigger('click');
						} else if ($(this).attr('name') == 'reason') {
							post_form.find('input[name=report]').trigger('click');
						}

						return false;
					}

					return true;
				});

			post_form.find('input[type="password"]').val(localStorage.password);

			if (thread) {
				post_form.prependTo($(this).parent().parent().find('div.body'));
			} else {
				post_form.appendTo($(this).parent().parent());
				//post_form.insertBefore($(this));
			}

			$(window).trigger('quick-post-controls', post_form);
		} else {
			var elm = $(this).parent().parent().find('form');

			if (elm.attr('class') == 'post-actions')
				elm.remove();
		}
	};

	var init_qpc = function () {
		$(this).on('change', open_form);
		if (this.checked)
			$(this).trigger('change');
	};

	$('div.post input[type=checkbox].delete').each(init_qpc);

	$(document).on('new_post', function (e, post) {
		$(post).find('input[type=checkbox].delete').each(init_qpc);
	});
});

