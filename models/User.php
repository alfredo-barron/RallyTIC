<?php
/**
* Modelo User
*/
class User {
  protected $table = 'users';
  protected $pk = 'id';
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
    $email = trim($post['email']);
    $username = trim($post['username']);
    $password = md5($post['password']);
    $st = $this->db->prepare("INSERT INTO users(username, email, password) VALUES(?,?,?)");
    $st->execute(array(
      $username,
      $email,
      $password));
    $st = $this->db->prepare("SELECT * FROM users WHERE username = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($username));
    return $st->fetch();
  }

  /**
   * Function login de user
   * @param  array() $post
   * @return array() $st
   */
  public function login($post){
    $email = trim($post['email']);
    $password = md5($post['password']);
    try {
      $st = $this->db->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
      $st->setFetchMode(PDO::FETCH_OBJ);
      $st->execute(array($email,$password));
      return $st->fetch();
    } catch (Exception $e) {
      return $e;
    }
  }



}
