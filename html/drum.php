<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

require_once ('include.php');

$start = connect();
$acc = logincheck();

if ($_GET['mode'] == "add"){
  $getNum = intval($_GET['g']);
  if($getNum < 1){
    header("Location: ".HOST);
    exit;
  }
  $title = "添加框体 - TaikoMap太鼓地图";
  $info = '新建框体信息';
  $sql = "select * from gamecenter where NUM = '".$getNum."'";
  if ($result = fetchOne($sql, $start)){
    $value_pre['frame_version'] = '';
    $value_pre['os_version'] = '';
    $value_pre['common'] = '';
    $selected['4'] = 'selected="selected"';
    $selected['14'] = 'selected="selected"';
    $selected['20'] = 'selected="selected"';
    $selected['30'] = 'selected="selected"';
    $selected['40'] = 'selected="selected"';
    $selected['50'] = 'selected="selected"';
    $selected['60'] = 'selected="selected"';
    $selected['70'] = 'selected="selected"';
    $selected['80'] = 'selected="selected"';
    $selected['90'] = 'selected="selected"';
    $selected['100'] = 'selected="selected"';
    $selected['110'] = 'selected="selected"';
    $selected['120'] = 'selected="selected"';
    
    $side_city = $result['city'];
    $side_city_link = '/map.php?p='.$result['city'];
    $side_gamecenter = $result['name'];
    $side_gamecenter_link = '/gamecenter.php?g='.$result['NUM'];
    
  }else{
    header("Location: ".HOST);
    exit;
  }
}else if ($_GET['mode'] == "edit"){
  $getNum = intval($_GET['d']);
  if($getNum < 1){
    header("Location: ".HOST);
    exit;
  }
  $title = "修改框体 - TaikoMap太鼓地图";
  $info = '修改框体信息';
  $sql = "select * from drum where NUM = '".$getNum."'";
  if ($result = fetchOne($sql, $start)){
    $value_pre = $result;
    
    $selected[strval(6-textToScore($value_pre['overall_cond_1p'])/2)] = 'selected="selected"';
    $selected[strval(16-textToScore($value_pre['overall_cond_2p'])/2)] = 'selected="selected"';
    if($value_pre['1p_x_l']!=''){
      $selected[strval(26-textToScore($value_pre['1p_x_l'])/2)] = 'selected="selected"';
    }
    if($value_pre['1p_o_l']!=''){
    $selected[strval(36-textToScore($value_pre['1p_o_l'])/2)] = 'selected="selected"';
    }
    if($value_pre['1p_o_r']!=''){
    $selected[strval(46-textToScore($value_pre['1p_o_r'])/2)] = 'selected="selected"';
    }
    if($value_pre['1p_x_r']!=''){
    $selected[strval(56-textToScore($value_pre['1p_x_r'])/2)] = 'selected="selected"';
    }
    if($value_pre['2p_x_l']!=''){
      $selected[strval(66-textToScore($value_pre['2p_x_l'])/2)] = 'selected="selected"';
    }
    if($value_pre['2p_o_l']!=''){
    $selected[strval(76-textToScore($value_pre['2p_o_l'])/2)] = 'selected="selected"';
    }
    if($value_pre['2p_o_r']!=''){
    $selected[strval(86-textToScore($value_pre['2p_o_r'])/2)] = 'selected="selected"';
    }
    if($value_pre['2p_x_r']!=''){
    $selected[strval(96-textToScore($value_pre['2p_x_r'])/2)] = 'selected="selected"';
    }
    if(isset($value_pre['1p_audio'])){
    $selected[strval(104-intval($value_pre['1p_audio'])/2)] = 'selected="selected"';
    }
    if(isset($value_pre['2p_audio'])){
    $selected[strval(114-intval($value_pre['2p_audio'])/2)] = 'selected="selected"';
    }
    $selected[strval(120+screenToNum($value_pre['screen']))] = 'selected="selected"';
    
    
    $sql2 = "select * from gamecenter where NUM = '".$result['gamecenter']."'";
    $result2 = fetchOne($sql2, $start);
    $side_city = $result2['city'];
    $side_city_link = '/map.php?p='.$result2['city'];
    $side_gamecenter = $result2['name'];
    $side_gamecenter_link = '/gamecenter.php?g='.$result['gamecenter'];
    
  }else{
    header("Location: ".HOST);
    exit;
  }
}else{
  header("Location: ".HOST);
  exit;
}

