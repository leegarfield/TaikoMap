<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

// 除非在taikomap.cn运行否则无法通过此开发者账号获取位置信息，出现报错“无法获取坐标地点信息”为正常现象

require_once ('include.php');

if (isset($_GET['g'])){
  $gamecenter = intval($_GET['g']);
  
  $start = connect();
  $sql = "select * from gamecenter where NUM = '".$gamecenter."'";
  if($form_value = fetchOne($sql, $start)){
    
  }else{
    header("Location: ".HOST);
    exit;
  }
  $form_value['mode'] = $gamecenter;
  $title = "修改游戏厅 - TaikoMap太鼓地图";
  $banner_title = "修改游戏厅";
  
  $side_city = $form_value['city'];
  $side_city_link = '/map.php?p='.$form_value['city'];
  $side_gamecenter = $form_value['name'];
  $side_gamecenter_link = '/gamecenter.php?g='.$form_value['NUM'];
  $banner_text = createNav($side_city, $side_city_link, $side_gamecenter, $side_gamecenter_link, $banner_title);
  
}else{
  $form_value['city'] = '';
  $form_value['area'] = '';
  $form_value['name'] = '';
  $form_value['place'] = '';
  $form_value['lng'] = '';
  $form_value['lat'] = '';
  $form_value['info'] = '';
  $form_value['mode'] = 'new';
  $title = "添加游戏厅 - TaikoMap太鼓地图";
  $banner_title = "添加游戏厅";
  $banner_text = createNav($banner_title);
}

$acc = logincheck();
require_once('template/header.php');

?>

  <body data-pinterest-extension-installed="cr1.39.1">
    <div class="container-fluid taiko-pwa-main">
        <div class="col-xs-12 nopadding">
<?php
echo $banner_text;
?>

          <div class="map" id="mapcontainer"></div>
        </div>
        <div class="col-xs-12">
            <p>请拖动地图来选择游戏厅位置</p>
            <hr />
            <p id="wrong_mes"></p>
            <form id='form1' action="/php/gcHandle.php" method="post">
              <div class="form-group">
                <input name="city" type="text" class="form-control inline-input-200" id="city" placeholder="城市名" value="<?=$form_value['city']?>">
                <label for="city">市</label>
                <input name="area" type="text" class="form-control inline-input-200" id="area" placeholder="区名" value="<?=$form_value['area']?>">
                <label for="area">区</label>
              </div>
              <div class="form-group">
                <label for="place">地点</label>
                <input name="place" type="text" class="form-control" id="place" placeholder="XXX商场" value="<?=$form_value['place']?>">
              </div>
              <div class="form-group">
                <label for="name">名称</label>
                <input name="name" type="text" class="form-control" id="name" placeholder="XXX游乐园" value="<?=$form_value['name']?>">
              </div>
              <div class="form-group">
                <label for="lng">经度</label>
                <input name="lng" type="text" class="form-control inline-input-200" id="lng" placeholder="12.345678" value="<?=$form_value['lng']?>">
                <label for="lat">纬度</label>
                <input name="lat" type="text" class="form-control inline-input-200" id="lat" placeholder="12.345678" value="<?=$form_value['lat']?>">
              </div>
              <div class="form-group">
                <label for="info">备注</label>
                <input name="info" type="text" class="form-control" id="info" placeholder="楼层、一些其他信息" value="<?=$form_value['info']?>">
              </div>
              <input name="mode" type="hidden" id="mode" value="<?=$form_value['mode']?>">
              <div class="col-xs-12 col-md-6 map-drum-list">
                <button type="sumbit" class="btn-noradius btn btn-block list-border href-nounderline">
                  <div class="list vari" style="min-height: unset; text-align: center;">
                    <p><strong>提交</strong></p>
                  </div>
                </button>
              </div>
            </form>
            <br /><br /><br />
        </div>
    </div>
    
<?php require_once('template/SideNavForPwa.php')?>
    
    <script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.13&key=bf2cd20c090c491185e582fe5906cc59&plugin=AMap.Geocoder"></script>
    <script src="//webapi.amap.com/ui/1.0/main.js"></script>
    <script>
AMapUI.loadUI(['misc/PositionPicker'], function(PositionPicker) {
  
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


  //拖曳选点
  positionPicker = new PositionPicker({
    mode:'dragMap',//设定为拖拽地图模式，可选'dragMap'、'dragMarker'，默认为'dragMap'
    map:map, //依赖地图对象
    iconStyle:{
       url:'/static/image/map/marker50x.png?v=1',//图片地址
       size:[36,50],  //要显示的点大小，将缩放图片
       ancher:[18, 42],//锚点的位置，即被size缩放之后，图片的什么位置作为选中的位置
    }
  });

  positionPicker.on('success', function(positionResult) {
    //console.log(positionResult.regeocode);
    var posinfo = positionResult.regeocode;
    if(!$('#city').val()){
      $('#city').val(posinfo.addressComponent.city.substring(0,posinfo.addressComponent.city.length-1));
    }
    if(!$('#area').val()){
      $('#area').val(posinfo.addressComponent.district.substring(0,posinfo.addressComponent.district.length-1));
    }
    $('#lng').val(positionResult.position.lng);
    $('#lat').val(positionResult.position.lat);
  });
  positionPicker.on('fail', function(positionResult) {
    // 海上或海外无法获得地址信息
    // 除非在taikomap.cn运行否则无法通过此开发者账号获取位置信息
    document.getElementById('wrong_mes').innerHTML = '出现错误：无法获取坐标地点信息';
  });


  // marker1.setIcon('https://webapi.amap.com/theme/v1.3/markers/n/mark_bs.png');
  // marker1.setOffset(new AMap.Pixel(-17, -42));
  
<?php
if ($_GET['g']){
?>
  // 设置中心点
  map.setCenter([<?=$form_value['lng']?>,<?=$form_value['lat']?>]); 
  var currentCenter = map.getCenter();
  map.setZoom(16);
<?php
}
?>
  
  map.setFitView();
  positionPicker.start();
  
});
</script>

<?php require_once('template/loginSingupModal.php')?>

<?php require_once('template/footer.php')?>