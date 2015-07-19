<?php
/**
* Modelo Team
*/
class Team {

  protected $db = null;

  function __construct(){
    $app = \Slim\Slim::getInstance();
    $this->db = $app->db;
  }

/**
 * Function insert new team
 * @param  array() $post
 * @return PDOStatement
 */
  public function save($post) {
    $name = trim($post['name']);
    $password = trim($post['password']);
    $st = $this->db->prepare("INSERT INTO teams(name, password) VALUES(?,?)");
    $st->execute(array(
      $name,
      $password));
    $st = $this->db->prepare("SELECT * FROM teams WHERE name = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($name));
    return $st->fetch();
  }

  public function login($get){
    $name = trim($get['name']);
    $password = trim($get['password']);
    $st = $this->db->prepare("SELECT * FROM teams WHERE name = ? AND password = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($name,$password));
    return $st->fetch();
  }

  public function teams() {
    $st = $this->db->prepare("SELECT id,name FROM teams ORDER BY name DESC");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute();
    return $st->fetchAll();
  }

  public function team($id) {
    $st = $this->db->prepare("SELECT id,name,password FROM teams WHERE id = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($id));
    return $st->fetch();
  }
}
