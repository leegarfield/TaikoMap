<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

require_once ('../include.php');

session_start();

$time = time();
$start = connect();
$table = 'drum';

$drum = intval($_POST['drum']);

if($_POST['mode']=='edit'){
  $actiontype = 'editDrum';
  
  $sql = 'select * from drum where NUM = "'.$drum.'"';
  $result = fetchOne($sql, $start);
  
  $arr['overall_cond_1p'] = addslashes($_POST['1P-overall']);
  $arr['overall_cond_2p'] = addslashes($_POST['2P-overall']);
  $arr['1p_x_l'] = addslashes($_POST['1P-xl']);
  $arr['1p_o_l'] = addslashes($_POST['1P-ol']);
  $arr['1p_o_r'] = addslashes($_POST['1P-or']);
  $arr['1p_x_r'] = addslashes($_POST['1P-xr']);
  $arr['2p_x_l'] = addslashes($_POST['2P-xl']);
  $arr['2p_o_l'] = addslashes($_POST['2P-ol']);
  $arr['2p_o_r'] = addslashes($_POST['2P-or']);
  $arr['2p_x_r'] = addslashes($_POST['2P-xr']);
  $arr['frame_version'] = addslashes($_POST['FrameVersion']);
  if($_POST['OSVersion']){
    $arr['os_changed'] = 1;
  }else{
    $arr['os_changed'] = 0;
  }
  $arr['os_version'] = addslashes($_POST['OSVersion']);
  $arr['1p_audio'] = intval($_POST['1P-audio']);
  $arr['2p_audio'] = intval($_POST['2P-audio']);
  $arr['screen'] = addslashes($_POST['screen']);
  $arr['coin'] = intval($_POST['coin']);
  $arr['track_no'] = intval($_POST['track_no']);
  $arr['comm'] = addslashes($_POST['comment']);
  $arr['change_no'] = intval($result['change_no']) + 1;
  $arr['last_change'] = $time;
  
  
  $where = 'NUM = "'.$drum.'"';
  update($table, $arr, $start, $where);

  $brr['lastchangeType'] = 'mod';
  $brr['lastchangeTime'] = $time;
  $brr['best_drum'] = $result['NUM'];
  
  $where2 = 'NUM = "'.$result['gamecenter'].'"';
  update('gamecenter', $brr, $start, $where2);
  
  $gamecenter = $result['gamecenter'];
  
}else if($_POST['mode']=='add'){
  $actiontype = 'addDrum';
  
  $arr['gamecenter'] = $drum;
  $arr['overall_cond_1p'] = addslashes($_POST['1P-overall']);
  $arr['overall_cond_2p'] = addslashes($_POST['2P-overall']);
  $arr['1p_x_l'] = addslashes($_POST['1P-xl']);
  $arr['1p_o_l'] = addslashes($_POST['1P-ol']);
  $arr['1p_o_r'] = addslashes($_POST['1P-or']);
  $arr['1p_x_r'] = addslashes($_POST['1P-xr']);
  $arr['2p_x_l'] = addslashes($_POST['2P-xl']);
  $arr['2p_o_l'] = addslashes($_POST['2P-ol']);
  $arr['2p_o_r'] = addslashes($_POST['2P-or']);
  $arr['2p_x_r'] = addslashes($_POST['2P-xr']);
  $arr['frame_version'] = addslashes($_POST['FrameVersion']);
  if($_POST['OSVersion']){
    $arr['os_changed'] = 1;
  }else{
    $arr['os_changed'] = 0;
  }
  $arr['os_version'] = addslashes($_POST['OSVersion']);
  $arr['1p_audio'] = intval($_POST['1P-audio']);
  $arr['2p_audio'] = intval($_POST['2P-audio']);
  $arr['screen'] = addslashes($_POST['screen']);
  $arr['coin'] = intval($_POST['coin']);
  $arr['track_no'] = intval($_POST['track_no']);
  $arr['comm'] = addslashes($_POST['comment']);
  $arr['change_no'] = 0;
  $arr['last_change'] =$time;
  
  $arr = array_filter($arr);
  
  insert($table, $arr, $start);
  
  $sql = 'select * from drum where gamecenter = "'.$drum.'"';
  $result = fetchOne($sql, $start);
  
  $brr['lastchangeType'] = 'add';
  $brr['lastchangeTime'] = $time;
  $brr['best_drum'] = $result['NUM'];
  
  $where2 = 'NUM = "'.$drum.'"';
  update('gamecenter', $brr, $start, $where2);
  
  $gamecenter = $drum;
}

if(isset($_COOKIE['num'])){
  $acc = logincheck();
  $user = $acc['NUM'];

  //记录用户修改操作
  recordAddToPlayer($user,'rec_change', $start);
}else{
  $user = $_SERVER['REMOTE_ADDR'];
}

$logger = '';
$logger .= $arr['overall_cond_1p'];
$logger .= '/';
$logger .= $arr['overall_cond_2p'];
$logger .= '%';
$logger .= $arr['1p_x_l'];
$logger .= '/';
$logger .= $arr['1p_o_l'];
$logger .= '/';
$logger .= $arr['1p_o_r'];
$logger .= '/';
$logger .= $arr['1p_x_r'];
$logger .= '/';
$logger .= $arr['2p_x_l'];
$logger .= '/';
$logger .= $arr['2p_o_l'];
$logger .= '/';
$logger .= $arr['2p_o_r'];
$logger .= '/';
$logger .= $arr['2p_x_r'];
$logger .= '%';
$logger .= $arr['1p_audio'];
$logger .= '/';
$logger .= $arr['2p_audio'];
$logger .= '%';
$logger .= $arr['screen'];
$logger .= '%';
$logger .= $arr['frame_version'];
$logger .= '/';
$logger .= $arr['os_version'];
$logger .= '%';
$logger .= $arr['coin'];
$logger .= '/';
$logger .= $arr['track_no'];
$logger .= '%';
$logger .= $arr['comm'];

$sql2 = 'select * from gamecenter where NUM = "'.$gamecenter.'"';
$result2 = fetchOne($sql2, $start);

logToDatabase($start, $user, $actiontype, $drum, $result2['NUM'], '', $logger);

header("Location: ".HOST."/map.php?p=".urlencode($result2['city']));