<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

require_once ('../include.php');

session_start();

$time = time();
$start = connect();


$mode = $_GET['m'];
switch($mode){
  //云打卡
  case 'cloud_card':
    $acc = logincheck();
    if(!isset($acc['NUM'])){
      header("Location: ".HOST."/template/error.php?msg=".urlencode("请先去主页登陆再云打卡！"));
      exit;
    }
    $NUM = intval($_GET['n']);
    $sql = "UPDATE gamecenter SET cloud_card=cloud_card+1 WHERE NUM='".$NUM."'";
    $result = fetchALL("select * from log where user='".$acc['NUM']."'&& type='cloud_card'&& log='".$NUM."' order by time DESC", $start);
    $time_passed = $time - $result[0]['time']-$result[0]['time']%86400;
    if ($time_passed<24){
      header("Location: ".HOST."/template/error.php?msg=".urlencode("同一个地点一天只能云一次！"));
      exit;
    }
    
    $start->query($sql);
    logToDatabase($start, $acc['NUM'], 'cloud_card', $NUM);
    recordAddToPlayer($acc['NUM'],'rec_cloud_tick', $start);
    
    header("Location: ".HOST."/gamecenter.php?g=".$NUM);
    
  break;
  //打卡出勤
  case 'card':
    $acc = logincheck();
    if(!isset($acc['NUM'])){
      header("Location: ".HOST."/template/error.php?msg=".urlencode("请先去主页登陆再打卡出勤= ="));
      exit;
    }
    $NUM = intval($_GET['n']);
    $sql = "UPDATE gamecenter SET card=card+1, lastchangeType='card', lastchangeTime=".$time." WHERE NUM='".$NUM."'";
    $result = fetchALL("select * from log where user='".$acc['NUM']."'&& type='card'&& log='".$NUM."' order by time DESC", $start);
    $time_passed = $time - $result[0]['time']-$result[0]['time']%86400;
    if ($time_passed<24){
      header("Location: ".HOST."/template/error.php?msg=".urlencode("同一个地点一天只能出勤一次"));
      exit;
    }
    
    $start->query($sql);
    logToDatabase($start, $acc['NUM'], 'card', $NUM);
    recordAddToPlayer($acc['NUM'],'rec_tick', $start);
    
    header("Location: ".HOST."/gamecenter.php?g=".$NUM);
    
  break;
}