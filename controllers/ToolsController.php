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
            $currenciesList = Tools::getCurrencies($days_ago_url);
            if(!$currenciesList){
                echo 'Unable to load data for '.$days_ago_url.'<br>';
                continue;
            }
            foreach($currenciesList as $cur){
                if(!Currency::checkExists($cur['ID'],strtotime($days_ago))){
                    //Currency::add($cur['ID'],$cur->NumCode,$cur->CharCode,$cur->Name,$cur->Value,strtotime($days_ago));
                    $insert .= "('".$cur['ID']."',".$cur->NumCode.",'".$cur->CharCode."','".$cur->Name."',".str_replace(',','.',$cur->Value).",".strtotime($days_ago)."),"; 
                }
            }
            echo 'Uploaded data for '.$days_ago_url.'<br>';
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
        //$currencies = Currency::delete(strtotime($_GET['from']), strtotime($_GET['to']));
        $currencies = Currency::find($_GET['id'], strtotime($_GET['from']), strtotime($_GET['to']));
        $period = new DatePeriod(
            new DateTime($_GET['from']),
            new DateInterval('P1D'),
            new DateTime($_GET['to'])
        );
        $insert = "";
        
        foreach($period as $date){
            if(!array_search(strtotime($date->format('Y-m-d')), array_column($currencies, 'date'))){
                //echo ($date->format('Y-m-d')).'<br>';
                $date_url = date('d/m/Y', strtotime($date->format('Y-m-d')));
                $currenciesList = Tools::getCurrencies($date_url);
                if(!$currenciesList){
                    continue;
                }
                foreach($currenciesList as $cur){
                    $insert .= "('".$cur['ID']."',".$cur->NumCode.",'".$cur->CharCode."','".$cur->Name."',".str_replace(',','.',$cur->Value).",".strtotime($date->format('Y-m-d'))."),"; 
                    
                }
            }
        }
        if($insert!=""){
            $insert = rtrim($insert, ",");
            $insert .= ";";
            Currency::multipleAdd($insert);
            $currencies = Currency::find($_GET['id'], strtotime($_GET['from']), strtotime($_GET['to']));
        }
        header('Content-Type: application/json');
        if(!$currencies){
            echo json_encode(['error'=>'Service is unreachable now'])."\n";
            exit;
        }
        echo json_encode($currencies)."\n";
        exit;
    }

}
