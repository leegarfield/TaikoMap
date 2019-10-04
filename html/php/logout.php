<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

require_once ('../include.php');

session_start();

session_destroy();
setcookie('token', '', $timecheck, '/');
setcookie('num', '', $timecheck, '/');

header("Location: ".HOST);