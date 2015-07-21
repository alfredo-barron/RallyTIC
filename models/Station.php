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
    $st = $this->db->prepare("INSERT INTO stations(name, lat, lng) VALUES(?,?,?)");
    $st->execute(array($name,$lat,$lng));
    $st = $this->db->prepare("SELECT * FROM stations WHERE name = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($name));
    return $st->fetch();
  }

  public function stations() {
    $st = $this->db->prepare("SELECT id,name FROM stations ORDER BY name DESC");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute();
    return $st->fetchAll();
  }

  public function station($id) {
    $st = $this->db->prepare("SELECT id,name,lat,lng FROM stations WHERE id = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($id));
    return $st->fetch();
  }

}