require_once('template/header.php');
?>

  <body data-pinterest-extension-installed="cr1.39.1">
    <div class="container-fluid taiko-pwa-main">
        <div class="col-xs-12 nopadding">
<?php 
echo createNav($side_city, $side_city_link, $side_gamecenter, $side_gamecenter_link, '框体信息');
?>
        </div>
        <div class="col-xs-12">
          <h3><strong><?=$info?></strong></h3>
          <p><a type="button" target="_blank" href="/helpme.php" class="btn btn-danger btn-sm">信息填写指南</a></p>
          <form id="form1" action="php/drumHandle.php" method="post">
            <div class="form-group">
              <label for="FrameVersion">框体版本</label>
              <input name="FrameVersion" type="text" class="form-control" id="FrameVersion" placeholder="填写框体版本（12亚/14/6/新框等）" value="<?=$value_pre['frame_version']?>">
            </div>
            <div class="form-group">
              <label for="OSVersion">内核版本</label>
              <input name="OSVersion" type="text" class="form-control" id="OSVersion" placeholder="非魔改框体无需填此项" value="<?=$value_pre['os_version']?>">
            </div>
            <div class="drumbox inline-box">
              <div class="map-drum-right">
                <span class="drum drumbg"></span>
                <span class="drum x-l nom"></span>
                <span class="drum x-r nom"></span>
                <span class="drum o-l nom"></span>
                <span class="drum o-r nom"></span>
              </div>
              <div class="map-drum-left">
                <span class="drum drumbg"></span>
                <span class="drum x-l nom"></span>
                <span class="drum x-r nom"></span>
                <span class="drum o-l nom"></span>
                <span class="drum o-r nom"></span>
              </div>
              <span class="volume-l glyphicon glyphicon-volume-down" aria-hidden="true"></span>
              <span class="volume-r glyphicon glyphicon-volume-down" aria-hidden="true"></span>
              <div class="drum-screen nom"></div>
            </div>
            <h4><strong>可以只填总体鼓况</strong></h4>
            <div class="form-group">
              <span>1P总体</span>
              <select name="1P-overall" id="1P-overall" class="form-control select-inline">
                <option value="gold" <?=$selected['1']?>>金</option>
                <option value="good" <?=$selected['2']?>>良</option>
                <option value="good-" <?=$selected['3']?>>良-</option>
                <option value="nom" <?=$selected['4']?>>可</option>
                <option value="nom-" <?=$selected['5']?>>可-</option>
                <option value="bad" <?=$selected['6']?>>不可</option>
              </select>
              <span>2P总体</span>
              <select name="2P-overall" id="2P-overall" class="form-control select-inline">
                <option value="gold" <?=$selected['11']?>>金</option>
                <option value="good" <?=$selected['12']?>>良</option>
                <option value="good-" <?=$selected['13']?>>良-</option>
                <option value="nom" <?=$selected['14']?>>可</option>
                <option value="nom-" <?=$selected['15']?>>可-</option>
                <option value="bad" <?=$selected['16']?>>不可</option>
              </select>
            </div>
            <p><strong>1P（左）</strong></p>
            <div class="form-group">
              <span>左咔</span>
              <select name="1P-xl" id="1P-xl" class="form-control select-inline">
                <option value="" <?=$selected['20']?>> </option>
                <option value="gold" <?=$selected['21']?>>金</option>
                <option value="good" <?=$selected['22']?>>良</option>
                <option value="good-" <?=$selected['23']?>>良-</option>
                <option value="nom" <?=$selected['24']?>>可</option>
                <option value="nom-" <?=$selected['25']?>>可-</option>
                <option value="bad" <?=$selected['26']?>>不可</option>
              </select>
              <span>左咚</span>
              <select name="1P-ol" id="1P-ol" class="form-control select-inline">
                <option value="" <?=$selected['30']?>> </option>
                <option value="gold" <?=$selected['31']?>>金</option>
                <option value="good" <?=$selected['32']?>>良</option>
                <option value="good-" <?=$selected['33']?>>良-</option>
                <option value="nom" <?=$selected['34']?>>可</option>
                <option value="nom-" <?=$selected['35']?>>可-</option>
                <option value="bad" <?=$selected['36']?>>不可</option>
              </select>
              <span>右咚</span>
              <select name="1P-or" id="1P-or" class="form-control select-inline">
                <option value="" <?=$selected['40']?>> </option>
                <option value="gold" <?=$selected['41']?>>金</option>
                <option value="good" <?=$selected['42']?>>良</option>
                <option value="good-" <?=$selected['43']?>>良-</option>
                <option value="nom" <?=$selected['44']?>>可</option>
                <option value="nom-" <?=$selected['45']?>>可-</option>
                <option value="bad" <?=$selected['46']?>>不可</option>
              </select>
              <span>右咔</span>
              <select name="1P-xr" id="1P-xr" class="form-control select-inline">
                <option value="" <?=$selected['50']?>> </option>
                <option value="gold" <?=$selected['51']?>>金</option>
                <option value="good" <?=$selected['52']?>>良</option>
                <option value="good-" <?=$selected['53']?>>良-</option>
                <option value="nom" <?=$selected['54']?>>可</option>
                <option value="nom-" <?=$selected['55']?>>可-</option>
                <option value="bad" <?=$selected['56']?>>不可</option>
              </select>
            </div>
            <p><strong>2P（右）</strong></p>
            <div class="form-group">
              <span>左咔</span>
              <select name="2P-xl" id="2P-xl" class="form-control select-inline">
                <option value="" <?=$selected['60']?>> </option>
                <option value="gold" <?=$selected['61']?>>金</option>
                <option value="good" <?=$selected['62']?>>良</option>
                <option value="good-" <?=$selected['63']?>>良-</option>
                <option value="nom" <?=$selected['64']?>>可</option>
                <option value="nom-" <?=$selected['65']?>>可-</option>
                <option value="bad" <?=$selected['66']?>>不可</option>
              </select>
              <span>左咚</span>
              <select name="2P-ol" id="2P-ol" class="form-control select-inline">
                <option value="" <?=$selected['70']?>> </option>
                <option value="gold" <?=$selected['71']?>>金</option>
                <option value="good" <?=$selected['72']?>>良</option>
                <option value="good-" <?=$selected['73']?>>良-</option>
                <option value="nom" <?=$selected['74']?>>可</option>
                <option value="nom-" <?=$selected['75']?>>可-</option>
                <option value="bad" <?=$selected['76']?>>不可</option>
              </select>
              <span>右咚</span>
              <select name="2P-or" id="2P-or" class="form-control select-inline">
                <option value="" <?=$selected['80']?>> </option>
                <option value="gold" <?=$selected['81']?>>金</option>
                <option value="good" <?=$selected['82']?>>良</option>
                <option value="good-" <?=$selected['83']?>>良-</option>
                <option value="nom" <?=$selected['84']?>>可</option>
                <option value="nom-" <?=$selected['85']?>>可-</option>
                <option value="bad" <?=$selected['86']?>>不可</option>
              </select>
              <span>右咔</span>
              <select name="2P-xr" id="2P-xr" class="form-control select-inline">
                <option value="" <?=$selected['90']?>> </option>
                <option value="gold" <?=$selected['91']?>>金</option>
                <option value="good" <?=$selected['92']?>>良</option>
                <option value="good-" <?=$selected['93']?>>良-</option>
                <option value="nom" <?=$selected['94']?>>可</option>
                <option value="nom-" <?=$selected['95']?>>可-</option>
                <option value="bad" <?=$selected['96']?>>不可</option>
              </select>
            </div>
            <p><strong>音响</strong></p>
            <div class="form-group">
              <span>1P（左）</span>
              <select name="1P-audio" id="1P-audio" class="form-control select-inline">
                <option value="" <?=$selected['100']?>> </option>
                <option value="6" <?=$selected['101']?>>大</option>
                <option value="4" <?=$selected['102']?>>中</option>
                <option value="2" <?=$selected['103']?>>小</option>
                <option value="0" <?=$selected['104']?>>静音</option>
              </select>
              <span>2P（右）</span>
              <select name="2P-audio" id="2P-audio" class="form-control select-inline">
                <option value="" <?=$selected['110']?>> </option>
                <option value="6" <?=$selected['111']?>>大</option>
                <option value="4" <?=$selected['112']?>>中</option>
                <option value="2" <?=$selected['113']?>>小</option>
                <option value="0" <?=$selected['114']?>>静音</option>
              </select>
            </div>
            <p><strong>屏幕</strong></p>
            <div class="form-group">
              <select name="screen" id="screen" class="form-control select-inline">
                <option value="" <?=$selected['120']?>> </option>
                <option value="nom" <?=$selected['121']?>>正常</option>
                <option value="c-y" <?=$selected['122']?>>偏色：黄</option>
                <option value="c-b" <?=$selected['123']?>>偏色：青</option>
                <option value="c-p" <?=$selected['124']?>>偏色：紫</option>
                <option value="streched" <?=$selected['125']?>>屏幕拉伸</option>
                <option value="un-contrast" <?=$selected['126']?>>对比度低</option>
                <option value="cut" <?=$selected['127']?>>分割屏</option>
                <option value="bright" <?=$selected['128']?>>泛白</option>
                <option value="dark" <?=$selected['129']?>>泛黑</option>
                <option value="blur" <?=$selected['130']?>>模糊</option>
                <option value="hor-w" <?=$selected['131']?>>白色横条</option>
                <option value="hor-b" <?=$selected['132']?>>黑色横条</option>
                <option value="ver-w" <?=$selected['133']?>>白色竖条</option>
                <option value="ver-b" <?=$selected['134']?>>黑色竖条</option>
                <option value="big" <?=$selected['134']?>>屏幕显示不全</option>
              </select>
            </div>
            <div class="form-group">
              <input name="coin" type="number" class="form-control inline-input-100" id="coin" placeholder="投币数" value="<?=$value_pre['coin']?>">
              <label for="coin">币</label>
              <input name="track_no" type="number" class="form-control inline-input-100" id="track_no" placeholder="曲目数" value="<?=$value_pre['track_no']?>">
              <label for="coin">曲</label>
            </div>
            <div class="form-group">
              <label for="comment">备注</label>
              <input name="comment" type="text" class="form-control" id="comment" placeholder="可以填写框体简介或其他内容" value="<?=$value_pre['comm']?>">
            </div>
            <input name="mode" type="hidden" value="<?=$_GET['mode']?>">
            <input name="drum" type="hidden" value="<?=$getNum?>">
            <div class="col-xs-12 col-md-6 map-drum-list">
              <button type="sumbit" class="btn-noradius btn btn-block list-border href-nounderline">
                <div class="list namico" style="min-height: unset; text-align: center;">
                  <p><strong>提交</strong></p>
                </div>
              </button>
            </div>
            <div class="col-xs-12">
              <br /><br /><br />
            </div>
          </form>
        </div>
        <br /><br /><br />
    </div>
    
