const CACHE_NAME = 'mkk-school-v1';
const urlsToCache = [
  '/',
  '/school-reports/auth/login.php',
  '/school-reports/super_admin/dashboard.php',
  '/styles.css',
  '/app.js'
];

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        return cache.addAll(urlsToCache);
      })
  );
});

self.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request)
      .then(function(response) {
        if (response) {
          return response;
        }
        return fetch(event.request);
      }
    )
  );
});