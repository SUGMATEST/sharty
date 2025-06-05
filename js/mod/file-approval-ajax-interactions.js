$(function(){
	$('.file-actions a').on('click', async(e) => {
		e.preventDefault();
		const promise = fetch(e.currentTarget.href);
		$(e.currentTarget).parents('.file-approval-item').remove();
		await promise;
	});
});
