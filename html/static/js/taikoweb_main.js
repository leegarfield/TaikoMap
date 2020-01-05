// main js

$(document).ready(function(){
  
  var PWA_btn_t = document.getElementById('PWA_btn_t');
  if (PWA_btn_t){
    PWA_btn_t.addEventListener('click', function(){
      promptEvent.prompt();
    });
  }
  
  
  $(document).click(function(){
    $('.taiko-pwa-side')[0].style.minWidth = '0px';
    $('span.index-side-streched').addClass('index-side-big');
    $('span.index-side-big').removeClass('index-side-streched');
    $('.slide-up-on-click').slideUp(0);
    $('.arrow-rotate-on-click').attr('style', 'transform: rotate(0deg);transition: transform 0.2s linear 0s;');
    $('.nav-unhided').addClass('nav-hided');
    $('.nav-hided').removeClass('nav-unhided');
  });
  $('.taiko-pwa-side').click(function(){
    $('.taiko-pwa-side')[0].style.minWidth = '193px';
    setTimeout(function(){
      $('span.index-side-big').addClass('index-side-streched');
      $('span.index-side-streched').removeClass('index-side-big');
      $('.nav-hided').addClass('nav-unhided');
      $('.nav-unhided').removeClass('nav-hided');
    }, 200);
    event.stopPropagation();
  });
  $('#nav-btn').click(function(){
    $('.taiko-pwa-side')[0].style.minWidth = '193px';
    var hided = $('.nav-hided');
    var unhided = $('.nav-unhided');
    if(hided.text()){
      hided.addClass('nav-unhided');
      hided.removeClass('nav-hided');
      hided[0].style.minWidth = '193px';
      setTimeout(function(){
        $('span.index-side-big').addClass('index-side-streched');
        $('span.index-side-streched').removeClass('index-side-big');
      }, 200);
    }
    if(unhided.text()){
      unhided.addClass('nav-hided');
      unhided.removeClass('nav-unhided');
      unhided[0].style.minWidth = '0px';
      $('span.index-side-streched').addClass('index-side-big');
      $('span.index-side-big').removeClass('index-side-streched');
      $('.slide-up-on-click').slideUp(0);
      $('.arrow-rotate-on-click').attr('style', 'transform: rotate(0deg);transition: transform 0.2s linear 0s;');
    }
    event.stopPropagation();
  });
  
  $("#modal_login").click(function() {
      $('#modalLogin').modal();
  });
  $("#modal_signup").click(function() {
      $('#modalSignup').modal();
  });
  
  $(".js-spread").click(function() {
  // 点击后展开自身消失其他兄弟元素展开
      var other = $(this).siblings();
      $(other).slideDown("slow");
      $(this).fadeOut("fast");
  });

  // 点击后展开自身收回其他兄弟元素展开
  $(".js-slide").click(function() {
      var other = $(this).siblings();
      $(other).slideDown("fast");
      $(this).slideUp("fast");
  });

  // 点击后父元素消失
  $(".js-closebutton").click(function() {
      var par = $(this).parent();
      $(par).fadeOut("fast");
  });

  //点击后父元素上移消失
  $(".js-fadeupbutton").click(function() {
      var par = $(this).parent();
      $(par).slideUp("fast");
  });
  // 点击后打开/关闭其他兄弟元素
  $(".js-spoil").click(function() {
      var next = $(this).nextAll();
      $(next).slideToggle("fast");
      var rotate = $(this).children('.js-spoil-rotate-45');
      if ($(rotate).attr('style')=='transform: rotate(45deg);transition: transform 0.2s linear 0s;'){
          $(rotate).attr('style', 'transform: rotate(0deg);transition: transform 0.2s linear 0s;');
      }else{
          $(rotate).attr('style', 'transform: rotate(45deg);transition: transform 0.2s linear 0s;');
      }
      var rotate = $(this).children('.js-spoil-rotate-90');
      if ($(rotate).attr('style')=='transform: rotate(90deg);transition: transform 0.2s linear 0s;'){
          $(rotate).attr('style', 'transform: rotate(0deg);transition: transform 0.2s linear 0s;');
      }else{
          $(rotate).attr('style', 'transform: rotate(90deg);transition: transform 0.2s linear 0s;');
      }
      var rotate = $(this).children('.js-spoil-rotate-180');
      if ($(rotate).attr('style')=='transform: rotate(180deg);transition: transform 0.2s linear 0s;'){
          $(rotate).attr('style', 'transform: rotate(0deg);transition: transform 0.2s linear 0s;');
      }else{
          $(rotate).attr('style', 'transform: rotate(180deg);transition: transform 0.2s linear 0s;');
      }
  });
  
});

//提交异步请求
// postForm: {A:'a', B:'b'}
// url: '/php/action.php'
// callbackFunc: A function
function unSyncPost(postForm, url, callbackFunc){
  $.post(url, postForm, function(data){
    callbackFunc(data);
  });
}