<?php

if (isset($acc['token'])){
  $bannerText = '<p class="js-spoil side-nav-big href">
              <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
              <span class="index-side-big">'.$acc['nickname'].'</span>
              <span class="caret js-spoil-rotate-180 arrow-rotate-on-click"></span>
            </p>';
  $bannerText .= '
          <div class="slide-up-on-click" style="display:none;">
            <a class="href href-nounderline href-text-nomal display-block" href="php/logout.php">
              <p class="side-nav-small">
                <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                <span class="index-side-big">登出</span>
              </p>
            </a>';
  if($acc['info_is_admin']){
    $bannerText .= '
            <a class="href href-nounderline href-text-nomal display-block" href="/log.php">
              <p class="side-nav-small">
                <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                <span class="index-side-big">查看log</span>
              </p>
            </a>
            <a class="href href-nounderline href-text-nomal display-block" href="/php/admin_action.php?a=regen_html">
              <p class="side-nav-small">
                <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
                <span class="index-side-big">重生成html</span>
              </p>
            </a>';
  }
  $bannerText .= '
          </div>';
}else{
  $bannerText = '<a class="href href-nounderline href-text-nomal display-block" type="button" href="#" id="modal_login" data-target="#modalLogin">
            <p class="side-nav-big">
              <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span>
              <span class="index-side-big">登录</span>
            </p>
          </a>
          <a class="href href-nounderline href-text-nomal display-block" type="button" href="#" id="modal_signup" data-target="#modalSignup">
            <p class="side-nav-big">
              <span class="glyphicon glyphicon-check" aria-hidden="true"></span>
              <span class="index-side-big">注册</span>
            </p>
          </a>';
}

$addLink = '';
$addNav = '';

if(isset($side_city)){
  $addLink .= '
          <a class="href href-nounderline href-text-nomal display-block" href="'.$side_city_link.'">
            <p class="side-nav-big">
              <span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
              <span class="index-side-big">'.$side_city.'地图</span>
            </p>
          </a>';
}
if(isset($side_gamecenter)){
  $addLink .= '
          <a class="href href-nounderline href-text-nomal display-block" href="'.$side_gamecenter_link.'">
            <p class="side-nav-big">
              <span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span>
              <span class="index-side-big">返回游戏厅</span>
            </p>
          </a>';
}
?>

    <div class="taiko-pwa-side nav-hided" style="min-width: 0px;">
      <div class="side-nav-group">
        <div><?=$bannerText?></div>
        <div>
          <p class="js-spoil side-nav-big href">
            <span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span>
            <span class="index-side-big">其他</span>
            <span class="caret js-spoil-rotate-180 arrow-rotate-on-click"></span>
          </p>
          <div class="slide-up-on-click" style="display:none;">
              <!-- <a class="href href-nounderline href-text-nomal" href="/advice.php">
              <p class="side-nav-small">
                <span class="glyphicon glyphicon-inbox" aria-hidden="true"></span>
                <span class="index-side-big">反馈记录</span>
              </p>
            </a>
            <a class="href href-nounderline href-text-nomal" href="/changelog.php">
              <p class="side-nav-small">
                <span class="glyphicon glyphicon-bookmark" aria-hidden="true"></span>
                <span class="index-side-big">更新记录</span>
              </p>
            </a> -->
            <a class="href href-nounderline href-text-nomal" href="/helpme.php" target="_blank">
              <p class="side-nav-small">
                <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>
                <span class="index-side-big">信息填写指南</span>
              </p>
            </a>
            <a class="href href-nounderline href-text-nomal display-block" href="https://jq.qq.com/?_wv=1027&k=5drwdEb">
              <p class="side-nav-small">
                <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                <span class="index-side-big">加入意见反馈群</span>
              </p>
            </a>
          </div>
        </div>
      </div>
      <div class="side-nav-group" id="PWA_btn" style="display: none;">
        <a class="href href-nounderline href-text-nomal display-block" id="PWA_btn_t" href="#">
          <p class="side-nav-big">
            <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
            <span class="index-side-big">添加TaikoMap到桌面</span>
          </p>
        </a>
      </div>
      <div class="side-nav-group">
        <a class="href href-nounderline href-text-nomal display-block" href="/addGC.php">
          <p class="side-nav-big">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            <span class="index-side-big">添加游戏厅</span>
          </p>
        </a>
        <div>
          <p class="js-spoil side-nav-big href">
            <span class="glyphicon glyphicon-list" aria-hidden="true"></span>
            <span class="index-side-big">城市列表</span>
            <span id="city-list-arrow" class="caret js-spoil-rotate-180 arrow-rotate-on-click"></span>
          </p>
          <div class="slide-up-on-click" id="city-list" style="display:none;">
            <p class="side-nav-citylist"><?php require ('./template/html/citylist.html'); ?></p>
          </div>
        </div>
      </div>
      <div class="side-nav-group">
        <a class="href href-nounderline href-text-nomal" href="/">
          <p class="side-nav-big">
            <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
            <span class="index-side-big">网站首页</span>
          </p>
        </a>
        <?=$addLink?>
      </div>
    </div>