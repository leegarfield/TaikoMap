<?php
//debug信息输出
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

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

$nickname = addslashes($_POST['nickname']);

//search for password
$table = 'player_table';
$mysqli = connect();
$sql = 'select NUM, password, login_time, token from player_table where nickname = "'.$nickname.'"';
$result = fetchOne($sql, $mysqli);
if (passwordVerify($_POST['password'], $result['password'], $mysqli)){
  
  //update token
  if ($time - $result['login_time'] <= 2678400){
    $arr['login_time'] = $time;
    setcookie('token',$result['token'],$cookieExpTime, '/');
  }else{
    $arr['token'] = passwordCrypt($time.$nickname.'this is a rendom char!');
    $arr['login_time'] = $time;
    setcookie('token',$arr['token'],$cookieExpTime, '/');
  }
  $where = 'nickname = "'.$nickname.'"';
  
  if($sql = update($table, $arr, $mysqli, $where)){
    
    logToDatabase($mysqli, $result['NUM'], 'login', 'none');
    
    $_SESSION['logged'] = true;
    setcookie('num',$result['NUM'],$cookieExpTime, '/');
    header("Location: ".HOST);
    // var_dump($_COOKIE);
    // var_dump($_SESSION);
  }else{
    header("Location: ".HOST."/template/error.php?msg=".urlencode("密码错误"));
    exit;
  }
  
}else{
  header("Location: ".HOST."/template/error.php?msg=".urlencode("密码错误"));
  exit;
}



