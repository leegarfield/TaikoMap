<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

$title = "TaikoMap太鼓地图";
$time = time();

require_once ('include.php');
require_once ('php/Character.php');
require_once ('php/template.php');

//login check
$acc = logincheck();
require_once('template/header.php');

//sql connect and fetch all
$mysqli = connect();
$sql = "select * from gamecenter";
$result = fetchAll($sql, $mysqli);
$class = getClassList();

$sql_drum = "select * from drum";
$result_drum = fetchAll($sql_drum, $mysqli);

$GCnum = array_column($result, 'NUM');

//对最近活跃的游戏厅排序
$sortData = [];
foreach ($result as $key => $val) {
  $sortData[$val['lastchangeTime']] = $val['NUM'];
}
krsort($sortData, 1);
$gamecenter_nearst = [];
$sort = reset($sortData);
for ($i=0; $i<12; $i ++) {
  $gamecenter_nearst[] = $result[array_keys($GCnum, $sort)[0]];
  $sort = next($sortData);
}
// print_r($gamecenter_nearst);

// $result[*][initials]


//获取用户列表
$sql_user = 'select NUM, nickname, rec_tick, rec_cloud_tick, rec_change from player_table';
$playerResult = fetchAll($sql_user, $mysqli);
//按出勤和云出勤次数排列
$TickPlayerList = [];
foreach($playerResult as $key => $val3){
  $TickPlayerList[$key] = $val3;
  $TickPlayerList[$key]['tickNUM'] = intval($val3['rec_tick']) + intval($val3['rec_cloud_tick']);
}
//按出勤总数排序
$tickNUMs = array_column($TickPlayerList, 'tickNUM');
array_multisort($tickNUMs, SORT_DESC, $TickPlayerList);

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
          <h2 id="top"><b>太鼓达人游戏厅一览</b></h2>

<?php require_once('template/announcement.php');?>

          <hr class="dark-hr" />
          <div class="area-box index-city-list">
            <h4 class="area-lable"><strong>城市一览</strong></h4>
            <div>
              <p class="js-spoil visible-xs">点击展开<span class="caret js-spoil-rotate-180"></span></p>
              <p class="showUntil-S hidden-sm hidden-md hidden-lg" style="display:none;"><?php require ('./template/citylist.html'); ?><span><strong>+</strong> <a href="/addGC.php">添加游戏厅</a></span> </p>
            </div>
            <p class="hidden-xs"><?php require ('./template/citylist.html'); ?><span><strong>+</strong> <a href="/addGC.php">添加游戏厅</a></span> </p>
          </div>
          <div class="area-box">
            <p class="index-ann-p">新网站更新了一些底层代码，若出现bug，请前往 <a href="https://taikomap.brs-craft.cn">taikomap.brs-craft.cn</a> 访问旧站点</p>
          </div>
<?php

?>
          <div class="area-box">
            <h4 class="area-lable"><strong>最近活跃的游戏厅</strong></h4>
            <div class="row nomargin">
<?php
  // $best_drum = array_column($result_drum, 'NUM');
  foreach ($gamecenter_nearst as $key => $val){
    
    echo createGC($val, $result_drum);

  }
?>
            </div>
          </div>
          <div class="area-box">
            <h4 class="area-lable"><strong>大佬们打了多少卡？</strong></h4>
            <div class="row nomargin">
              <p>云出勤和出勤均统计在此处</p>
