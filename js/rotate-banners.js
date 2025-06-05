$(function () {
	$('.board_image').on('click', function() {
		$(this).attr('src', '/b.php?' + Math.random());
	});
});
