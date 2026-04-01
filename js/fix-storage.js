(async() => {
	const estimate = await navigator.storage.estimate();
	if (estimate.usage > estimate.quota) {
		localStorage.clear();
		sessionStorage.clear();
	}
})();
