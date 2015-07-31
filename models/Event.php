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
    $date_event = trim($post['date']);
    $hour_start = trim($post['hour']);
    $st = $this->db->prepare("INSERT INTO events(name, description, date_event, hour_start) VALUES(?,?,?,?)");
    $st->execute(array($name,$description,$date_event,$hour_start));
    $st = $this->db->prepare("SELECT * FROM events WHERE name = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($name));
    return $st->fetch();
  }

  public function list_events() {
    $st = $this->db->prepare("SELECT * FROM events ORDER BY name DESC");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute();
    return $st->fetchAll();
  }

  public function event($id) {
    $st = $this->db->prepare("SELECT * FROM events WHERE id = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($id));
    return $st->fetch();
  }

  public function events($id) {
    $st = $this->db->prepare("SELECT activities.id AS id, activities.name as name, activities.time AS time, activities.intents AS intents, stations.name AS station, stations.lat AS lat, stations.lng AS lng, questions.id AS question_id, questions.message AS question, questions.answer AS answer, questions.track AS track, activities.penalty AS penalty FROM events,activity_event,activities,questions,stations,event_team,teams WHERE activity_event.event_id = events.id AND activity_event.activity_id = activities.id AND activities.question_id = questions.id AND activities.station_id = stations.id AND event_team.event_id = events.id AND event_team.team_id = teams.id AND events.id = 1 AND teams.id = ? ORDER BY activity_event.created_at ASC");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($id));
    return $st->fetchAll();
  }

  public function findEvent($id) {
    $st = $this->db->prepare("SELECT activities.id AS id, activities.name as name, activities.time AS time, activities.intents AS intents, stations.name AS station, stations.lat AS lat, stations.lng AS lng, questions.id AS question_id, questions.message AS question, questions.answer AS answer, questions.track AS track, activities.penalty AS penalty FROM events,activity_event,activities,questions,stations,event_team,teams WHERE activity_event.event_id = events.id AND activity_event.activity_id = activities.id AND activities.question_id = questions.id AND activities.station_id = stations.id AND event_team.event_id = events.id AND event_team.team_id = teams.id AND events.id = 1 AND teams.id = ? ORDER BY activity_event.created_at ASC LIMIT 1");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($id));
    return $st->fetch();
  }

  public function teamsEvent($id) {
    $st = $this->db->prepare("SELECT teams.name FROM teams,event_team,events WHERE event_team.team_id = teams.id AND event_team.event_id = events.id AND events.id = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($id));
    return $st->fetchAll();
  }

  public function save_activity($post) {
    $event_id = trim($post['event_id']);
    $activity_id = trim($post['activity_id']);
    $st = $this->db->prepare("INSERT INTO activity_event(event_id, activity_id) VALUES(?,?)");
    $st->execute(array($event_id,$activity_id));
    $st = $this->db->prepare("SELECT * FROM activity_event WHERE event_id = ? AND activity_id = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($event_id,$activity_id));
    return $st->fetch();
  }

  public function save_team($post){
    $event_id = trim($post['event_id']);
    $team_id = trim($post['team_id']);
    $st = $this->db->prepare("INSERT INTO event_team(event_id, team_id) VALUES(?,?)");
    $st->execute(array($event_id,$team_id));
    $st = $this->db->prepare("SELECT * FROM event_team WHERE event_id = ? AND team_id = ?");
    $st->setFetchMode(PDO::FETCH_OBJ);
    $st->execute(array($event_id,$team_id));
    return $st->fetch();
  }

}
