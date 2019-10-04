var cashBin_version = '201900531_01';

// 监听 service worker 的 install 事件
this.addEventListener('install', function (event) {
  // 如果监听到了 service worker 已经安装成功的话，就会调用 event.waitUntil 回调函数
  // 安装成功后操作 CacheStorage 缓存，使用之前需要先通过 caches.open() 打开对应缓存空间。
  caches.open(cashBin_version).then(function (cache) {
    // 通过 cache 缓存对象的 addAll 方法添加 precache 缓存
    return cache.addAll([
      '/static/image/drum.png?v=2',
      '/static/image/screen.png?v=4',
      '/static/image/bg/full.jpg',
      '/static/image/bg/para.jpg',
      '/static/image/favicon/favicon.ico',
      '/static/image/map/marker50x.png',
      '/static/image/icons/logo@128.png',
      
      '/static/bootstrap/bootstrap.min.css',
      '/static/bootstrap/bootstrap.min.js',
      '/static/bootstrap/ie10-viewport-bug-workaround.css',
      '/static/bootstrap/ie10-viewport-bug-workaround.js',
      '/static/bootstrap/jquery.min.js',
      
      '/manifest.json',
      
      '/static/fonts/glyphicons-halflings-regular.eot',
      '/static/fonts/glyphicons-halflings-regular.ttf',
      '/static/fonts/glyphicons-halflings-regular.woff',
      '/static/fonts/glyphicons-halflings-regular.woff2'
    ]).then(function(){
      return self.clients.matchAll().then(function (clients) {
        if (clients && clients.length) {
          clients.forEach(function (client) {
            // 发送更新成功信息
            client.postMessage('{"action":"sw_update"}');
          })
        }
      })
    });
  });
  self.skipWaiting();
});

this.addEventListener('fetch', function (event) {
  event.respondWith(caches.match(event.request).then(function (response) {
    // 来来来，代理可以搞一些代理的事情
    

    // 如果 Service Worker 有自己的返回，就直接返回，减少一次 http 请求
    if (response) {
      // console.log(response.url);
      return response;
    }

    // 如果 service worker 没有返回，那就得直接请求真实远程服务
    var request = event.request.clone();
    return fetch(request).then(function (httpRes) {

      // http请求的返回已被抓到，可以处置了。

      // 请求失败了，直接返回失败的结果就好了。。
      if (!httpRes || httpRes.status !== 200) {
        return httpRes;
      }

      // 请求成功的话，将请求缓存起来。
      // var responseClone = httpRes.clone();
      // caches.open('my-test-cache-v1').then(function (cache) {
        // cache.put(event.request, responseClone);
      // });
      return httpRes;
    });
  }));
});

self.addEventListener('activate', function (event) {
  
  event.waitUntil(
    Promise.all([
    
      self.clients.claim(),

      caches.keys().then(function (cacheList) {
        return Promise.all(
          cacheList.map(function (cacheName) {
            // 清理旧版本
            if (cacheName !== cashBin_version) {
              return caches.delete(cacheName);
            }
          })
        );
      })
    ])
  );
});
