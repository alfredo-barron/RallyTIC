<?php
/**
* Modelo Question
*/
class Question {

  protected $db = null;

  function __construct(){
    $app = \Slim\Slim::getInstance();
    $this->db = $app->db;
  }

/**
 * Function insert new question
 * @param  array() $post
 * @return PDOStatement
 */
  public function save($post) {
    $message = trim($post['message']);
    $answer = trim($post['answer']);
    $track = trim($post['track']);
    $st = $this->db->prepare("INSERT INTO questions(message, answer, track) VALUES(?,?,?)");
    $st->execute(array($message,$answer,$track));
    $st = $this->db->prepare("SELECT * FROM questions WHERE message = ? AND answer = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($message,$answer));
    return $st->fetch();
  }

  public function questions() {
    $st = $this->db->prepare("SELECT id,message,answer,track FROM questions ORDER BY id ASC");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute();
    return $st->fetchAll();
  }

}
