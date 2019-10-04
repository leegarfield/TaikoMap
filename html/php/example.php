<?php
require_once ('../include.php');
session_start();

$start = connect();

/*
这个页面仅用来批量处理用户数据
*/

//处理用户rec_tick、rec_cloud_tick、rec_change记录
if(isset($_COOKIE['num'])){
    $acc = logincheck();
    $user = $acc['NUM'];
    if($user == 100){

        //设定action
        $action = "editDrum' || type='addDrum";
        $rec_action = 'rec_change';
        $playerlist = [];

        //现有记录清零
        // $sql = 'update player_table set '.$rec_action.' = 0 where NUM > 99';
        // echo $sql;
        // mysql_query($sql);

        //构建sql语句
        $sql = "SELECT * FROM taiko_map.log where type = '".$action."'";
        echo $sql;
        $result = fetchAll($sql,$start);

        foreach($result as $key => $val){
            print_r($val);
            echo '<br />';
            
            $explodeResult = explode('%', $val['log_long']);
            $finaloutput = '';

            for ($i=0; $i<10; $i++){
                $endstr = substr($finaloutput, -1);
                if ($i==0){
                    $str = $explodeResult[0];
                }else if($i==2 && $endstr == '/'){
                    $finaloutput = substr($finaloutput, 0, -1);
                    $finaloutput .= '%';
                    $str = $explodeResult[1];
                }
                
                if(substr($str, 0, 2) == '10'){
                    $finaloutput .= 'gold/';
                    $str = substr($str, 2);
                }else if(substr($str, 0, 1) == '8'){
                    $finaloutput .= 'good/';
                    $str = substr($str, 1);
                }else if(substr($str, 0, 1) == '6'){
                    $finaloutput .= 'good-/';
                    $str = substr($str, 1);
                }else if(substr($str, 0, 1) == '4'){
                    $finaloutput .= 'nom/';
                    $str = substr($str, 1);
                }else if(substr($str, 0, 1) == '2'){
                    $finaloutput .= 'nom-/';
                    $str = substr($str, 1);
                }else if(substr($str, 0, 1) === '0'){
                    $finaloutput .= 'bad/';
                    $str = substr($str, 1);
                }else if(substr($str, 0, 1) == ' '){
                    $finaloutput .= ' ';
                }
            }

            $endstr = substr($finaloutput, -1);
            if($endstr == '/'){
                $finaloutput = substr($finaloutput, 0, -1);
            }
            $finaloutput .= '%';

            $finaloutput .= $explodeResult[2][0] . '/' . $explodeResult[2][1] . '%';

            $finaloutput .= $explodeResult[3] . '%';
            $finaloutput .= $explodeResult[4] . '%';
            $finaloutput .= $explodeResult[5] . '%';
            $finaloutput .= $explodeResult[6];

            echo $finaloutput.'<br />';

            $sql = 'update log set log_long = "'.$finaloutput.'" where NUM = "'.$val['NUM'].'"';
            $start->query($sql);
        }
    }
}



echo "<pre>get:<br />";
var_dump($_GET);
echo "<br />post:<br />";
var_dump($_POST);
echo "<br />session:<br />";
var_dump($_SESSION);
echo "<br />cookie:<br />";
var_dump($_COOKIE);