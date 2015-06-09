<?php
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

$app->get('/', $has_db($app), function() use($app) {
  //return $app->render('login.twig');
  echo "Api Rally TIC";
})->name('home');

$app->post('/login', function() use($app){
  if(isset($app->session['logged_in']) and $app->session['logged_in'] == true){
    $app->redirect($app->urlFor('home'));
  }
  $request = $app->request;
  $usuario = trim($request->post('usuario'));
  $password = $request->post('password');
})->name('login');

$app->get('/logout', function() use($app){
  if(isset($_SESSION['user'])){
    unset($_SESSION['user']);
  }
  $app->view()->setData('user', null);
  $app->redirect($app->urlFor('home'));
})->name('logout');

$app->get('/500', function() use($app){
  $app->render('errors/500.twig');
})->name('500');

# Include Controllers here


$app->run();