<?php

class SiteController
{

    public function actionIndex()
    {        
        $date = (isset($_POST['date']))?$_POST['date']:date("Y-m-d");
        $currencies = Currency::get(strtotime($date));
        if(empty($currencies)){
            $insert = "";
            $days_ago = date('Y-m-d', strtotime($date));
            $days_ago_url = date('d/m/Y', strtotime($date));
            $curl = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$days_ago_url";
            $currencies = simplexml_load_file ($curl);
            foreach($currencies as $cur){
                if(!Currency::checkExists($cur['ID'],strtotime($days_ago))){
                    $insert .= "('".$cur['ID']."',".$cur->NumCode.",'".$cur->CharCode."','".$cur->Name."',".str_replace(',','.',$cur->Value).",".strtotime($days_ago)."),"; 
                }
            }
            if($insert!=""){
                $insert = rtrim($insert, ",");
                $insert .= ";";
                Currency::multipleAdd($insert);
            }
            $currencies = Currency::get(strtotime($date));
        }
        if(isset($_POST['table'])){
            require_once(ROOT.'/views/layouts/table.php');
            return true;
        }
        $cur_date = date("Y-m-d");
        $days_ago =array();
        for ($i=0; $i < 30; $i++){         
            $days_ago[] = date('Y-m-d', strtotime("-$i days", strtotime($cur_date)));
        }
        require_once(ROOT.'/views/site/index.php');
        return true;
    }


}
