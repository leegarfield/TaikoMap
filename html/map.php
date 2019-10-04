<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

$title = "TaikoMap太鼓地图";

require_once ('include.php');

$acc = logincheck();
require_once('template/header.php');

$start = connect();

if (isset($_GET['p'])){
  $area_select = addslashes($_GET['p']);
}else{
  $area_select = "深圳";
}

$time = time();

$sql = "select * from gamecenter where city = '".$area_select."' ORDER BY lat DESC";
$result = fetchAll($sql, $start);

$sql2 = "select * from drum";
$result2 = fetchAll($sql2, $start);
?>

  <body data-pinterest-extension-installed="cr1.39.1">
    <div class="container-fluid taiko-pwa-main">
        <div class="col-xs-12 nopadding">
          <div class="nav">
            <p class="nav-top"><a class="href-text-nomal" href="/">TaikoMap - 太鼓地图</a></p>
            <div class="nav-bottom">
              <p><a href="/"><span>主页</span></a><a href="#"><span><?=$area_select?></span></a></p>
            </div>
          </div>
          <div id="nav-btn" class="nav-btn href showUntil-M">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
          </div>
          <div class="map" id="mapcontainer"></div>
        </div>
        <div class="col-xs-12">

<?php require_once('template/announcement.php');?>

        </div>
<?php
$h = 0;
$best_drum = array_column($result2, 'NUM');
foreach ($result as $key => $val){
  $h ++;
  $best_drum_index = array_keys($best_drum, $val['best_drum']);
  $drum = $result2[$best_drum_index[0]];

  $drum = frameClassToDrum($drum);
  $drum_version = $drum['version'];
  
  $drum['last_action'] = handleLastAction($val, $time);
  
?>
        <div class="col-sm-6 col-xs-12 col-lg-4 map-drum-list" id="list<?=$h?>">
          <a href="gamecenter.php?g=<?=$val['NUM']?>" class="list-border href-nounderline">
            <div class="list <?=$drum['frame_class']?>">
<?php
  if($val['best_drum']){
    $drumface = judgedrum($drum);
?>
              <div class="drumbox">
                <div class="map-drum-right">
                  <span class="drum drumbg"></span>
                  <span class="drum x-l <?=$drumface['2p']['x-l']?>"></span>
                  <span class="drum x-r <?=$drumface['2p']['x-r']?>"></span>
                  <span class="drum o-l <?=$drumface['2p']['o-l']?>"></span>
                  <span class="drum o-r <?=$drumface['2p']['o-r']?>"></span>
                </div>
                <div class="map-drum-left">
                  <span class="drum drumbg"></span>
                  <span class="drum x-l <?=$drumface['1p']['x-l']?>"></span>
                  <span class="drum x-r <?=$drumface['1p']['x-r']?>"></span>
                  <span class="drum o-l <?=$drumface['1p']['o-l']?>"></span>
                  <span class="drum o-r <?=$drumface['1p']['o-r']?>"></span>
                </div>
                <span class="volume-l glyphicon glyphicon-volume-<?=$drum['1p_audio_class']?>" aria-hidden="true"></span>
                <span class="volume-r glyphicon glyphicon-volume-<?=$drum['2p_audio_class']?>" aria-hidden="true"></span>
                <div class="drum-screen <?=$drum['screen']?>"></div>
              </div>
<?php
      }else{
        $drum['coinPerTrack'] = '<i>尚未添加框体</i>';
      }
?>
              <p><strong><?=$val['place']?></strong></p>
              <p><?=$val['name']?></p>
              <p><?=$drum['version']?> <?=$drum['coinPerTrack']?></p>
              <p><?=$drum['last_action']?></p>
            </div>
          </a>
        </div>
<?php
}
?>
        
        <div class="col-sm-6 col-xs-12 col-lg-4 map-drum-list">
          <a href="/addGC.php" class="list-border href-nounderline">
            <div class="list doyo">
              <p><strong>【添加游戏厅】</strong></p>
              <p>------------</p>
              <p>同一游戏厅内多个鼓点清在对应游戏厅页面添加</p>
              <p>目前这个页面展示的鼓默认是最新修改过的鼓</p>
            </div>
          </a>
        </div>
        <div class="col-xs-12">
          <br /><br /><br />
        </div>
    </div>
    
<?php require_once('template/SideNavForPwa.php')?>

<script>
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
$i = 0;
foreach ($result as $key => $val){
  if(!$val['lng']&&!$val['lng']){
    continue;
  }
?>
    marker[<?=$i?>] = new AMap.Marker({
    position: new AMap.LngLat(<?=$val['lng']?>, <?=$val['lat']?>),
    content: '<div><img class="markerlnglat" src="/static/image/map/marker50x.png?v=1"><a href="gamecenter.php?g=<?=$val['NUM']?>"><u class="map--marker-lable"><?=$val['place']?></u></a></div>',
    offset: new AMap.Pixel(-18, -42)
    });
    
    map.add(marker[<?=$i?>]);
<?php
  $i ++;
}
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
  
</script>

<?php require_once('template/loginSingupModal.php'); ?>

<?php require_once('template/footer.php')?>
