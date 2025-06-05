function add_async_listeners() {
	$('.file-actions a').on('click', async(e) => {
		e.preventDefault();
		const promise = fetch(e.currentTarget.href);
		$(e.currentTarget).parents('.file-approval-item').remove();
		await promise;
	});
}

$(function(){
	add_async_listeners();

	var countdown_interval;

	// Add an update link
	//$('.file-approval-container').prev().after("<span id='updater'><a href='#' id='update_thread' style='padding-left:10px'>["+_("Update")+"]</a> (<input type='checkbox' id='auto_update_status' checked> "+_("Auto")+") <span id='update_secs'></span></span>");

	// Grab the settings
	var settings = new script_settings('file-approval-auto-reload');
	var poll_interval_mindelay        = settings.get('min_delay_bottom', 15000);
	var poll_interval_maxdelay        = settings.get('max_delay', 15000);
	var poll_interval_errordelay      = settings.get('error_delay', 30000);

	// number of ms to wait before reloading
	var poll_interval_delay = poll_interval_mindelay;
	var poll_current_time = poll_interval_delay;

	$('#auto_update_status').on('click', function() {
		if($("#auto_update_status").is(':checked')) {
			auto_update(poll_interval_mindelay);
		} else {
			stop_auto_update();
			$('#update_secs').text("");
		}

	});

	var decrement_timer = function() {
		poll_current_time = poll_current_time - 1000;
		$('#update_secs').text(poll_current_time/1000);

		if (poll_current_time <= 0) {
			poll(manualUpdate = false);
		}
	}

	// automatically updates the thread after a specified delay
	var auto_update = function(delay) {
		clearInterval(countdown_interval);

		poll_current_time = delay;
		countdown_interval = setInterval(decrement_timer, 1000);
		$('#update_secs').text(poll_current_time/1000);
	}

	var stop_auto_update = function() {
		clearInterval(countdown_interval);
	}

	var poll = function(manualUpdate) {
		stop_auto_update();
		$('#update_secs').text(_("Updating..."));

		$.ajax({
			url: document.location,
			dataType: "html",
			success: function(data) {
				var files = $(data).find('.file-approval-item');
				$('.file-approval-container').html(files);
				add_async_listeners();

				var prefix = "";
				if (files.length > 0) {
					prefix = `(${files.length}) `;
				}
				document.title = prefix + "File approval";

				if ($('#auto_update_status').is(':checked')) {
					poll_interval_delay = poll_interval_mindelay;
					auto_update(poll_interval_delay);
				} else {
					$('#update_secs').text(_(""));
				}
			},
			error: function(xhr, status_text, error_text) {
				$('#update_secs').text(_("Unknown error"));

				// Keep trying to update
				if ($('#auto_update_status').is(':checked')) {
					poll_interval_delay = poll_interval_errordelay;
					auto_update(poll_interval_delay);
				}
			}
		});

		return false;
	};

	$('#update_thread').on('click', function() { poll(manualUpdate = true); return false; });

	if($("#auto_update_status").is(':checked')) {
		auto_update(poll_interval_delay);
	}
});
