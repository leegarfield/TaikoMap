<?php
//debug信息输出
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);

$time = time();
require_once ('../include.php');

//login check
$acc = logincheck();

//admin check
adminCheck();

    switch($_GET['a']){
        case 'regen_html':
        require_once ('template.php');
        //update citylist;
        $pageOp = new PageOpreate;
        $pageOp->updateAll();
    }
    
    header("Location: ".HOST);
