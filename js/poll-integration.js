window.poll_integration = (function () {
	"use strict";

	var poll_integration = {};

	function createOption(removable) {
    var textbox = document.createElement('input');
    textbox.setAttribute('type', 'text');
    textbox.setAttribute('name', 'poll-choices[]');
    textbox.setAttribute('required', true);
    textbox.setAttribute('maxlength', 25);
    textbox.setAttribute('placeholder', "Poll choice");
    textbox.setAttribute('style', 'display: inline-block');

    if (removable) {
      var removeButton = $('<a href="javascript:void(0)">X</a>').css('font-size', '12pt').css('text-decoration', 'none');

      removeButton.on('click', function() {
        $(this).parent().remove();
      });
    }
    else {
      var removeButton = null;
    }

    return $('<div>').append(textbox, removeButton, $('<br>'));
  }

  function createFlag(text, name) {
    var flag = document.createElement('input');
    flag.setAttribute('type', 'checkbox');
    flag.setAttribute('name', name);
    flag.setAttribute('id', name);

    var label = document.createElement('label');
    label.setAttribute('for', name);
    label.innerHTML = text;

    var container = document.createElement('div');
    container.setAttribute('class', 'center');
    container.append(label, flag, document.createElement('br'));

    return container;
  }

	function clearWidget() {
    $('#upload_poll td').empty();
		$('#upload_poll').hide();
	}

	poll_integration.show = function () {
		var container = $("<div>", { id: "poll_integration" });

		var multipleChoice = createFlag("Multiple choice", 'poll-multiple-choice');
    var hideResults = createFlag("Hide results", 'poll-hide-results');
    var expiryReveal = createFlag("Reveal results on expiration", 'poll-reveal-on-expiration');

    var flagContainer = $('<div>').append(multipleChoice, hideResults, expiryReveal).css('height', '48px');

    var expiryInput = document.createElement('input');
    expiryInput.setAttribute('type', 'text');
    expiryInput.setAttribute('name', 'poll-expires');
    expiryInput.setAttribute('maxlength', 10);
    expiryInput.setAttribute('placeholder', "Expires in? (Optional)");
    expiryInput.setAttribute('style', 'display: inline-block');

    var expiryHelp = $('<span class="unimportant"> (eg. "1h30m" or "2 hours")</span>');

    var expiryContainer = $('<div>').append(expiryInput, expiryHelp, $('<br>'));

    var addOptionButton = $('<a href="javascript:void(0)">Add another choice</a>').css('text-decoration', 'none');

    addOptionButton.on('click', function() {
      $(this).before(createOption(true));
    });

    container.append(flagContainer, expiryContainer, $('<br>'), createOption(false), createOption(false), addOptionButton);

    $(document).on('ajax_after_post', function () {
      clearWidget();
    });

		$('#upload_poll td').append(container);
		$('#upload_poll').show();
	};

	return poll_integration;
})();
