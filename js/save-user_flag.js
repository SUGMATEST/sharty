function user_flag() {
	var flagStorage = "flag_" + document.getElementsByName('board')[0].value;
	var item = window.localStorage.getItem(flagStorage);
	$('select[name=user_flag]').val(item);
	$('select[name=user_flag]').on('change', function() {
		window.localStorage.setItem(flagStorage, $(this).val());
	});
	$(window).on('quick-reply', function() {
		$('form#quick-reply select[name="user_flag"]').val($('select[name="user_flag"]').val());
	});
}
if (active_page == 'thread' || active_page == 'index') {
	$(user_flag);
}
