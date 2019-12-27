<?php


//将不安全连接转为安全连接（替换http为https）
function change_to_https($str){
	$httpchange = array("http://"=>"https://");
	return strtr($str, $httpchange);
}


//生成唯一字符串
function getUniName(){
    return md5(uniqid(microtime(true), true));
}


//得到文件的文件类型（文件后缀）
function getExt($filename){
    return strtolower(end(explode(".", $filename)));
}


//处理图片上传
function imageupload($fileinfo, $destination, $maxsize = 2097152, $imgflag = true){
    
    $filename = $fileinfo['name'];
    $type = $fileinfo['type'];
    $tmp_name = $fileinfo['tmp_name'];
    $error = $fileinfo['error'];
    $size = $fileinfo['size'];
    $allowExt = array('gif','jpeg','jpg','bmp','png');

    if ($error == 0){
        $Ext = getExt($filename);
        //限制上传文件类型
        if (!in_array($Ext, $allowExt)){
            $msg = "文件类型不符合，上传的文件类型：" . $Ext;
            alert($msg);
        }
        if ($size>$maxsize){
            $msg = "文件过大，已上传文件大小：".$size;
            alert($msg);
        }
        if ($imgflag){
            $info = getimagesize($tmp_name);
            if (!$info){
                alert("文件错误");
            }
        }
        $filename = getUniName().".".$Ext;
        $destination=$destination.$filename;
        if(is_uploaded_file($tmp_name)){
            if(move_uploaded_file($tmp_name, $destination)){
                //echo"成功";
                //$UploadedFilePath = $filename . '<>' . $destination . '<>' . $tmp_name;
                $imginfo = [];
                $dotchange = array("../"=>"./");
	            $imginfo[src] = strtr($destination, $dotchange);
	            $imginfo[detail] = $info;
                return $imginfo;
            }else{
                alert("文件移动失败");
            }
        }
    }else{
        switch($error){
            case 1:
                alert("超过了配置文件上传文件的大小");
            case 2:
                alert("超过了表单设置上传文件的大小");
            case 3:
                alert("文件未被上传完毕");
            case 4:
                alert("没有文件被上传");
            case 6:
                alert("没有找到临时目录");
            case 7:
                alert("文件路径不可写");
            case 8:
                alert("由于php扩展程序导致上传被中断");
        }
    }
}


//获取当前url
function php_self(){
	if ($_SERVER["QUERY_STRING"]){
		return $_SERVER['PHP_SELF'].'?'.$_SERVER["QUERY_STRING"];
	}else{
		return $_SERVER['PHP_SELF'];
	}
}


//发邮件(旧的方法，by PHPmailer，后来下面的方法又坏了，发件邮箱改为了QQ邮箱，又改回了原来的这个方法)
function email($to, $subject, $body, $altbody = ''){
	require_once 'email/class.phpmailer.php';
	require_once 'email/class.smtp.php';

	if (!isset($mail)){
		$mail = new PHPMailer;
	}

	$mail->SetLanguage('zh_cn', 'php/email/language/');
  $mail->IsSMTP(true);                // 经smtp发送
  $mail->Host = "smtp.qq.com"; // SMTP 服务器
  $mail->Port = 465;              // SMTP 端口
  $mail->SMTPSecure = 'ssl';      // 加密方式
  $mail->SMTPAuth = true;         // 打开SMTP认证
  $mail->Username = EMAILUSERNAME;   // 用户名
  $mail->Password = EMAILPASSWORD;   // 密码
  $mail->CharSet = "utf-8";   // charset
  $mail->Encoding = "base64";   // encoding

	$mail->From = EMAILADDRESS;
	$mail->FromName = 'TaikoMap';
	$mail->AddAddress($to);               // Name is optional

	$mail->WordWrap = 0;                                 // Set word wrap to 50 characters
	$mail->AddAttachment('');         // Add attachments
	$mail->AddAttachment('', '');    // Optional name
	$mail->IsHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $body;
	$mail->AltBody = $altbody;

	if(!$mail->Send()) {
		$msg = 'Mailer Error: '.$mail->ErrorInfo;
		echo $msg;
		return false;
	}else{
    return true;
  }
}

//发邮件(新的方法，by fdipzone in http://bbs.csdn.net/topics/392080616)
function email_broken($receiver, $subject, $content, $NoUseParm='', $ishtml=true, $attachments=array()) {  
	//***erased***
  wrong('general-0x0000012-abandedEmailFunc-email_broken');
}

