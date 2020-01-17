<?php

// copy this file to /html/config/configures.php

//调试开关
//this do nothing
define("OVERALL_DEBUG", false);

//database相关
//change this to connect to database
define('DBHOST','localhost:3306');
define('DBUSER','username');
define('DBPWD','password');
define('DBDBNAME','TaikoMap');

//环境相关
// change this to the location of the errorlog file
define('ERROR_LOG','Location/TaikoMap/html/logs/error_log.txt');
// change this to the location of the template folder
define('TEMPLATEPATH','Location/TaikoMap/html/template/');
// change this to the location of the html folder
define('PATH','Location/TaikoMap/html/');
// change this to localhost if debug
define('HOST','http://taikomap.cn');
// define('HOST','http://localhost');

//email
define('EMAILUSERNAME', 'abc@mail.com');
define('EMAILPASSWORD', 'password');
define('EMAILADDRESS', 'abc@mail.com');
