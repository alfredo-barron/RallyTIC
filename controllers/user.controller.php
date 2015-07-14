<?php
$app->post("/new-user", function () use ($app){
  $u = new User();
  $u = $u->save($app->request->post());
  if (isset($u->id)) {
    $_SESSION['user'] = $u;
    $app->view()->setData('user', $u);
    print json_encode(array(
          "status" => 1
          ));
  } else {
    print json_encode(array(
          "status" => 2
          ));
  }
})->name('new-user-post');

$app->post("/new-competitor", function () use ($app){
  $u = new User();
  $u = $u->new_competitor($app->request->post());
  if (isset($u->id)) {
    print json_encode(array(
          "status" => 1
          ));
  } else {
    print json_encode(array(
          "status" => 2
          ));
  }
})->name('new-competitor-post');

$app->post("/new-team", function () use ($app){
  $t = new Team();
  $t = $t->save($app->request->post());
  if (isset($t->id)) {
    print json_encode(array(
          "status" => 1
          ));
  } else {
    print json_encode(array(
          "status" => 2
          ));
  }
})->name('new-team-post');

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