//从76073238@qq.com发邮件
function email7689($to, $subject, $body, $altbody){
	//***erased***
  wrong('general-0x0000012-abandedEmailFunc-email7689');
}


//将时间戳转化为容易阅读的xx秒/xx分/xx小时/xx天/xx月/xx年前的格式,大于等于$limit秒的间隔会直接显示为$fomat格式
function timestamp_readable_output($timestamp, $timenow, $limit=2592000, $fomat="Y-m-d"){
    $gap = $timenow - $timestamp;
    if($limit){
        if($gap >= $limit){
            $gap = date($fomat, $timestamp);
            return $gap;
        }
    }
    if($gap < 60){
        return $gap.'秒前';
    }else if($gap < 3600){
        $gap = ( $gap - $gap % 60 ) / 60;
        return $gap.'分钟前';
    }else if($gap < 86400){
        $gap = ( $gap - $gap % 3600 ) / 3600;
        return $gap.'小时前';
    }else if($gap < 2592000){
        $gap = ( $gap - $gap % 86400 ) / 86400;
        return $gap.'天前';
    }else if($gap < 31536000){
        $gap = ( $gap - $gap % 2592000 ) / 2592000;
        return $gap.'个月前';
    }else{
        $gap = ( $gap - $gap % 31536000 ) / 31536000;
        return $gap.'年前';
    }
}
//将时间戳转化为容易阅读的xx天xx小时前的格式
function timestamp_readable_output_day($timestamp, $timenow){
    $gap = $timenow - $timestamp;
    $gapSub = $timenow - $timestamp;
    $gap = ( $gap - $gap % 86400 ) / 86400;
    $gapSub = $gapSub%86400;
    $gapSub = ($gapSub-$gapSub%3600)/3600;
    if (!$gap){
        return $gapSub.'小时前';
    }
    return $gap.'天'.$gapSub.'小时前';
}

//bcrypt加密
function passwordCrypt($str){
    return password_hash($str,PASSWORD_BCRYPT);
}

//bcrypt验证
function passwordVerify($input, $hash){
    if (hash_equals($hash, crypt($input, $hash))) {
        return true;
    }else{
        return false;
    }
}

//get class list
function getClassList(){
  return ['j-pop','anime','vocaloid','doyo','vari','classic','game','namico'];
}

//create nav
function createNav($city='', $city_link='', $gamecenter='', $gamecenter_link='', $others=''){
  $returnHtml = '
<div class="nav">
  <p class="nav-top"><a class="href-text-nomal" href="/">TaikoMap - 太鼓地图</a></p>
  <div class="nav-bottom">
    <p><a href="/"><span>主页</span></a>';
  
  if($city){
    if($city_link){
      $returnHtml .= '<a href="' . $city_link . '"><span>' . $city . '</span></a>';
    }else{
      $returnHtml .= '<a href="#"><span>' . $city . '</span></a>';
    }
  }
  if($gamecenter){
    if($gamecenter_link){
      $returnHtml .= '<a href="' . $gamecenter_link . '"><span>' . $gamecenter . '</span></a>';
    }else{
      $returnHtml .= '<a href="#"><span>' . $gamecenter . '</span></a>';
    }
  }
  
  if($others){
    $returnHtml .= '<a href="#"><span>' . $others . '</span></a>';
  }
  
  $returnHtml .= '</p>
  </div>
</div>
<div id="nav-btn" class="nav-btn href showUntil-M">
  <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
</div>';

  return $returnHtml;
}

