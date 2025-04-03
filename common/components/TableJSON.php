<?php


namespace common\components;
/**
 * Description of TableJSON
 *
 * @author OneLab
 */
class TableJSON {
    public function init(){
        
    }
    public function TableToJSON($htmlTable){
        //include("simple_html_dom.php");
        //$html = file_get_html('index.html');
        $html=$htmlTable;
        $row_count=0;
        $json = array();
        foreach ($html->find('tr') as $row) {
                $currency = $row->find('td',0)->innertext;
                $sell = $row->find('td',1)->innertext;
                $buy = $row->find('td',2)->innertext;
                $json[$currency][$sell][$buy]=true;
        }
        echo json_encode($json);
    }
}
