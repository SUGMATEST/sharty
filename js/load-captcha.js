(async() => {
	const checkCaptcha = async() => { fetch("/b6.php").then((r) => {
		const captcha = document.querySelector(".mccaptcha-container")
		if (r.status == 401) {
			captcha.hidden = false
		} else {
			captcha.hidden = true
		}
	})}

	await checkCaptcha()
	$(document).on('ajax_before_post', async() => {
		await checkCaptcha()
	})
	$(document).on('ajax_after_post', async() => {
		await checkCaptcha()
	})
})()
