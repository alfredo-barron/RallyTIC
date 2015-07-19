<?php
/**
* Modelo Station
*/
class Station {

  protected $db = null;

  function __construct(){
    $app = \Slim\Slim::getInstance();
    $this->db = $app->db;
  }

/**
 * Function insert new station
 * @param  array() $post
 * @return PDOStatement
 */
  public function save($post) {
    $name = trim($post['name']);
    $lat = trim($post['lat']);
    $lng = trim($post['lng']);
    $st = $this->db->prepare("INSERT INTO station(name, lat, lng) VALUES(?,?,?)");
    $st->execute(array($name,$lat,$lng));
    $st = $this->db->prepare("SELECT * FROM questions WHERE name = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($name));
    return $st->fetch();
  }

}
