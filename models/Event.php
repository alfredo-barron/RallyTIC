<?php
/**
* Modelo Event
*/
class Event {

  protected $db = null;

  function __construct(){
    $app = \Slim\Slim::getInstance();
    $this->db = $app->db;
  }

/**
 * Function insert new event
 * @param  array() $post
 * @return PDOStatement
 */
  public function save($post) {
    $name = trim($post['name']);
    $description = trim($post['description']);
    $date_start = trim($post['date_start']);
    $hour_start = trim($post['hour_start']);
    $st = $this->db->prepare("INSERT INTO events(name, description, date_start, hour_start) VALUES(?,?,?,?)");
    $st->execute(array($name,$description,$date_start,$hour_start));
    $st = $this->db->prepare("SELECT * FROM events WHERE name = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($name));
    return $st->fetch();
  }

}
