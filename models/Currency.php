<?php

class Currency
{
    public static function add($valuteID,$numCode,$сharCode,$name,$value,$date)
    {
      //echo "VALUES ($valuteID, $numCode, $сharCode, $name, $value, $date)";exit;
        $db = Db::getConnection();
        $sql = 'INSERT INTO currency (valuteID,numCode,сharCode,name,value,date) '
                            ."VALUES (:valuteID ,:numCode , '$сharCode' ,:name ,:value ,:date)";
        $result = $db->prepare($sql);
        $result->bindParam(':valuteID', $valuteID, PDO::PARAM_STR);
        $result->bindParam(':numCode', $numCode, PDO::PARAM_STR);
        //$result->bindParam(':сharCode', $сharCode, PDO::PARAM_STR);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':value', $value, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        
        $success = $result->execute();
        if (!$success) {
          echo __LINE__ . ' DB error: ';
          var_dump($result->errorInfo());
          exit;
        }
        return  $success;
    } 

    public static function multipleAdd($insert)
    {
      //echo "VALUES ($valuteID, $numCode, $сharCode, $name, $value, $date)";exit;
        $db = Db::getConnection();
        $sql = 'INSERT INTO currency (valuteID,numCode,сharCode,name,value,date) '
                            ."VALUES $insert ";
        $result = $db->prepare($sql);

        //echo $sql;exit;
       
        $success = $result->execute();
        if (!$success) {
          echo __LINE__ . ' DB error: ';
          var_dump($result->errorInfo());
          exit;
        }
        return  $success;
    } 

    public static function checkExists($id, $date){
      $db = Db::getConnection();
      $sql = 'SELECT *  FROM currency WHERE valuteID = :id AND date = :date ';
      $result = $db->prepare($sql);
      $result->bindParam(':id', $id, PDO::PARAM_STR);
      $result->bindParam(':date', $date, PDO::PARAM_STR);
      $result->execute();
     
      return $result->fetch();
  }

  public static function find($id, $from, $to){
    $db = Db::getConnection();
    $sql = 'SELECT *  FROM currency WHERE valuteID = :id AND date >= :from AND date <= :to ';
    $result = $db->prepare($sql);
    $result->bindParam(':id', $id, PDO::PARAM_STR);
    $result->bindParam(':from', $from, PDO::PARAM_STR);
    $result->bindParam(':to', $to, PDO::PARAM_STR);
    $result->execute();
      $res =array();
      while ($row = $result->fetch()) {   
        $res[] = $row;
      }
      return $res;
}

public static function get($date){
  $db = Db::getConnection();
  $sql = 'SELECT *  FROM currency WHERE  date = :date ';
  $result = $db->prepare($sql);
  $result->bindParam(':date', $date, PDO::PARAM_STR);
  $result->execute();
    $res =array();
    while ($row = $result->fetch()) {   
      $res[] = $row;
    }
    return $res;
}

}