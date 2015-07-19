<?php
/**
* Modelo Activity
*/
class Activity {

  protected $db = null;

  function __construct(){
    $app = \Slim\Slim::getInstance();
    $this->db = $app->db;
  }

/**
 * Function insert new user
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

}
