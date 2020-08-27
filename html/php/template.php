<?php
// a php to deal with all template update quest
// ini_set("display_errors", "On");
// error_reporting(E_ALL | E_STRICT);


// require_once ('php/general.php');

class PageOpreate{
    private $templatePath;
    private $content;

    public function construst(){
        $this->templatePath = TEMPLATEPATH;
        $this->content = '';
    }

    private function pageSave($content, $target){
        $target = $this->templatePath . $target;
        $content .= TEMPLATEPATH;
        file_put_contents(TEMPLATEPATH .'citylist.html', $content);
    }
    
    // update city list
    public function updateCityList(){
        require_once (PATH.'/php/Character.php');
        $mysqli = connect();
        $sql = 'select * from gamecenter';
        $result = fetchAll($sql, $mysqli);
        $citylist['unOrdered'] = [];
        
        foreach($result as $val){
            if(!in_array($val['city'], $citylist['unOrdered'])){
                $citylist['unOrdered'][] = $val['city'];
            }
        }
        $citylist['Ordered'] = (new Character)->groupByInitials_s($citylist['unOrdered']);

        $this->content = '';
        foreach($citylist['Ordered'] as $key => $val){
            $this->content .= '<span><strong>' . $key . '</strong> ';
            foreach ($val as $key2 => $val2){
                $this->content .= '<a href="/map/' . urlencode($val2[0]) . '">'.$val2[0].'</a> ';
            }
            $this->content .= '</span>';
        }
        
        $this->pageSave($this->content, 'citylist.html');
    }
    
    //update all page
    public function updateAll(){
        $this->updateCityList();
    }
}