<?php
  $sortKey = 0;
  $sortClass=['gold', 'sliver', 'bronze', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
  for($sortNUM=0; $sortNUM>-1; $sortNUM++){
?>

              <div class="col-xs-6 col-sm-4 col-md-3 index-player-list <?=$sortClass[$sortKey]?>">   
                <p>
                  <span><?=$TickPlayerList[$sortKey]['nickname']?></span>：<span><?=$TickPlayerList[$sortKey]['tickNUM']?></span><br />
                  <?=$TickPlayerList[$sortKey]['rec_change']?>次信息变更
                </p>
              </div>

<?php
    if ($sortNUM>10 && $TickPlayerList[$sortKey]['tickNUM'] != $TickPlayerList[$sortKey+1]['tickNUM']){
      break;
    }
    $sortKey ++;
  }
?>
            </div>
          </div>
          <div class="area-box">
            <h4 class="area-lable"><strong>其他</strong></h4>
            <div class="row nomargin">
              <div class="col-xs-6 col-md-4 map-drum-list">
                <a href="/addGC.php" class="list-border href-nounderline">
                  <div class="list vari" style="min-height: unset; text-align: center;">
                    <p><strong>添加游戏厅</strong></p>
                    <p>在这里添加的新城市会自动列出</p>
                  </div>
                </a>
              </div>
              <div class="col-xs-6 col-md-4 map-drum-list">
                <a href="https://jq.qq.com/?_wv=1027&k=5drwdEb" class="list-border href-nounderline">
                  <div class="list classic" style="min-height: unset; text-align: center;">
                    <p><strong>加入意见反馈群</strong></p>
                    <p>群号：597074514</p>
                  </div>
                </a>
              </div>
              <div class="col-xs-6 col-md-4 map-drum-list">
                <a href="/helpme.php" target="_blank" class="list-border href-nounderline">
                  <div class="list namico" style="min-height: unset; text-align: center;">
                    <p><strong>信息填写指南</strong></p>
                    <p>关于如何判断鼓况与填写信息</p>
                  </div>
                </a>
              </div>
              <div class="col-xs-12">
                <hr />
                <!-- <p>鼓况展示模板与一些鼓况解释。。。</p> -->
              </div>
              <!-- <div class="col-sm-6 col-xs-12 col-lg-4 map-drum-list">
                <div class="list-border">
                  <div class="list j-pop">
                    <div class="drumbox">
                      <div class="map-drum-left">
                        <span class="drum drumbg"></span>
                        <span class="drum x-l gold"></span>
                        <span class="drum x-r gold"></span>
                        <span class="drum o-l gold"></span>
                        <span class="drum o-r gold"></span>
                      </div>
                      <div class="map-drum-right">
                        <span class="drum drumbg"></span>
                        <span class="drum x-l gold"></span>
                        <span class="drum x-r gold"></span>
                        <span class="drum o-l gold"></span>
                        <span class="drum o-r gold"></span>
                      </div>
                      <span class="volume-l glyphicon glyphicon-volume-off" aria-hidden="true"></span>
                      <span class="volume-r glyphicon glyphicon-volume-off" aria-hidden="true"></span>
                      <div class="drum-screen nom"></div>
                    </div>
                    <p><strong>鼓况【金】</strong></p>
                    <p>金鼓况，就很强</p>
                    <p>背景为12亚模板</p>
                    <p>正常屏幕</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xs-12 col-lg-4 map-drum-list">
                <div class="list-border">
                  <div class="list anime">
                    <div class="drumbox">
                      <div class="map-drum-left">
                        <span class="drum drumbg"></span>
                        <span class="drum x-l good"></span>
                        <span class="drum x-r good"></span>
                        <span class="drum o-l good"></span>
                        <span class="drum o-r good"></span>
                      </div>
                      <div class="map-drum-right">
                        <span class="drum drumbg"></span>
                        <span class="drum x-l good-"></span>
                        <span class="drum x-r good-"></span>
                        <span class="drum o-l good-"></span>
                        <span class="drum o-r good-"></span>
                      </div>
                      <span class="volume-l glyphicon glyphicon-volume-off" aria-hidden="true"></span>
                      <span class="volume-r glyphicon glyphicon-volume-off" aria-hidden="true"></span>
                      <div class="drum-screen hor-w"></div>
                    </div>
                    <p><strong>鼓况【良】与【良-】</strong></p>
                    <p>能或部分能震下棍</p>
                    <p>【良-】则表示只有部分鼓面能满足要求</p>
                    <p>背景为11亚模板</p>
                    <p>屏幕水平有滚动的白条纹</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xs-12 col-lg-4 map-drum-list">
                <div class="list-border">
                  <div class="list doyo">
                    <div class="drumbox">
                      <div class="map-drum-left">
                        <span class="drum drumbg"></span>
                        <span class="drum x-l nom"></span>
                        <span class="drum x-r nom"></span>
                        <span class="drum o-l nom"></span>
                        <span class="drum o-r nom"></span>
                      </div>
                      <div class="map-drum-right">
                        <span class="drum drumbg"></span>
                        <span class="drum x-l nom-"></span>
                        <span class="drum x-r nom-"></span>
                        <span class="drum o-l nom-"></span>
                        <span class="drum o-r nom-"></span>
                      </div>
                      <span class="volume-l glyphicon glyphicon-volume-off" aria-hidden="true"></span>
                      <span class="volume-r glyphicon glyphicon-volume-off" aria-hidden="true"></span>
                      <div class="drum-screen un-contrast"></div>
                    </div>
                    <p><strong>鼓况【可】与【可-】</strong></p>
                    <p>轻敲难以识别或时常吃音</p>
                    <p>【可-】则表示只有部分鼓面能满足要求</p>
                    <p>背景为14（+）模板</p>
                    <p>屏幕对比度低</p>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-xs-12 col-lg-4 map-drum-list">
                <div class="list-border">
                  <div class="list vari">
                    <div class="drumbox">
                      <div class="map-drum-left">
                        <span class="drum drumbg"></span>
                        <span class="drum x-l bad"></span>
                        <span class="drum x-r bad"></span>
                        <span class="drum o-l bad"></span>
                        <span class="drum o-r bad"></span>
                      </div>
                      <div class="map-drum-right">
                        <span class="drum drumbg"></span>
                        <span class="drum x-l bad"></span>
                        <span class="drum x-r bad"></span>
                        <span class="drum o-l bad"></span>
                        <span class="drum o-r bad"></span>
                      </div>
                      <span class="volume-l glyphicon glyphicon-volume-off" aria-hidden="true"></span>
                      <span class="volume-r glyphicon glyphicon-volume-off" aria-hidden="true"></span>
                      <div class="drum-screen c-p"></div>
                    </div>
                    <p><strong>鼓况【不可】</strong></p>
                    <p>大力出奇迹</p>
                    <p>背景为其他版本模板</p>
                    <p>屏幕色调偏紫色</p>
                  </div>
                </div>
              </div> -->
            </div>
          </div>
        </div>
        <div class="col-xs-12 index-foot">
          <p>© 2019 Leegarfield682 | <a href="http://beian.miitbeian.gov.cn" target="_blank">粤ICP备16032872号-2</a></p>
        </div>
      
    </div>

<?php require_once('template/SideNavForPwa.php'); ?>

<!--<script>
  marker = new Array();
  window.onLoad  = function(){
    map = new AMap.Map('mapcontainer');
    
    AMap.plugin([
      'AMap.ToolBar',
      'AMap.Geolocation',
    ], function(){
    // 在图面添加工具条控件，工具条控件集成了缩放、平移、定位等功能按钮在内的组合控件
    map.addControl(new AMap.ToolBar());
    // 在图面添加定位控件，用来获取和展示用户主机所在的经纬度位置
    map.addControl(new AMap.Geolocation());
    });
    
    
<?php
// $i = 0;
// foreach ($result as $key => $val){
//   if(!$val['lng']&&!$val['lng']){
//     continue;
//   }
?>
    marker[<?=$i?>] = new AMap.Marker({
    position: new AMap.LngLat(<?=$val['lng']?>, <?=$val['lat']?>),
    content: '<div><img class="markerlnglat-sm" src="/static/image/map/marker50x.png?v=1"></div>',
    offset: new AMap.Pixel(-9, -21)
    });
    
    map.add(marker[<?=$i?>]);
<?php
//   $i ++;
// }
?>
  // marker1.setIcon('https://webapi.amap.com/theme/v1.3/markers/n/mark_bs.png');
  // marker1.setOffset(new AMap.Pixel(-17, -42));
    map.setFitView();
    
  }
  
  
  var url = 'https://webapi.amap.com/maps?v=1.4.13&key=bf2cd20c090c491185e582fe5906cc59&callback=onLoad';
  var jsapi = document.createElement('script');
  jsapi.charset = 'utf-8';
  jsapi.src = url;
  document.head.appendChild(jsapi);
  
</script>-->

<?php require('template/loginSingupModal.php'); ?>

<?php require('template/footer.php'); ?>