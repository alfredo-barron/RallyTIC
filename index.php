<?php
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';
require __DIR__ . '/vendor/facebook/php-sdk-v4/autoload.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;

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
  return $app->render('index.twig');
})->name('home');

$app->get('/login', function() use($app){

  FacebookSession::setDefaultApplication('402114476653320', 'd64c8b2bccbe62caab6feec84ec50623');
  $helper = new FacebookRedirectLoginHelper("https://rally-tic.herokuapp.com/callback");
  if (isset($user)) {
    $loginUrl = $helper->getLogoutUrl();
  } else {
    $loginUrl = $helper->getLoginUrl(array('scope' => 'read_stream,user_status,publish_stream,email,user_location'));
  }
  echo $loginUrl;
  //if(isset($app->session['logged_in']) and $app->session['logged_in'] == true){
  //  $app->redirect($app->urlFor('home'));
  //}
  //$request = $app->request;
  //$usuario = trim($request->post('usuario'));
  //$password = $request->post('password');
})->name('login');

$app->get('/callback', function() use($app){
  $helper = new FacebookRedirectLoginHelper();
    try {
      $session = $helper->getSessionFromRedirect();
    } catch(FacebookRequestException $ex) {
      // When Facebook returns an error
    } catch(\Exception $ex) {
      // When validation fails or other local issues
    }
    if ($session) {
      // Logged in
    }
})->name('callback');

$app->get('/logout', function() use($app){
  if(isset($_SESSION['user'])){
    unset($_SESSION['user']);
  }
  $app->view()->setData('user', null);
  $app->redirect($app->urlFor('home'));
})->name('logout');

$app->get('/500', function() use($app){
  //$app->render('errors/500.twig');
  echo "500";
})->name('500');

# Include Controllers here


$app->run();
