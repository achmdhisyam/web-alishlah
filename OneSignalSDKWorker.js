importScripts('https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.sw.js');

// Logika PWA Caching dengan Scope Dinamis (Lokal & Hosting)
const CACHE_NAME = 'alishlah-pwa-cache-v1';

self.addEventListener('install', event => {
  const scopePath = new URL(self.registration.scope).pathname;
  const urlsToCache = [
    scopePath + 'signin',
    scopePath + 'login',
    scopePath + 'assets/template/assets/css/style.css',
    scopePath + 'assets/admin/plugins/fontawesome-free/css/all.min.css'
  ];

  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(urlsToCache))
  );
});

self.addEventListener('fetch', event => {
  // Hanya tangani GET requests untuk caching aset statis
  if (event.request.method !== 'GET') return;

  event.respondWith(
    caches.match(event.request)
      .then(response => {
        // Return cached asset, atau fetch dari jaringan
        return response || fetch(event.request).catch(() => {
          // Fallback offline (opsional)
        });
      })
  );
});