//create GC box element
function createGC(array $gamecenterInfo, array $drumList = []){
  
  $returnHtml = '
  <div class="col-xs-12 col-sm-6 col-lg-4 map-drum-list">
    <a href="/gamecenter/' . $gamecenterInfo['NUM'] . '" class="list-border href-nounderline">';
  
  if(isset($gamecenterInfo['best_drum'])){
    if(sizeof($drumList)<1){
      $sql_1 = "select * from drum where NUM = '".$gamecenterInfo['best_drum']."'";
      $mysqli = connect();
      $drum = fetchOne($sql_1, $mysqli);
    }else{
      $drumNum = array_column($drumList, 'NUM');
      $drum = $drumList[array_keys($drumNum, $gamecenterInfo['best_drum'])[0]];
    }
    $drum = frameClassToDrum($drum);
    $time = time();
    $drum['last_action'] = handleLastAction($gamecenterInfo, $time);
    
    $drumface = judgedrum($drum);
    
    $returnHtml .= '
      <div class="list ' . $drum['frame_class'] . '">
        <div class="drumbox">
          <div class="map-drum-right">
            <span class="drum drumbg"></span>
            <span class="drum x-l ' . $drumface['2p']['x-l'] . '"></span>
            <span class="drum x-r ' . $drumface['2p']['x-r'] . '"></span>
            <span class="drum o-l ' . $drumface['2p']['o-l'] . '"></span>
            <span class="drum o-r ' . $drumface['2p']['o-r'] . '"></span>
          </div>
          <div class="map-drum-left">
            <span class="drum drumbg"></span>
            <span class="drum x-l ' . $drumface['1p']['x-l'] . '"></span>
            <span class="drum x-r ' . $drumface['1p']['x-r'] . '"></span>
            <span class="drum o-l ' . $drumface['1p']['o-l'] . '"></span>
            <span class="drum o-r ' . $drumface['1p']['o-r'] . '"></span>
          </div>
          <span class="volume-l glyphicon glyphicon-volume-' . $drum['1p_audio_class'] . '" aria-hidden="true"></span>
          <span class="volume-r glyphicon glyphicon-volume-' . $drum['2p_audio_class'] . '" aria-hidden="true"></span>
          <div class="drum-screen ' . $drum['screen'] . '"></div>
        </div>';
  }else{
    $drum['coinPerTrack'] = '<i>尚未添加框体</i>';
    $drum['frame_class'] = 'vari';
    $drum['last_action'] = '';
    $drum['comm'] = '';
    $returnHtml .= '
    <div class="list ' . $drum['frame_class'] . '">';
  }
  $returnHtml .= '
      <p><strong>' . $gamecenterInfo['city'] . '' . $gamecenterInfo['area'] . ' - ' . $gamecenterInfo['place'] . '</strong></p>
        <p>' . $gamecenterInfo['name'] . ' ' . $drum['coinPerTrack'] . '</p>
        <p>云打卡' . $gamecenterInfo['cloud_card'] . ' / 出勤' . $gamecenterInfo['card'] . '</p>
        <p>' . $drum['last_action'] . '</p>
        <!--<p><i>' . $gamecenterInfo['info'] . '</i></p>
        <p><i>' . $drum['comm'] . '</i></p>-->
      </div>
    </a>
  </div>';

  return $returnHtml;
}

// handle drum judgement
function judgedrum($drum_database_array){
  $result = [];
  $result['1p']['x-l'] = $drum_database_array['overall_cond_1p'];
  $result['1p']['x-r'] = $drum_database_array['overall_cond_1p'];
  $result['1p']['o-r'] = $drum_database_array['overall_cond_1p'];
  $result['1p']['o-l'] = $drum_database_array['overall_cond_1p'];
  
  $result['2p']['x-l'] = $drum_database_array['overall_cond_2p'];
  $result['2p']['x-r'] = $drum_database_array['overall_cond_2p'];
  $result['2p']['o-r'] = $drum_database_array['overall_cond_2p'];
  $result['2p']['o-l'] = $drum_database_array['overall_cond_2p'];
  
  if ($drum_database_array['1p_x_l']){
    $result['1p']['x-l'] = $drum_database_array['1p_x_l'];
  }
  if ($drum_database_array['1p_x_r']){
    $result['1p']['x-r'] = $drum_database_array['1p_x_r'];
  }
  if ($drum_database_array['1p_o_l']){
    $result['1p']['o-l'] = $drum_database_array['1p_o_l'];
  }
  if ($drum_database_array['1p_o_r']){
    $result['1p']['o-r'] = $drum_database_array['1p_o_r'];
  }
  
  if ($drum_database_array['2p_x_l']){
    $result['2p']['x-l'] = $drum_database_array['2p_x_l'];
  }
  if ($drum_database_array['2p_x_r']){
    $result['2p']['x-r'] = $drum_database_array['2p_x_r'];
  }
  if ($drum_database_array['2p_o_l']){
    $result['2p']['o-l'] = $drum_database_array['2p_o_l'];
  }
  if ($drum_database_array['2p_o_r']){
    $result['2p']['o-r'] = $drum_database_array['2p_o_r'];
  }
  
  return $result;
}

