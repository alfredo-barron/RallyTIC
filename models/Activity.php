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
    $station_id = trim($post['station_id']);
    $question_id = trim($post['question_id']);
    $intents = trim($post['intents']);
    $time = trim($post['time']);
    $penalty = trim(!isset($post['penalty']) ? 0 : $post['penalty']);
    $st = $this->db->prepare("INSERT INTO activities(name, station_id, question_id, intents, time, penalty) VALUES(?,?,?,?,?,?)");
    $st->execute(array($name,$station_id,$question_id,$intents,$time,$penalty));
    $st = $this->db->prepare("SELECT * FROM activities WHERE name = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($name));
    return $st->fetch();
  }

  public function activities() {
    $st = $this->db->prepare("SELECT activities.id AS id, activities.name as name, activities.time AS time, activities.intents AS intents, stations.name AS station, stations.lat AS lat, stations.lng AS lng, questions.id AS question_id, questions.message AS question, questions.answer AS answer, questions.track AS track, activities.penalty AS penalty FROM activities,stations,questions WHERE activities.station_id = stations.id AND activities.question_id = questions.id ORDER BY activities.name DESC");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute();
    return $st->fetchAll();
  }

  public function activity($id) {
    $st = $this->db->prepare("SELECT activities.id AS id, activities.name as name, activities.time AS time, activities.intents AS intents, stations.name AS station, stations.lat AS lat, stations.lng AS lng, questions.message AS question, questions.answer AS answer, questions.track AS track, activities.penalty AS penalty FROM activities,stations,questions WHERE activities.station_id = stations.id AND activities.station_id = questions.id AND activities.id = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($id));
    return $st->fetch();
  }

}
