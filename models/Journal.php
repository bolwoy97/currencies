<?php

class Journal
{
    public static function add($type,$user,$sum,$date,$name,$rate,$status,$lvl, $cur='',$detail='', $adr='')
    {
        $db = Db::getConnection();
        $sql = 'INSERT INTO journal ( type, user, sum, date, name, rate, status, lvl, cur, detail, adr) '
                            .'VALUES (:type,:user,:sum,:date,:name,:rate,:status , :lvl, :cur, :detail, :adr)';
        $result = $db->prepare($sql);
        $result->bindParam(':type', $type, PDO::PARAM_STR);
        $result->bindParam(':user', $user, PDO::PARAM_STR);
        $result->bindParam(':sum', $sum, PDO::PARAM_STR);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':rate', $rate, PDO::PARAM_STR);
        $result->bindParam(':status', $status, PDO::PARAM_STR);
        $result->bindParam(':lvl', $lvl, PDO::PARAM_STR);
        $result->bindParam(':cur', $cur, PDO::PARAM_STR);
        $result->bindParam(':detail', $detail, PDO::PARAM_STR);
        $result->bindParam(':adr', $adr, PDO::PARAM_STR);
      $result->execute();
        return true;
    } 

    public static function checkBatch($id, $batch){
      $db = Db::getConnection();
      $sql = 'SELECT *  FROM journal WHERE user = :id AND detail = :batch ';
      $result = $db->prepare($sql);
      $result->bindParam(':id', $id, PDO::PARAM_STR);
      $result->bindParam(':batch', $batch, PDO::PARAM_STR);
      $result->execute();
     
      return $result->fetch();
  }

    public static function getByType($id, $type){
      $db = Db::getConnection();
      $sql = 'SELECT *  FROM journal WHERE user = :id AND type = :type ORDER BY id DESC';
      $result = $db->prepare($sql);
      $result->bindParam(':id', $id, PDO::PARAM_STR);
      $result->bindParam(':type', $type, PDO::PARAM_STR);
      $result->execute();
      $res =array();
      while ($row = $result->fetch()) {   
        $res[] = $row;
      }
      return $res;
  }

  public static function getEarnings($id){
    $db = Db::getConnection();
    $earns = ['lsf'=>0,'lsf_bon'=>0,'btc'=>0,'bch'=>0,'eth'=>0,'usd'=>0];

    $sql = "SELECT SUM(sum) FROM journal WHERE user = :id AND type = 'usd_to_lsf'  ";
    $result = $db->prepare($sql);
    $result->bindParam(':id', $id, PDO::PARAM_STR);
    $result->execute();
    $earns['lsf'] += $result->fetch()[0];
    //////
    $sql = "SELECT SUM(sum) FROM journal WHERE user = :id AND type = 'lsf_bon'  ";
    $result = $db->prepare($sql);
    $result->bindParam(':id', $id, PDO::PARAM_STR);
    $result->execute();
    $earns['lsf_bon'] += $result->fetch()[0];
    //////
    $sql = "SELECT SUM(sum) FROM journal WHERE user = :id AND  type = 'add' AND  cur = 'btc' ";
    $result = $db->prepare($sql);
    $result->bindParam(':id', $id, PDO::PARAM_STR);
    $result->execute();
    $earns['btc'] += $result->fetch()[0];
    //////
    $sql = "SELECT SUM(sum) FROM journal WHERE user = :id AND  type = 'add' AND  cur = 'bch' ";
    $result = $db->prepare($sql);
    $result->bindParam(':id', $id, PDO::PARAM_STR);
    $result->execute();
    $earns['bch'] += $result->fetch()[0];
    //////
    $sql = "SELECT SUM(sum) FROM journal WHERE user = :id AND  type = 'add' AND  cur = 'eth' ";
    $result = $db->prepare($sql);
    $result->bindParam(':id', $id, PDO::PARAM_STR);
    $result->execute();
    $earns['eth'] += $result->fetch()[0];
    //////
    $sql = "SELECT SUM(sum) FROM journal WHERE user = :id AND  type = 'add' AND  cur = 'usd' ";
    $result = $db->prepare($sql);
    $result->bindParam(':id', $id, PDO::PARAM_STR);
    $result->execute();
    $earns['usd'] += $result->fetch()[0];

    return $earns;
}

  
  public static function getDeposits($date, $type){
    $db = Db::getConnection();
    $sql = 'SELECT *  FROM journal WHERE date = :date AND type = :type ORDER BY id DESC';
    $result = $db->prepare($sql);
    $result->bindParam(':date', $date, PDO::PARAM_STR);
    $result->bindParam(':type', $type, PDO::PARAM_STR);
    $result->execute();
    $res =array();
    while ($row = $result->fetch()) {   
      $res[] = $row;
    }
    return $res;
}

  public static function last($id, $lim){
    $db = Db::getConnection();
    $sql = "SELECT *  FROM journal WHERE user = :id AND (type = 'usd_to_lsf' OR type = 'lsf_bon' OR type = 'add') ORDER BY id DESC LIMIT $lim ";
    $result = $db->prepare($sql);
    $result->bindParam(':id', $id, PDO::PARAM_STR);
    $result->execute();
    $res =array();
    while ($row = $result->fetch()) {   
      $res[] = $row;
    }
    return $res;
}


public static function setVal($id, $val, $table )
{
    $db = Db::getConnection();
    $sql = "UPDATE journal 
        SET $table =  :val
        WHERE id = :id";
    $result = $db->prepare($sql);
    $result->bindParam(':val', $val, PDO::PARAM_STR);    
    $result->bindParam(':id', $id, PDO::PARAM_INT); 
    return $result->execute();
}

}
