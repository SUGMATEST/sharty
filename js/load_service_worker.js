if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
	navigator.serviceWorker.getRegistrations().then(registrations => {
	    for (const registration of registrations) {
	        registration.unregister();
	    } 
	});

    /*
    navigator.serviceWorker.register('/__service-worker.js?v2').then(function(registration) {
      console.log('ServiceWorker registration successful with scope: ', registration.scope);
    }, function(err) {
      console.log('ServiceWorker registration failed: ', err);
    });
    */
  });
}
