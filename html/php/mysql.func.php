<?php

function connect(){
    $mysqli = new mysqli(DBHOST,DBUSER,DBPWD);
    if ($mysqli->connect_errno) {
        die("could not connect to the database:\n" . $mysqli->connect_error);//诊断连接错误
    }
    $mysqli->query("set names 'utf8';");
    mysqli_select_db($mysqli, DBDBNAME) or die('打开数据库失败');
    return $mysqli;
}

function insert($table, $array, $mysqli){
    $keys=join(',',array_keys($array));
    $vals="'".join("','",array_values($array))."'";
    $sql="insert {$table} ($keys) values({$vals})";
    $mysqli->query($sql);
    return true;
}

function update($table,$array, $mysqli, $where=null){
    $str = null;
    foreach($array as $key=>$val){
        if($str==null){
            $sep='';
        }else{
            $sep=',';
        }
        $str=$str.$sep.$key."='".$val."'";
    }
    $sql="update {$table} set {$str}".($where==null?null:" where $where");
    // echo $sql;
    $mysqli->query($sql);
    $result[]=$sql;
    return true;
}

function delete($table,$where=null){
    $where=$where==null?null:' where '.$where;
    $sql='delete from {$table}{$where}';
    $mysqli->query($sql);
    return true;
}

function fetchOne($sql, $mysqli, $result_type=MYSQL_ASSOC){
    $result = $mysqli->query($sql);
    $row = $result -> fetch_assoc();
    return $row;
}

function fetchAll($sql, $mysqli, $result_type=MYSQL_ASSOC){
    $result = $mysqli -> query($sql);
    while($row = $result -> fetch_assoc()){
        $rows[] = $row;
    }
    return $rows;
}

//数据库处理封装函数，失败则返回false并报错，$sql 接受sql语句
function sqlaction($sql, $mysqli){
    if ($mysqli->query($sql)){
        return true;
    }else{
        wrong($sql);
    }
}


//verlify token_get_all
function logincheck($blackListCheck = false){
  if(isset($_COOKIE['token'])){
    $timecheck = time();
    
    $table = 'player_table';
    $mysqli = connect();
    $sql = 'select * from player_table where token = "'.$_COOKIE['token'].'"';
    if ($result = fetchOne($sql, $mysqli)){
      if ($timecheck - $result['login_time'] <= 2678400){
        if($blackListCheck){
            if($result['info_is_black']){
                header("Location: ".HOST."/template/error.php?msg=".urlencode($result['nickname']."#".$result['NUM']."：您已被加入黑名单！"));
                exit;
            }
        }
        return $result;
      }
    }
    session_destroy();
    setcookie('token', '', $timecheck, '/');
    setcookie('num', '', $timecheck, '/');
    
    $result['ip'] = $_SERVER['REMOTE_ADDR'];
    return $result;
    
  }else{
    $result['ip'] = $_SERVER['REMOTE_ADDR'];
    return $result;
  }
}

//log
function logToDatabase($mysqli, $user, $type, $log1, $log2="", $log3="", $log_long=""){
  $logToDatabase['time'] = time();
  $logToDatabase['user'] = $user;
  $logToDatabase['type'] = $type;
  $logToDatabase['log'] = $log1;
  $logToDatabase['log2'] = $log2;
  $logToDatabase['log3'] = $log3;
  $logToDatabase['log_long'] = $log_long;
  
  $table="log";
  insert($table, $logToDatabase, $mysqli);
  
}