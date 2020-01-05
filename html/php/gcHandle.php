<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

require_once ('../include.php');

session_start();

$time = time();
$start = connect();
$table = 'gamecenter';


if(!$_POST['city']){
  header("Location: ".HOST."/template/error.php?msg=".urlencode("城市不能为空！"));
  exit;
}
if(!$_POST['place']){
  header("Location: ".HOST."/template/error.php?msg=".urlencode("地点不能为空！"));
  exit;
}
if(!$_POST['name']){
  header("Location: ".HOST."/template/error.php?msg=".urlencode("游戏厅名不能为空！"));
  exit;
}

//tempoary login check with black list check
$acc = logincheck(true);
if(!isset($acc['NUM'])){
  header("Location: ".HOST."/template/error.php?msg=".urlencode("请注册或登录后操作！"));
  exit;
}

$arr['city'] = addslashes($_POST['city']);
$arr['area'] = addslashes($_POST['area']);
$arr['place'] = addslashes($_POST['place']);
$arr['name'] = addslashes($_POST['name']);
$arr['lng'] = addslashes($_POST['lng']);
$arr['lat'] = addslashes($_POST['lat']);
$arr['info'] = addslashes($_POST['info']);

//$arr = array_filter($arr);


if ($_POST['mode'] == 'new'){
  $arr['lastchangeType'] = 'addGC';
  $arr['lastchangeTime'] = $time;
  insert($table, $arr, $start);
  $actiontype = 'addGC';
  $drum = 'new';
}else if(isset($_POST['mode'])){
  
  $sql = "select * from gamecenter where NUM = '".intval($_POST['mode'])."'";
  
  if($form_value = fetchOne($sql, $start)){
    $arr['lastchangeType'] = 'modGC';
    $arr['lastchangeTime'] = $time;
    $where = 'NUM = "'.intval($_POST['mode']).'"';
    update($table, $arr, $start, $where);
    $actiontype = 'modGC';
    $drum = intval($_POST['mode']);
  }else{
    header("Location: ".HOST);
    exit;
  }
}else{
  $arr['lastchangeType'] = 'addGC';
  $arr['lastchangeTime'] = $time;
  insert($table, $arr, $start);
  $actiontype = 'addGC';
  $drum = 'new';
}


//log

$logger = '';
$logger .= $arr['city'];
$logger .= $arr['area'];
$logger .= '%';
$logger .= $arr['place'];
$logger .= $arr['name'];
$logger .= '%';
$logger .= $arr['lng'];
$logger .= '%';
$logger .= $arr['lat'];
$logger .= '%';
$logger .= $arr['info'];

if(isset($_COOKIE['num'])){
  $acc = logincheck();
  $user = $acc['NUM'];
  
  //记录用户修改操作
  recordAddToPlayer($user,'rec_change', $start);
}else{
  $user = $_SERVER['REMOTE_ADDR'];
}

logToDatabase($start, $user, $actiontype, $drum, '', '', $logger);

//update citylist;
$pageOp = new PageOpreate;
//$pageOp->updateCityList();

header("Location: ".HOST."/map.php?p=".urlencode($arr['city']));
