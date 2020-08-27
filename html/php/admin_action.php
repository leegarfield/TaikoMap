<?php
//debug信息输出
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

$time = time();
require_once ('../include.php');

//login check
$acc = logincheck();

//admin check
if(isset($acc['token'])&$acc['info_is_admin']){

    // var_dump($_GET['a']);
    
    switch($_GET['a']){
        case 'regen_html':
        require_once ('template.php');
        //update citylist;
        $pageOp = new PageOpreate;
        $pageOp->updateAll();
    }
    
    header("Location: ".HOST);

}else{
    header("Location: ".HOST."/error/404.html");
    exit;
}