//handle score trans
function textToScore($text){
  switch($text){
    case 'gold':
      return 10;
    break;
    case 'good':
      return 8;
    break;
    case 'good-':
      return 6;
    break;
    case 'nom':
      return 4;
    break;
    case 'nom-':
      return 2;
    break;
    case 'bad':
      return 0;
    break;
    default: return ' ';
  }
}
//handle score de_trans
function scoreToText($score){
  switch($score){
    case 10:
      return 'gold';
    break;
    case  8:
      return 'good';
    break;
    case 6:
      return 'good-';
    break;
    case 4:
      return 'nom';
    break;
    case 2:
      return 'nom-';
    break;
    case 0:
      return 'bad';
    break;
    default: return ' ';
  }
}
//handle screen trans
function screenToNum($text){
  switch($text){
    case 'nom': return 1; break;
    case 'c-y': return 2; break;
    case 'c-b': return 3; break;
    case 'c-p': return 4; break;
    case 'streched': return 5; break;
    case 'un-contrast': return 6; break;
    case 'cut': return 7; break;
    case 'bright': return 8; break;
    case 'dark': return 9; break;
    case 'blur': return 10; break;
    case 'hor-w': return 11; break;
    case 'hor-b': return 12; break;
    case 'ver-w': return 13; break;
    case 'ver-b': return 14; break;
  }
}

//handle drum frame class

//frame_class: class of theme color
//version: final version

//1p_audio: class of audio-L condition
//2p_audio: class of audio-R condition
//audio_desc: describe of audio_cond

//screen_exp: describe of screen_cond

//coinPerTrack: coin cost per game
//version_text: [version] added [coinPerTrack]
function frameClassToDrum($drum){
  if ($drum['os_changed']){
    $drum['version'] = $drum['os_version'];
  }else{
    $drum['version'] = $drum['frame_version'];
  }
    switch($drum['version']){
      case '12亚': $drum['frame_class'] = "j-pop"; break;
      case '12日': $drum['frame_class'] = "j-pop"; break;
      case '12': $drum['frame_class'] = "j-pop"; break;
      case '11亚': $drum['frame_class'] = "anime"; break;
      case '11日': $drum['frame_class'] = "anime"; break;
      case '11': $drum['frame_class'] = "anime"; break;
      case '14': $drum['frame_class'] = "doyo"; break;
      case '14+': $drum['frame_class'] = "doyo"; break;
      case '14（+）': $drum['frame_class'] = "doyo"; break;
      case '14(+)': $drum['frame_class'] = "doyo"; break;
      case '14日': $drum['frame_class'] = "doyo"; break;
      case '14增': $drum['frame_class'] = "doyo"; break;
      case '新框': $drum['frame_class'] = "namico"; break;
      case '海外版新框': $drum['frame_class'] = "namico"; break;
      case '绿版': $drum['frame_class'] = "namico"; break;
      case '蓝版': $drum['frame_class'] = "namico"; break;
      default : $drum['frame_class'] = "vari";
    }
  
  $drum['audio_desc'] = '音响：1p音量';
  switch($drum['1p_audio']){
		case '0':
    $drum['1p_audio_class'] = "off";
    $drum['audio_desc'] .= '静音';
    break;
		case '2':
    $drum['1p_audio_class'] = "down";
    $drum['audio_desc'] .= '小';
    break;
		case '4':
    $drum['1p_audio_class'] = "up";
    $drum['audio_desc'] .= '中';
    break;
		case '6':
    $drum['1p_audio_class'] = "up vol-gold";
    $drum['audio_desc'] .= '大';
    break;
    default : 
    $drum['1p_audio_class'] = "none";
    $drum['audio_desc'] .= '暂无信息';
	}
  $drum['audio_desc'] .= ' 2p音量';
  switch($drum['2p_audio']){
		case '0':
    $drum['2p_audio_class'] = "off";
    $drum['audio_desc'] .= '静音';
    break;
		case '2':
    $drum['2p_audio_class'] = "down";
    $drum['audio_desc'] .= '小';
    break;
		case '4':
    $drum['2p_audio_class'] = "up";
    $drum['audio_desc'] .= '中';
    break;
		case '6':
    $drum['2p_audio_class'] = "up vol-gold";
    $drum['audio_desc'] .= '大';
    break;
    default : 
    $drum['2p_audio_class'] = "none";
    $drum['audio_desc'] .= '暂无信息';
  }
  
  if (!$drum['coin']){
    $drum['coin'] = '?';
  }
  if (!$drum['track_no']){
    $drum['track_no'] = '?';
  }
  
  switch($drum['screen']){
		case 'nom': $drum['screen_exp'] = "屏幕正常"; break;
		case 'c-y': $drum['screen_exp'] = "屏幕偏色：色彩显示不准，向黄色偏移"; break;
		case 'c-b': $drum['screen_exp'] = "屏幕偏色：色彩显示不准，向青色偏移"; break;
		case 'c-p': $drum['screen_exp'] = "屏幕偏色：色彩显示不准，向紫色偏移"; break;
		case 'streched': $drum['screen_exp'] = "屏幕拉伸：屏幕被横向拉伸"; break;
		case 'un-contrast': $drum['screen_exp'] = "对比度低：屏幕对比度降低"; break;
		case 'cut': $drum['screen_exp'] = "分割屏：偶发或持续性的屏幕分割、不同步"; break;
		case 'bright': $drum['screen_exp'] = "屏幕过白：屏幕泛白或亮度过高"; break;
		case 'dark': $drum['screen_exp'] = "屏幕过暗：屏幕泛黑或亮度不足"; break;
		case 'hor-w': $drum['screen_exp'] = "横条闪烁：屏幕闪烁横条"; break;
		case 'hor-b': $drum['screen_exp'] = "横条闪烁：屏幕闪烁横条"; break;
		case 'ver-w': $drum['screen_exp'] = "竖条闪烁：屏幕闪烁竖条"; break;
		case 'ver-b': $drum['screen_exp'] = "竖条闪烁：屏幕闪烁竖条"; break;
		case 'blur': $drum['screen_exp'] = "屏幕模糊：会不会是撸多了？"; break;
		case 'big': $drum['screen_exp'] = "屏幕显示不全"; break;
    default : $drum['screen_exp'] = "无屏幕信息";
	}
  
  if ($drum['NUM']){
    $drum['version_text'] = $drum['version']." ".$drum['coin'].'币'.$drum['track_no'].'曲';
    $drum['coinPerTrack'] = $drum['coin'].'币'.$drum['track_no'].'曲';
  }else{
    $drum['version_text'] = '未添加框体';
    $drum['coinPerTrack'] = '';
  }
  
  return $drum;
}

