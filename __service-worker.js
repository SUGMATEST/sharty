var CACHE_NAME = 'site-cache-v1';
var urlsToCache = [
  '/',
  '/offline.html',
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', event => {
	if (event.request.url.endsWith(".html") || event.request.url.endsWith("/")) {
	  event.respondWith(
	    fetch(event.request)
	      .then(response => {
	        if (response.status >= 501 && response.status <= 599) {
	          return caches.match('/offline.html').then(cachedResponse => {
	            if (cachedResponse) {
	              return cachedResponse;
	            }
	            return response;
	          });
	        }
	        return response;
	      })
	      .catch(error => {
	        return caches.match(event.request).then(cachedResponse => {
	          if (cachedResponse) {
	            return cachedResponse;
	          }
	          return caches.match('/offline.html').then(offlineResponse => {
	            return offlineResponse;
	          });
	        });
	      })
	  );
	}
});

self.addEventListener('activate', event => {
  var cacheWhitelist = ['site-cache-v1'];

  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheWhitelist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

self.addEventListener('message', (event) => {
  if (event.data.action === 'skipWaiting') {
    self.skipWaiting();
  }
});


