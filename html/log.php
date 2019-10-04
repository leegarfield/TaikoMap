<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

$title = "TaikoMap太鼓地图";
$noStatic = true;

$time = time();


require_once ('include.php');
require_once ('template/header.php');

$start = connect();

$acc = logincheck();

if ($_COOKIE['num']==100){
  // echo session_save_path();
}else{
  header("Location: ".HOST."/error/404.html");
  exit;
}

if(isset($_GET['p'])){
  if(intval($_GET['p'])<1){
    $_GET['p'] = 1;
  }
  $front = 50 * (intval($_GET['p']) - 1);
  $page_f = "/log.php?p=" . (intval($_GET['p']) - 1);
  $page_d = "/log.php?p=" . (intval($_GET['p']) + 1);
}else{
  $front = 0;
  $page_f = '/log.php?p=1';
  $page_d = '/log.php?p=2';
}

?>
  <body data-pinterest-extension-installed="cr1.39.1">
    <div class="container-fluid taiko-pwa-main">
<?php
echo createNav();
?>
      <div class="col-xs-12">
        <h3>记录</h3>
        <p><a href="<?=$page_f?>">上一页</a> | <a href="<?=$page_d?>">下一页</a></p>
<?php
$sql = 'select * from taiko_map.log order by NUM desc limit '.$front.', 50;';
$result = fetchAll($sql, $start);
foreach($result as $key => $val){
  $val['nomal'] = $val['NUM'];
  $val['nomal'] .= ' - ';
  $val['nomal'] .= $val['user'];
  $val['nomal'] .= ' - ';
  $val['nomal'] .= date('Y-m-d H:i:s', $val['time']).' ';
  $val['nomal'] .= timestamp_readable_output($val['time'], $time);
  $val['nomal'] .= ' - ';
  $val['nomal'] .= $val['type'];
  $val['nomal'] .= ' - ';
  $val['nomal'] .= $val['log'];
  $val['nomal'] .= ' - ';
  $val['nomal'] .= $val['log2'];
  $val['nomal'] .= ' - ';
  $val['nomal'] .= $val['log3'];
  $val['longlog'] = $val['log_long'];
?>
        <p><?=$val['nomal']?> <?=$val['longlog']?></p>
<?php
}
?>
        <p><a href="<?=$page_f?>">上一页</a> | <a href="<?=$page_d?>">下一页</a></p>
      </div>
    </div>

<?php require_once('template/SideNavForPwa.php')?>

<?php require_once('template/loginSingupModal.php'); ?>

<?php require_once('template/footer.php')?>