<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';

$has_db = function ($app) {
  return function () use ($app) {
    if(is_null($app->db)){
      $app->redirect($app->urlFor('500'),500);
    } else {
      return true;
    }
  };
};

$auth = function ($app) {
  return function () use ($app) {
    if (!isset($_SESSION['user'])) {
      $app->redirect($app->urlFor('home'));
    }
  };
};

$app->get('/', $has_db($app), function() use($app) {
  if (!isset($_SESSION['user']))
    return $app->render('index.public.twig');
  else
    $app->redirect($app->urlFor('dashboard'));
})->name('home');

$app->post('/login', function() use($app){
  $u = new User();
  $u = $u->login($app->request->post());
  if(isset($u->id)){
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
})->name('login');

$app->get('/login', function() use($app){
  $t = new Team();
  $t = $t->login($app->request->get());
  if(isset($t->id)){
    print json_encode(array(
          "status" => 1,
          "team" => $t
          ));
  } else {
    print json_encode(array(
          "status" => 2
          ));
  }
})->name('login_team');

$app->get('/logout', function() use($app){
  if(isset($_SESSION['user'])){
    unset($_SESSION['user']);
  }
  $app->view()->setData('user', null);
  $app->redirect($app->urlFor('home'));
})->name('logout');

# Include Controllers here
foreach(glob(CONTROLLERS_DIR.'*.php') as $router) {
  include_once $router;
}

$app->run();
