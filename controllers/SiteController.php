<?php

class SiteController
{

    public function actionIndex()
    { 
        $cur_date = date("Y-m-d");
        $days_ago =array();
        for ($i=0; $i < 30; $i++){         
            $days_ago[] = date('Y-m-d', strtotime("-$i days", strtotime($cur_date)));
        }
        require_once(ROOT.'/views/site/index.php');
        return true;
    }

    public function actionTable()
    {        
        
            $date = (isset($_POST['date'])||$_POST['date']!=null)?$_POST['date']:date("Y-m-d");
            //echo $date;exit;
            $currencies = Currency::get(strtotime($date));
            if(empty($currencies)){
                
                $days_ago = date('Y-m-d', strtotime($date));
                $days_ago_url = date('d/m/Y', strtotime($date));
                $currenciesList = Tools::getCurrencies($days_ago_url);
                if($currenciesList){
                    $insert = "";
                    foreach($currenciesList as $cur){
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
            }
            require_once(ROOT.'/views/layouts/table.php');
            return true;
       
    }


}
