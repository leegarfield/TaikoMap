<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

$title = "信息填写指南 - TaikoMap太鼓地图";

require_once ('include.php');

//login check
$acc = logincheck();
require_once('template/header.php');

?>
<body data-pinterest-extension-installed="cr1.39.1">
  <div class="container-fluid taiko-pwa-main">
    <div class="col-xs-12 nopadding relative">
      <div class="nav">
        <p class="nav-top"><a class="href-text-nomal" href="/">TaikoMap - 太鼓地图</a></p>
        <div class="nav-bottom">
          <p><a class="href-text-nomal display-inline-block" href="/"><span>主页</span></a></p>
        </div>
      </div>
      <div id="nav-btn" class="nav-btn href showUntil-M">
        <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
      </div>
    </div>
    <div class="col-xs-12">
      <h1>页面建设中。。。</h1>
    </div>
  </div>

<?php require('template/SideNavForPwa.php'); ?>

<?php require('template/loginSingupModal.php'); ?>

<?php require('template/footer.php'); ?>