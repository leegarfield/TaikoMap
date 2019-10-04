<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

require_once ('include.php');

if (isset($_GET['g'])){
  $gamecenterNum = intval($_GET['g']);
  if($gamecenterNum < 1){
    header("Location: ".HOST);
    exit;
  }
}else{
  header("Location: ".HOST);
  exit;
}

$start = connect();
$sql = "select * from gamecenter where NUM = '".$gamecenterNum."'";
if ($result = fetchOne($sql, $start)){
  $sql2 = "select * from drum where gamecenter = '".$gamecenterNum."'";
  $result2 = fetchAll($sql2, $start);
}else{
  header("Location: ".HOST);
  exit;
}

$title = $result['place']." - TaikoMap太鼓地图";

//滑稽
if ($result['city'] == '武汉'){
  $button['card'] = '阿电姐';
  $button['cloud_card'] = '云阿电姐';
  $button['add_info'] = '勤可以不出，电姐必须阿（大雾）';
} else {
  $button['card'] = '出勤';
  $button['cloud_card'] = '云出勤';
  $button['add_info'] = '';
}

//获取游戏厅编辑历史
$sqlGcHistory = 'select * from log where type="modGC"&&log="'.$gamecenterNum.'" order by time DESC';
$gcHistory = fetchAll($sqlGcHistory, $start);
$gcHistoryText = '';
$usernamelist = [];
if(sizeof($gcHistory)>0){
  foreach($gcHistory as $keyGc=>$valGc){
    $logoutput = explode('%', $valGc['log_long']);

    $userExploded = explode('.', $valGc['user']);
    if(sizeof($userExploded[1])>0){
      $valGc['user'] = $userExploded[0].'.'.strtr($userExploded[1], '1234567890', '**********').'.'.strtr($userExploded[2], '1234567890', '**********').'.'.$userExploded[3];
      $gcHistoryText .= '<p>'.date('Y-m-d H:i', $valGc['time']).' - '.$valGc['user'].' - 游戏厅：【'.$logoutput[0].' - '.$logoutput[1].'】 备注：【'.$logoutput[4].'】</p>';
    }else if(!isset($username[$valGc['user']])){
      $username[$valGc['user']] = fetchOne('select nickname from player_table where NUM = "'.$valGc['user'].'"', $start)['nickname'];
      $gcHistoryText .= '<p>'.date('Y-m-d H:i', $valGc['time']).' - '.$username[$valGc['user']].' - 游戏厅：【'.$logoutput[0].' - '.$logoutput[1].'】 备注：【'.$logoutput[4].'】</p>';
    }else{
      $gcHistoryText .= '<p>'.date('Y-m-d H:i', $valGc['time']).' - '.$username[$valGc['user']].' - 游戏厅：【'.$logoutput[0].' - '.$logoutput[1].'】 备注：【'.$logoutput[4].'】</p>';
    }

  }
}else{
  $gcHistoryText = '<p>暂无编辑历史</p>';
}

$side_city = $result['city'];
$side_city_link = '/map.php?p='.$result['city'];

$acc = logincheck();
require_once('template/header.php');
?>

  <body data-pinterest-extension-installed="cr1.39.1">
    <div class="container-fluid taiko-pwa-main">
        <div class="col-xs-12 nopadding relative">
          <div class="nav">
            <p class="nav-top"><a class="href-text-nomal" href="/">TaikoMap - 太鼓地图</a></p>
            <div class="nav-bottom">
              <p><a href="/"><span>主页</span></a><a href="<?=$side_city_link?>"><span><?=$side_city?></span></a><a href="#"><span><?=$result['place']?></span></a></p>
            </div>
          </div>
          <div id="nav-btn" class="nav-btn href showUntil-M">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
          </div>
          <div class="map" id="mapcontainer"></div>
        </div>
        <div class="col-xs-12">
          <h3><strong><?=$result['city']?> <?=$result['area']?>区 <?=$result['place']?> - <?=$result['name']?></strong> <small><a href="/addGC.php?g=<?=$gamecenterNum?>">修改游戏厅信息</a></small></h3>
          <div class="gamecenter-GC-history">
            <p class="js-spoil href gamecenter-GC-history-title"><?=sizeof($gcHistory)?>条编辑历史<span class="caret js-spoil-rotate-180"></p>
            <div style="display: none">
              <?=$gcHistoryText?>
            </div>
          </div>
          <p><strong><?=$result['info']?></strong></p>

<?php require_once('template/announcement.php');?>

          <hr class="dark-hr"/>
        </div>
