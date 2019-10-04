<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

require_once ('../include.php');
session_start();
$time = time();
$cookieExpTime = $time + 2678400;

// var_dump($_POST);

if(!$_POST['nickname']){
  header("Location: ".HOST."/template/error.php?msg=".urlencode("请填写昵称"));
  exit;
}
if(!$_POST['password']){
  header("Location: ".HOST."/template/error.php?msg=".urlencode("请填写密码"));
  exit;
}
if(!$_POST['password2']){
  header("Location: ".HOST."/template/error.php?msg=".urlencode("请确认密码"));
  exit;
}
if($_POST['password2']!=$_POST['password']){
  header("Location: ".HOST."/template/error.php?msg=".urlencode("密码不一致"));
  exit;
}
if(!$_POST['check']){
  header("Location: ".HOST."/template/error.php?msg=".urlencode("请同意用户协议"));
  exit;
}

$arr['nickname'] = addslashes($_POST['nickname']);
$arr['email'] = addslashes($_POST['email']);

//search for overlap
$table = 'player_table';
$start = connect();
$sql = 'select nickname from player_table';
$result = fetchAll($sql, $start);
foreach($result as $key => $val){
  $namelist[] = $val['nickname'];
}
if (in_array($_POST['nickname'], $namelist)){
  header("Location: ".HOST."/template/error.php?msg=".urlencode("昵称已存在"));
  exit;
}


//password enrc
$arr['password'] = passwordCrypt($_POST['password']);

$arr['token'] = passwordCrypt($time.$arr['nickname'].'this is a rendom char!');
$arr['login_time'] = $time;

// var_dump($arr);

$sql = insert($table, $arr, $start);
$_SESSION['logged'] = true;

$sql = 'select NUM from player_table where nickname = "'.$arr['nickname'].'"';
$result = fetchOne($sql, $start);

setcookie('token',$arr['token'],$cookieExpTime, '/');
setcookie('num',$result['NUM'],$cookieExpTime, '/');

logToDatabase($start, $result['NUM'], 'signup', 'none');

header("Location: ".HOST);



