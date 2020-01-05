<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

$title = 'error - TaikoMap太鼓地图';

require_once('../include.php');

//log
if(isset($_COOKIE['num'])){
  $acc = logincheck();
  $user = $acc['NUM'];

}else{
  $user = $_SERVER['REMOTE_ADDR'];
}

logToDatabase($user, 'error', '', '', '', $_GET['msg']);

require_once('./header.php');
?>
  <body data-pinterest-extension-installed="cr1.39.1">
    <div class="container-fluid taiko-pwa-main">
      <div class="col-xs-12 nopadding relative">
<?php
echo createNav();
?>
      </div>
      <div class="col-xs-12">
        <br />
        <h3>出现错误：</h3>
        <h1><?=$_GET['msg']?></h1>
        <h3><a href="/">点此返回主页</a></h3>
      </div>
    </div>
    <?php require_once('../template/SideNavForPwa.php'); ?>
  </body>
