<?php

# Se requiere sesión iniciada
$app->get('/home', $is_logged($app), function () use ($app){
  $user = $_SESSION['user'];
  $q = new Question();
  $app->view()->setData('user', $user);
  $data['questions'] = $q->questions();
  return $app->render('index.twig',$data);
})->name('dashboard');

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
