<?php


class ToolsController
{
    public function actionFillCours()
    {
        $insert = "";
        $date = date("Y-m-d");
        for ($i=0; $i < 30; $i++){         
            $days_ago = date('Y-m-d', strtotime("-$i days", strtotime($date)));
            $days_ago_url = date('d/m/Y', strtotime("-$i days", strtotime($date)));
            $curl = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$days_ago_url";
            $currencies = simplexml_load_file ($curl);
            foreach($currencies as $cur){
                if(!Currency::checkExists($cur['ID'],strtotime($days_ago))){
                    //Currency::add($cur['ID'],$cur->NumCode,$cur->CharCode,$cur->Name,$cur->Value,strtotime($days_ago));
                    $insert .= "('".$cur['ID']."',".$cur->NumCode.",'".$cur->CharCode."','".$cur->Name."',".str_replace(',','.',$cur->Value).",".strtotime($days_ago)."),"; 
                }
            }
        }
        if($insert!=""){
            $insert = rtrim($insert, ",");
            $insert .= ";";
            Currency::multipleAdd($insert);
        }
        
        exit;
    }


    public function actionApi()
    {
        //worktest/api/get?id=R01010&from=2020-04-06&to=2020-04-08  
        $currencies = Currency::find($_GET['id'], strtotime($_GET['from']), strtotime($_GET['to']));
        header('Content-Type: application/json');
        echo json_encode($currencies)."\n";
        exit;
    }

}
