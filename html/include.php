<?php
session_start();
ini_set('date.timezone','Asia/Shanghai');
define('WRT', dirname(__FILE__));
// require_once ('config/configures.php');
require_once ('config/configures.php');
require_once ('php/mysql.func.php');
require_once ('php/general.php');
require_once ('php/Character.php');
require_once ('php/template.php');