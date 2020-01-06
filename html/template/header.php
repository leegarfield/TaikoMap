<?php 
$timestamp = 2020010602;

if (isset($acc['NUM']) && $acc['NUM'] = 1){
  $noStatic = true;
}

?>
<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="description" content="太鼓地图，一个用于记录【太鼓の達人】的街机框体位置与框体情况的网站" />
    <meta name="author" content="leegarfield">
    <meta name="Keywords" content="太鼓达人 太鼓の達人 TaikoMap 太鼓地图 太鼓达人鼓点 音游" />
    <meta name="renderer" content="webkit">
    <meta name="theme-color" content="#ff5385">
    <meta name="msvalidate.01" content="AC08032F35B2D5E256701083C8D5C24C" />
    <link href="/static/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="/static/bootstrap/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="/static/css/taikoweb.css?v=<?=$timestamp?>" rel="stylesheet">
    <link rel="apple-touch-icon-precomposed" href="/static/image/icons/logo@128.png"/>
    <link rel="manifest" href="/manifest.json">
    <script src="/static/bootstrap/jquery.min.js"></script>
    <script src="/static/bootstrap/bootstrap.min.js"></script>
    <script src="/static/bootstrap/ie10-viewport-bug-workaround.js"></script>
    <script src="/static/js/taikoweb_main.js?v=<?=$timestamp?>"></script>
    <script src="/static/js/sw_register.js?v=<?=$timestamp?>"></script>
    
<?php
if(!isset($noStatic)){

?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-102825553-3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-102825553-3');
    </script>

<?php
}
?>

    <link rel="shortcut icon" href="/static/image/favicon/favicon.ico" />
    <link rel="apple-touch-icon-precomposed" href="/static/icon/main.png"/>
    <title><?=$title?></title>
  </head>