<?php

# Se requiere sesión iniciada del organizador
$app->get('/inicio', $auth($app), function () use ($app){
  $user = $_SESSION['user'];
  $app->view()->setData('user', $user);
  return $app->render('index.twig');
})->name('dashboard');

$app->get('/eventos', $auth($app), function () use ($app){
  $e = new Event();
  $a = new Activity();
  $t = new Team();
  $user = $_SESSION['user'];
  $app->view()->setData('user', $user);
  $data['events'] = $e->events();
  $data['activities'] = $a->list_activities();
  $data['teams'] = $t->teams();
  return $app->render('events.twig',$data);
})->name('event');

$app->get('/actividades', $auth($app), function () use ($app){
  $user = $_SESSION['user'];
  $s = new Station();
  $q = new Question();
  $app->view()->setData('user', $user);
  $data['stations'] = $s->stations();
  $data['questions'] = $q->questions();
  return $app->render('activities.twig',$data);
})->name('activity');

$app->get('/participantes', $auth($app), function () use ($app){
  $user = $_SESSION['user'];
  $app->view()->setData('user', $user);
  return $app->render('teams.twig');
})->name('competitor');

$app->get('/estaciones', $auth($app), function () use ($app){
  $user = $_SESSION['user'];
  $app->view()->setData('user', $user);
  return $app->render('stations.twig');
})->name('station');

$app->get('/preguntas', $auth($app), function () use ($app){
  $user = $_SESSION['user'];
  $q = new Question();
  $app->view()->setData('user', $user);
  $data['questions'] = $q->questions();
  return $app->render('questions.twig',$data);
})->name('question');

# Se requiere sesión iniciada del participantes
$app->get('/inicio', $auth($app), function () use ($app){
  $user = $_SESSION['user'];
  $app->view()->setData('user', $user);
  return $app->render('index.twig');
})->name('events');

$app->get('/equipos', $auth($app), function () use ($app){
  $user = $_SESSION['user'];
  $app->view()->setData('user', $user);
  return $app->render('competitors.twig');
})->name('competitor_team');

$app->get('/puntuajes', $auth($app), function () use ($app){
  $user = $_SESSION['user'];
  $app->view()->setData('user', $user);
  return $app->render('index.twig');
})->name('score');

//Acciones
$app->post("/new-event", function () use ($app){
  $e = new Event();
  $e = $e->save($app->request->post());
  if (isset($e->id)) {
    print json_encode(array(
          "status" => 1
          ));
  } else {
    print json_encode(array(
          "status" => 2
          ));
  }
})->name('new-event-post');

$app->post("/add-activity", function () use ($app){
  $e = new Event();
  $e = $e->save_activity($app->request->post());
  if (isset($e->id)) {
    print json_encode(array(
          "status" => 1
          ));
  } else {
    print json_encode(array(
          "status" => 2
          ));
  }
})->name('add-activity-post');

$app->post("/add-team", function () use ($app){
  $e = new Event();
  $e = $e->save_team($app->request->post());
  if (isset($e->id)) {
    print json_encode(array(
          "status" => 1
          ));
  } else {
    print json_encode(array(
          "status" => 2
          ));
  }
})->name('add-team-post');

$app->post("/new-activity", function () use ($app){
  $a = new Activity();
  $a = $a->save($app->request->post());
  if (isset($a->id)) {
    print json_encode(array(
          "status" => 1
          ));
  } else {
    print json_encode(array(
          "status" => 2
          ));
  }
})->name('new-activity-post');

$app->post("/new-station", function () use ($app){
  $s = new Station();
  $s = $s->save($app->request->post());
  if (isset($s->id)) {
    print json_encode(array(
          "status" => 1
          ));
  } else {
    print json_encode(array(
          "status" => 2
          ));
  }
})->name('new-station-post');

$app->post("/new-question", function () use ($app){
  $q = new Question();
  $q = $q->save($app->request->post());
  if (isset($q->id)) {
    print json_encode(array(
          "status" => 1
          ));
  } else {
    print json_encode(array(
          "status" => 2
          ));
  }
})->name('new-question-post');

$app->get("/events", function () use ($app){
  $e = new Event();
  $e = $e->list_events();
  print json_encode($e);
})->name('get-events');

$app->get("/evento", function () use ($app){
  $e = new Event();
  $a = $e->events();
  $data['event'] = $e->event(1);
  $data['activities'] = $a;
  //print json_encode($e);
  print json_encode($data);
})->name('event');

$app->get("/competitors", function () use ($app){
  $u = new User();
  $u = $u->competitors();
  print json_encode($u);
})->name('competitors');

$app->get("/teams", function () use ($app){
  $t = new Team();
  $t = $t->teams();
  print json_encode($t);
})->name('teams');

$app->get("/team/:id", function ($id) use ($app){
  $t = new Team();
  $t = $t->team($id);
  print json_encode($t);
})->name('team');

$app->get("/stations", function () use ($app){
  $s = new Station();
  $s = $s->stations();
  print json_encode($s);
})->name('stations');

$app->get("/activitys", function () use ($app){
  $a = new Activity();
  $a = $a->activities();
  print json_encode($a);
})->name('activitys');

$app->get("/activity/:id", function ($id) use ($app){
  $a = new Activity();
  $a = $a->activity($id);
  print json_encode($a);
})->name('activity_one');

$app->get("/questions", function () use ($app){
  $q = new Question();
  $q = $q->questions();
  print json_encode($q);
})->name('questions');