<?php require_once('template/SideNavForPwa.php')?>
    
<script>
$(document).ready(function(){
  $('select').change(function(){
    updateDrum();
  });
  updateDrum();
});

function updateDrum(){
  $('.map-drum-left').children('.x-l').attr('class','drum x-l '+$('#1P-overall')[0].value);
  $('.map-drum-left').children('.o-l').attr('class','drum o-l '+$('#1P-overall')[0].value);
  $('.map-drum-left').children('.o-r').attr('class','drum o-r '+$('#1P-overall')[0].value);
  $('.map-drum-left').children('.x-r').attr('class','drum x-r '+$('#1P-overall')[0].value);
  
  if($('#1P-xl')[0].value.length > 1){
    $('.map-drum-left').children('.x-l').attr('class','drum x-l '+$('#1P-xl')[0].value);
  }
  if($('#1P-ol')[0].value.length > 1){
    $('.map-drum-left').children('.o-l').attr('class','drum o-l '+$('#1P-ol')[0].value);
  }
  if($('#1P-or')[0].value.length > 1){
    $('.map-drum-left').children('.o-r').attr('class','drum o-r '+$('#1P-or')[0].value);
  }
  if($('#1P-xr')[0].value.length > 1){
    $('.map-drum-left').children('.x-r').attr('class','drum x-r '+$('#1P-xr')[0].value);
  }
  $('.map-drum-right').children('.x-l').attr('class','drum x-l '+$('#2P-overall')[0].value);
  $('.map-drum-right').children('.o-l').attr('class','drum o-l '+$('#2P-overall')[0].value);
  $('.map-drum-right').children('.o-r').attr('class','drum o-r '+$('#2P-overall')[0].value);
  $('.map-drum-right').children('.x-r').attr('class','drum x-r '+$('#2P-overall')[0].value);
  
  if($('#2P-xl')[0].value.length > 1){
    $('.map-drum-right').children('.x-l').attr('class','drum x-l '+$('#2P-xl')[0].value);
  }
  if($('#2P-ol')[0].value.length > 1){
    $('.map-drum-right').children('.o-l').attr('class','drum o-l '+$('#2P-ol')[0].value);
  }
  if($('#2P-or')[0].value.length > 1){
    $('.map-drum-right').children('.o-r').attr('class','drum o-r '+$('#2P-or')[0].value);
  }
  if($('#2P-xr')[0].value.length > 1){
    $('.map-drum-right').children('.x-r').attr('class','drum x-r '+$('#2P-xr')[0].value);
  }
  switch($('#1P-audio')[0].value){
    case '0':
      $('.volume-l').attr('class','volume-l  glyphicon glyphicon-volume-off');
    break;
    case '2':
      $('.volume-l').attr('class','volume-l  glyphicon glyphicon-volume-down');
    break;
    case '4':
      $('.volume-l').attr('class','volume-l  glyphicon glyphicon-volume-up');
    break;
    case '6':
      $('.volume-l').attr('class','volume-l  glyphicon glyphicon-volume-up vol-gold');
    break;
    default:
      $('.volume-l').attr('class','volume-l  glyphicon glyphicon-volume-down');
  }
  switch($('#2P-audio')[0].value){
    case '0':
      $('.volume-r').attr('class','volume-r  glyphicon glyphicon-volume-off');
    break;
    case '2':
      $('.volume-r').attr('class','volume-r  glyphicon glyphicon-volume-down');
    break;
    case '4':
      $('.volume-r').attr('class','volume-r  glyphicon glyphicon-volume-up');
    break;
    case '6':
      $('.volume-r').attr('class','volume-r  glyphicon glyphicon-volume-up vol-gold');
    break;
    default:
      $('.volume-r').attr('class','volume-r  glyphicon glyphicon-volume-down');
  }
  if($('#screen')[0].value.length > 1){
    $('.drum-screen').attr('class','drum-screen '+$('#screen')[0].value);
  }
  // console.log('ha');
  
}

</script>

<?php require_once('template/loginSingupModal.php'); ?>

<?php
require_once('template/footer.php')
?>
