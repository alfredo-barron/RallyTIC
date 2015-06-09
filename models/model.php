<?php
/**
* Base class for PDO models
*/
class Model{
  protected $table = 'model';
  protected $primary_key = 'id';
  protected $id = null;
  private $dbh = null;
  private $result = null;
  private $st = null;
  private $sql = null;
  private $columns = null;
  private $conditions = null;

  public function __construct(){
    $app = \Slim\Slim::getInstance();
    $this->dbh = $app->db;
  }

  #CRUD Methods
  public function find($columns){
    $cols = columns($columns);
    $this->sql = "SELECT $cols FROM {$this->table}";
    return $this;
  }

  public function where($conditions = null){
    if(is_null($conditions)){
      $this->conditions = null;
    } else {
      $this->sql .= "WHERE ";
      $attrs = array();
      foreach ($conditions as $col => $value) {
        $attrs[] = "$col=:$col";
      }
      if(empty($attrs)){
        $this->sql .= " 1";
      } else {
        for ($i=0; $i < count($attrs); $i++) {
          if($i == (count($attrs) - 1)){
            $this->sql .= "{$attrs[$i]} ";
          } else {
            $this->sql .= "{$attrs[$i]} AND ";
          }
        }
      }
      $this->conditions = $conditions;
      return $this;
    }
  }

  public function get($id){
    $this->id = $id;
    if(is_null($this->conditions)){
      $this->sql .= "WHERE {$this->primary_key} =: $id";
    } else {
      $this->sql .= "AND {$this->primary_key} =: $id";
    }
    $this->st = $this->binder($this->sql, $conditions);
    $this->st = $this->bind($this->primary_key, $id);
    $this->st->execute();
    $this->result = $this->st->fetch();
    return $this->utf8_decode_mix($this->result);
  }

  public function all(){
    $this->st = $this->binder($this->sql, $conditions);
    $this->st->execute();
    $this->result = $this->st->fetchAll();
    return $this->utf8_decode_mix($this->result);
  }

  public function save($data = array()){
    if(is_array($data) and !empty($data)){
      //if(isset($data[$this->primary_key])){
      if(!is_null($this->id)){
        $sql = "UPDATE {$this->table} SET ";
        $attrs = array();
        foreach ($data as $col => $value) {
          //if($col != $this->primary_key){
            $attrs[] = "$col = :$col";
          //}
        }
        for ($i=0; $i < count($attrs); $i++) {
          if($i == (count($attrs) - 1)){
            $sql .= "{$attrs[$i]} ";
          } else {
            $sql .= "{$attrs[$i]}, ";
          }
        }
        $sql .= "WHERE {$this->primary_key} = :id";
      } else {
        $sql = "INSERT INTO {$this->table} (";
        $attrs = array();
        foreach ($data as $col => $value) {
            $attrs[] = $col;
        }
        for ($i=0; $i < count($attrs); $i++) {
          if($i == (count($attrs) - 1)){
            $sql .= "{$attrs[$i]}";
          } else {
            $sql .= "{$attrs[$i]}, ";
          }
        }
        $sql .= ") VALUES (";
        for ($i=0; $i < count($attrs); $i++) {
          if($i == (count($attrs) - 1)){
            $sql .= ":{$attrs[$i]}";
          } else {
            $sql .= ":{$attrs[$i]}, ";
          }
        }
        $sql .= ")";
      }
      $this->st = $this->binder($sql, $data);
      if(!is_null($this->id)){
        $this->st = $this->bind($this->primary_key, $this->id);
      }
      $this->sql = $sql;
      $this->result = $this->st->execute();
      return $this->result;
    } else {
      return false;
    }
  }

  public function delete($conditions = null){
    $this->where($conditions);
    $sql = "DELETE FROM {$this->table} {$this->conditions}";
    $this->st = $this->binder($sql, $conditions);
    $this->result = $this->st->execute();
    return $this->result;
  }

  public function count(){
    if(!is_null($this->st->rowCount())){
      return $this->st->rowCount();
    } else {
      return count($this->result);
    }
  }

  public function lastId(){
    return $this->dbh->lastInsertId();
  }

  public function truncate(){
    return $this->raw("TRUNCATE TABLE {$this->table}");
  }

  public function raw($sql, $data = null){
    $this->st = $this->binder($sql, $data);
    $this->result = $this->st->execute();
    if(strpos(strtolower($sql),"select ") !== false ){
      if($this->count() > 1){
        $this->result = $this->st->fetchAll();
      } else {
        $this->result = $this->st->fetch();
      }
    }
    return $this->utf8_decode_mix($this->result);
  }

  private function bind($param, $value, $type = null){
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }
    if($type == PDO::PARAM_STR){
      $this->st->bindValue($param, utf8_encode($value), $type);
    } else {
      $this->st->bindValue($param, $value, $type);
    }
  }

  private function binder($sql, $conditions){
    $this->st = $this->dbh->prepare($sql);
    $this->st->setFetchMode(PDO::FETCH_ASSOC);
    if(is_array($conditions) and count($conditions) != 0){
      foreach ($conditions as $key => $value) {
        $this->bind($key,$value);
      }
    }
  }

  private function utf8_decode_mix($input, $decode_keys = false){
    if(is_array($input)){
      $result = array();
      foreach($input as $k => $v){
        $key = ($decode_keys) ? utf8_decode($k) : $k;
        $result[$key] = $this->utf8_decode_mix( $v, $decode_keys);
      }
    } else {
      $result = utf8_decode($input);
    }
    return $result;
  }

  private function columns($columns){
    if(is_null($columns)){
      $this->columns = "*";
    } else {
      $this->columns = $columns;
    }
  }

  #Transactions Methods
  public function begin(){
    return $this->dbh->beginTransaction();
  }

  public function end(){
    return $this->dbh->commit();
  }

  public function cancel(){
    return $this->dbh->rollBack();
  }

  #Debug Methods
  public function debug(){
    return $this->st->debugDumpParams();
  }

  public function sql(){
    return $this->sql;
  }

  public function toJson(){
    $rows = $this->result;
    if(empty($this->result)){
      return json_encode(array(), JSON_NUMERIC_CHECK);
    } else {
      if(is_array($this->result) && !isset($this->result['id'])){
        foreach ($this->result as $row) {
          foreach ($row as $key => $value) {
            if(is_string($value)){
              $row[$key] = json_encode($value);
            } else {
              $row[$key] = $value;
            }
          }
        }
      }
      return json_encode($rows, JSON_NUMERIC_CHECK);
    }
  }

  #Magic Methods
  public function __get($property){
    if(property_exists($this, $property)) {
      return $this->$property;
    } else {
      return null;
    }
  }

  public function __set($property, $value){
    if(property_exists($this, $property)) {
      $this->$property = $value;
    }
  }

  #Deprecated NOT Functional
  public function find1($columns = null, $conditions = null){
    $cols = columns($columns);
    $conds = where($conditions);
    $sql = "SELECT $cols FROM {$this->table} WHERE $conds";

    $this->st->execute();
    $this->result = $this->st->fetch();
    return $this->utf8_decode_mix($this->result);
  }
}
?>