<?php
$h = 0;
$dn = 0;
$drumH = [];
$drumfaceH = [];
if ($result2){

  foreach ($result2 as $key => $val){
    $h ++;
    $drum = $val;
    
    $drumface = judgedrum($drum);
    
    $drum = frameClassToDrum($drum);

    // fetch编辑历史
    $sqlFetchDrumHistory[$drum['NUM']] = 'select * from log where type = "editDrum" && log = "' . $drum['NUM'] . '" order by time DESC';
    $FetchDrumHistoryResult[$drum['NUM']] = fetchAll($sqlFetchDrumHistory[$drum['NUM']], $start);

    // unset($FetchDrumHistoryResult[$drum['NUM']][0]);
    
?>
        <div class="col-xs-12 map-drum-list">
          <div class="list-border">
            <div class="list <?=$drum['frame_class']?>">
              <div class="row">
              <div class="col-xs-12 col-sm-3 col-md-2">
                <div class="drumbox inline-box">
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
              </div>
              <div class="col-xs-12 col-sm-9 col-md-10">
                <!--<p class="score">综合分数：<span><?=$drum['score']?></span></p>-->
                <p><?=$drum['version_text']?></p>
                <p><?=$drum['screen_exp']?></p>
                <p><?=$drum['audio_desc']?></p>
                <p>其他信息：<?=$drum['comm']?></p>
                <br />
                <p>鼓况有误？<a class="text-border-w href-white" href="/drum.php?d=<?=$drum['NUM']?>&mode=edit">点此变更鼓况</a></p>
              </div>
              </div>
            </div>
          </div>
        </div>
<?php
    if(sizeof($FetchDrumHistoryResult[$drum['NUM']])>0){
?>
        <div>
          <div class="col-xs-12 map-drum-list js-spoil">
            <div class="list-border">
              <div class="list namico" style="min-height: unset; text-align: center;">
                <p><?=sizeof($FetchDrumHistoryResult[$drum['NUM']])?>条编辑历史</p>
              </div>
            </div>
          </div>
          <div class="map-drum-list gamecenter-drum-history-box" style="display: none">
<?php
      foreach($FetchDrumHistoryResult[$drum['NUM']] as $keyDm=>$valDm){
        
        $logoutput = explode('%', $valDm['log_long']);
        
        $drumHistory[$dn] = $valDm;

        $drumH[$dn]['NUM'] = $drum['NUM'];

        $drumH[$dn]['overall_cond_1p'] = explode('/', $logoutput[0])[0];
        $drumH[$dn]['overall_cond_2p'] = explode('/', $logoutput[0])[1];

        $drumH[$dn]['1p_x_l'] = explode('/', $logoutput[1])[0];
        $drumH[$dn]['1p_o_l'] = explode('/', $logoutput[1])[1];
        $drumH[$dn]['1p_o_r'] = explode('/', $logoutput[1])[2];
        $drumH[$dn]['1p_x_r'] = explode('/', $logoutput[1])[3];
        $drumH[$dn]['2p_x_l'] = explode('/', $logoutput[1])[4];
        $drumH[$dn]['2p_o_l'] = explode('/', $logoutput[1])[5];
        $drumH[$dn]['2p_o_r'] = explode('/', $logoutput[1])[6];
        $drumH[$dn]['2p_x_r'] = explode('/', $logoutput[1])[7];

        $drumH[$dn]['frame_version'] = explode('/', $logoutput[4])[0];
        $drumH[$dn]['os_version'] = explode('/', $logoutput[4])[1];

        if($drumH[$dn]['os_version']){
          $drumH[$dn]['os_changed'] = 1;
        }
        
        $drumH[$dn]['1p_audio'] = explode('/', $logoutput[2])[0];
        $drumH[$dn]['2p_audio'] = explode('/', $logoutput[2])[1];
        
        $drumH[$dn]['screen'] = $logoutput[3];
        
        $drumH[$dn]['coin'] = explode('/', $logoutput[5])[0];
        $drumH[$dn]['track_no'] = explode('/', $logoutput[5])[1];
        
        $drumH[$dn]['comm'] = $logoutput[6];
        
        
        $drumfaceH[$dn] = judgedrum($drumH[$dn]);
        
        $drumH[$dn] = frameClassToDrum($drumH[$dn]);
        
        //编辑者处理
        $userExploded = explode('.', $valDm['user']);
        if(sizeof($userExploded[1])>0){
          $userIpReplaced = strtr($userExploded[1], '1234567890', '**********');
          $userIpReplaced .= '.';
          $userIpReplaced .= strtr($userExploded[2], '1234567890', '**********');
          $valDm['user'] = $userExploded[0].'.'.$userIpReplaced.'.'.$userExploded[3];

          $drumH[$dn]['user&time'] = date('Y-m-d H:i', $valDm['time']) . ' 由 ' . $valDm['user'] . ' 提交更改';
        }else if(!isset($username[$valDm['user']])){
          $username[$valDm['user']] = fetchOne('select nickname from player_table where NUM = "'.$valDm['user'].'"', $start)['nickname'];
          $drumH[$dn]['user&time'] = date('Y-m-d H:i', $valDm['time']) . ' 由 ' . $username[$valDm['user']] . ' 提交更改';
        }else{
          $drumH[$dn]['user&time'] = date('Y-m-d H:i', $valDm['time']) . ' 由 ' . $username[$valDm['user']] . ' 提交更改';
        }
        

        ?>

            <div class="col-xs-12 map-drum-list">
              <div class="list-border">
                <div class="list <?=$drumH[$dn]['frame_class']?>">
                  <div class="row">
                  <div class="col-xs-12 col-sm-3 col-md-2">
                    <div class="drumbox inline-box">
                      <div class="map-drum-right">
                        <span class="drum drumbg"></span>
                        <span class="drum x-l <?=$drumfaceH[$dn]['2p']['x-l']?>"></span>
                        <span class="drum x-r <?=$drumfaceH[$dn]['2p']['x-r']?>"></span>
                        <span class="drum o-l <?=$drumfaceH[$dn]['2p']['o-l']?>"></span>
                        <span class="drum o-r <?=$drumfaceH[$dn]['2p']['o-r']?>"></span>
                      </div>
                      <div class="map-drum-left">
                        <span class="drum drumbg"></span>
                        <span class="drum x-l <?=$drumfaceH[$dn]['1p']['x-l']?>"></span>
                        <span class="drum x-r <?=$drumfaceH[$dn]['1p']['x-r']?>"></span>
                        <span class="drum o-l <?=$drumfaceH[$dn]['1p']['o-l']?>"></span>
                        <span class="drum o-r <?=$drumfaceH[$dn]['1p']['o-r']?>"></span>
                      </div>
                      <span class="volume-l glyphicon glyphicon-volume-<?=$drumH[$dn]['1p_audio_class']?>" aria-hidden="true"></span>
                      <span class="volume-r glyphicon glyphicon-volume-<?=$drumH[$dn]['2p_audio_class']?>" aria-hidden="true"></span>
                      <div class="drum-screen <?=$drumH[$dn]['screen']?>"></div>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-9 col-md-10">
                    <!--<p class="score">综合分数：<span><?=$drumH[$dn]['score']?></span></p>-->
                    <p><?=$drumH[$dn]['version_text']?></p>
                    <p><?=$drumH[$dn]['screen_exp']?></p>
                    <p><?=$drumH[$dn]['audio_desc']?></p>
                    <p>其他信息：<?=$drumH[$dn]['comm']?></p>
                    <br />
                    <p><?=$drumH[$dn]['user&time']?></p>
                  </div>
                  </div>
                </div>
              </div>
            </div>
<?php

        $dn ++;
      }
?>
          </div>
        </div>
<?php
    }
  }
}
?>
        <div class="col-xs-6 map-drum-list">
          <a href="/php/activity.php?n=<?=$gamecenterNum?>&m=cloud_card" class="list-border href-nounderline">
            <div class="list game" style="min-height: unset; text-align: center;">
              <p><strong><?=$button['cloud_card']?></strong></p>
              <p><?=$result['cloud_card']?>人次</p>
            </div>
          </a>
        </div>
        <div class="col-xs-6 map-drum-list">
          <a href="/php/activity.php?n=<?=$gamecenterNum?>&m=card" class="list-border href-nounderline">
            <div class="list vari" style="min-height: unset; text-align: center;">
              <p><strong><?=$button['card']?></strong></p>
              <p><?=$result['card']?>人次</p>
            </div>
          </a>
        </div>
        <div class="col-xs-6 map-drum-list">
          <a href="/drum.php?g=<?=$gamecenterNum?>&mode=add" class="list-border href-nounderline">
            <div class="list j-pop" style="min-height: unset; text-align: center;">
              <p><strong>添加框体</strong></p>
            </div>
          </a>
        </div>
        <div class="col-xs-6 map-drum-list">
          <a href="/addGC.php?g=<?=$gamecenterNum?>" class="list-border href-nounderline">
            <div class="list doyo" style="min-height: unset; text-align: center;">
              <p><strong>修改游戏厅信息</strong></p>
            </div>
          </a>
        </div>
        <div class="col-xs-12">
          <p><?=$button['add_info']?></p>
          <br /><br /><br />
        </div>
    </div>
    
<?php require_once('template/SideNavForPwa.php')?>
    
    <script>
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
    marker = new AMap.Marker({
      position: new AMap.LngLat(<?=$result['lng']?>, <?=$result['lat']?>),
      content: '<div><img class="markerlnglat" src="/static/image/map/marker50x.png?v=1"><span class="map--marker-lable"><?=$result['name']?></span></div>',
      offset: new AMap.Pixel(-18, -42)
    });
    
    map.add(marker);
    
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

<?php

require_once('template/footer.php')

?>
