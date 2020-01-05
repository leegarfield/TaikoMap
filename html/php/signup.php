<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

require_once ('../include.php');
session_start();
$time = time();
$cookieExpTime = $time + 2678400;

// var_dump($_POST);

//mode selection
if(isset($_POST['email_addr'])){
  //send verlify email and store all shit into session
  if(!$_POST['nickname']){
    echo("请填写昵称");
    exit;
  }
  if(!$_POST['password']){
    echo("请填写密码");
    exit;
  }
  if(!$_POST['password2']){
    echo("请确认密码");
    exit;
  }
  if(!$_POST['email_addr']){
    echo("请输入邮箱");
    exit;
  }
  if($_POST['password2']!=$_POST['password']){
    echo("密码不一致");
    exit;
  }
  if($_POST['check']!='true'){
    echo("请同意用户协议");
    exit;
  }
  
  $arr['nickname'] = addslashes($_POST['nickname']);
  $arr['email'] = addslashes($_POST['email_addr']);
  
  //prevent overlap
  $table = 'player_table';
  $start = connect();
  $sql = 'select nickname, email from player_table';
  $result = fetchAll($sql, $start);
  foreach($result as $key => $val){
    $namelist[] = $val['nickname'];
    $emaillist[] = $val['email'];
  }
  if (in_array($_POST['nickname'], $namelist)){
    echo("昵称已存在");
    exit;
  }
  if (in_array($_POST['email_addr'], $emaillist)){
    echo("请换个邮箱");
    exit;
  }
  
  
  //password enrc
  $arr['password'] = passwordCrypt($_POST['password']);
  
  $arr['token'] = passwordCrypt($time.$arr['nickname'].'this is a rendom char!');
  $arr['login_time'] = $time;
  
  //store all the shit into session
  $_SESSION['arr'] = $arr;

  //send mail

  //generate code
  $code['f'] = rand(1000,9999);
  $code['e'] = rand(1000,9999);
  $code['n'] = $code['f'].  $code['e'];
  //store code into session
  $_SESSION['verlify'] = $code['n'];
  //prevent spam
  if(isset($_SESSION['email_send_time']) && $time - $_SESSION['email_send_time'] <= 120){
    $timespace = 120 - $time + $_SESSION['email_send_time'];
    echo("请等待". $timespace ."秒再次发送，若未找到邮件，请尝试检查邮件垃圾箱");
    exit;
  }else{
    $_SESSION['email_send_time'] = $time;
  }
  //mail construt
  $to = $arr['email'];
  $subject = "TaikoMap太鼓地图注册邮箱验证";
  $body = '
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
您申请在TaikMap太鼓地图（<a href="https://taikomap.cn">https://taikomap.cn</a>）注册<br />
您的校验码是：
<pre style="white-space: pre-wrap;word-wrap: break-word;background-color: #eee;padding:10px;">'.$code['n'].'</pre><br />
如果您并未在TaikMap太鼓地图申请注册，请忽略此邮件<br /><br />
<p style="text-align: right;">TaikoMap太鼓地图</p>
<p style="text-align: right;">'.date('y年m月d日',time()).'</p>
</html>';
  email($to, $subject, $body, $altbody = '');
  
  echo "success";
  // echo $code['f']. ' '.  $code['e'] . ' [' .  $code['n'] . '] time: ' . $_SESSION['email_send_time'];

}else if(isset($_POST['token'])){
  //check token
  if($_POST['token'] == $_SESSION['verlify']){
    //nomarl signup setup
    $start = connect();
    $arr = $_SESSION['arr'];
  
    //insert into sql
    $sql = insert('player_table', $arr, $start);
    
    $sql = 'select NUM from player_table where nickname = "'.$arr['nickname'].'"';
    $result = fetchOne($sql, $start);
    
    //set cookie & session
    setcookie('token',$arr['token'],$cookieExpTime, '/');
    setcookie('num',$result['NUM'],$cookieExpTime, '/');
    $_SESSION['checked'] = true;
    $_SESSION['logged'] = true;
    $_SESSION['verlify'] = null;
    $_SESSION['arr'] = null;
    
    //log
    logToDatabase($start, $result['NUM'], 'signup', '', '', '', '【'.$arr['nickname'].'】-ip：【'.$_SERVER['REMOTE_ADDR'].'】');
    //return
    echo 'success';
    
  }else{
    echo "校验码错误";
  }

}else{
  echo("请输入邮箱");
  exit;
}