//last_action: readable last action
function handleLastAction($val, $time){
  if ($val['lastchangeTime']){
    $lastAction = timestamp_readable_output($val['lastchangeTime'], $time, 0);
    if ($val['lastchangeType']=="card"){
      $lastAction .= '有Donder出勤';
    }else if($val['lastchangeType']=="add"){
      $lastAction .= ' / 添加框体';
    }else if($val['lastchangeType']=="mod"){
      $lastAction .= ' / 框体信息修改';
    }else if($val['lastchangeType']=="addGC"){
      $lastAction .= ' / 被添加';
    }else if($val['lastchangeType']=="modGC"){
      $lastAction .= ' / 机厅信息修改';
    }
  }else{
    $lastAction = '暂无活动记录';
  }
  
  return $lastAction;
}

/* 用于根据指定字段排序二维数组，保留原有键值
 * $array array 输入二维数组
 * $sortField string 要排序的字段名
 * $sortBy string 要排序的方式(ASC|DESC)
 * return array
 * author www.phpernote.com
 */
function array_multisort_my($array,$sortField,$sortBy='ASC',$limit='0'){
	$result=array();
	foreach($array as $k=>$v){
		$result[$k]=$v[$sortField];
	}
	$sortBy=strtoupper($sortBy);
	$sortBy=='ASC'?asort($result):($sortBy=='DESC'?arsort($result):'');
	foreach($result as $k=>$v){
		$result[$k]=$array[$k];
	}
  if ($limit){
    $result = array_chunk($result, $limit)[0];
  }
	return $result;
}

//update player action
function recordAddToPlayer($num, $action, $mysqli, $i = '1'){
  $sql = "UPDATE player_table SET ".$action."=".$action."+".$i." WHERE NUM='".$num."'";
  // echo $sql;
  $mysqli->query($sql);
}