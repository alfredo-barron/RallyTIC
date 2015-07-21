<?php

# Se requiere sesión iniciada del organizador
$app->get('/inicio', $auth($app), function () use ($app){
  $user = $_SESSION['user'];
  $app->view()->setData('user', $user);
  return $app->render('index.twig');
})->name('dashboard');

$app->get('/eventos', $auth($app), function () use ($app){
  $user = $_SESSION['user'];
  $app->view()->setData('user', $user);
  return $app->render('events.twig');
})->name('event');

$app->get('/actividades', $auth($app), function () use ($app){
  $user = $_SESSION['user'];
  $app->view()->setData('user', $user);
  return $app->render('activities.twig');
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

$app->get("/questions", function () use ($app){
  $a = new Activity();
  $a = $a->activities();
  print json_encode($a);
})->name('questions');
