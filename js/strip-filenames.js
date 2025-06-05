$(function () {
  if (window.Options) {
    Options.extend_tab('general', '<label id="strip-filenames"><input type="checkbox">' + _('Strip filenames') + '</label>');

    $('#strip-filenames>input').on('change', function() {
      if (localStorage.strip_filenames !== 'true') {
        localStorage.strip_filenames = 'true';
      } else {
        localStorage.strip_filenames = 'false';
      }
    });

    if (localStorage.strip_filenames === 'true') {
      $('#strip-filenames>input').attr('checked','checked');
    }
  }
});
