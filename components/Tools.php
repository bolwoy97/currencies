<?php

class Tools
{
    public static function getCurrencies($days_ago_url)
    {
      //http://www.cbr.ru/scripts/XML_daily.asp?date_req=$days_ago_url
      $curl = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$days_ago_url";
      $currencies = simplexml_load_file ($curl);
      return  $currencies;
    } 

}