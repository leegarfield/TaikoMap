var sw_version = 'a_0.4.8';


if ('serviceWorker' in navigator) {
  window.addEventListener('load', function () {
    navigator.serviceWorker.register('/sw.js?v='+sw_version, {scope: '/'})
      .then(function (registration) {

        // 注册成功
        console.log('ServiceWorker registration successful with scope: ', registration.scope);
      })
      .catch(function (err) {

        // 注册失败:(
        console.log('ServiceWorker registration failed: ', err);
      });
  });
  
  
  // message事件处理
  navigator.serviceWorker.addEventListener('message', function (e) {
    
    var post = JSON.parse(e.data);
    
    //sw_update - 更新完毕重载页面
    if (post.action == 'sw_update') {
      location.reload();
    }
    
    
  });
  
  
}else {
  console.log('sw unsupported');
}

//Chrome PC版本的PWA安装引导
window.addEventListener('beforeinstallprompt', (evt) => {
  promptEvent = evt;
  evt.preventDefault();
  var PWA_btn = document.getElementById('PWA_btn');
  if (PWA_btn){
    //支持的话就显示安装按钮
    PWA_btn.style.display = 'block';
  }
  
});