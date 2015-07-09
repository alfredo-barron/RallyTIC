<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';
//require __DIR__ . '/vendor/facebook/php-sdk-v4/autoload.php';

//use Facebook\FacebookSession;
//use Facebook\FacebookRedirectLoginHelper;
//FacebookSession::setDefaultApplication('402114476653320', 'd64c8b2bccbe62caab6feec84ec50623');

$has_db = function ($app) {
  return function () use ($app) {
    if(is_null($app->db)){
      $app->redirect($app->urlFor('500'),500);
    } else {
      return true;
    }
  };
};

$is_logged = function ($app) {
  return function () use ($app) {
    if(isset($app->session['user']) and !is_null($app->session['user'])){
      return true;
    } else {
      $app->redirect($app->urlFor('dashboard'));
    }
  };
};

$app->get('/', $has_db($app), function() use($app) {
  if (!isset($_SESSION['user'])) {
    return $app->render('index.public.twig');
  } else {
    $user = $_SESSION['user'];
    $u = new User();
    $app->view()->setData('user', $user);
    $data['competitors'] = $u->competitors();
    return $app->render('index.twig',$data);
  }
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

//$app->get('/login', function() use($app){

  //$redirect_url = "http://rally-tic.herokuapp.com/callback";
  //$helper = new FacebookRedirectLoginHelper($redirect_url, $appId = NULL, $appSecret = NULL);
  //if (isset($user)) {
  //  $loginUrl = $helper->getLogoutUrl();
  //} else {
  //  $loginUrl = $helper->getLoginUrl();
  //}
  //echo "<a href='".$loginUrl."'>Entrar con Facebook</a>";
  //if(isset($app->session['logged_in']) and $app->session['logged_in'] == true){
  //  $app->redirect($app->urlFor('home'));
  //}
  //$request = $app->request;
  //$usuario = trim($request->post('usuario'));
  //$password = $request->post('password');
//})->name('login');

//$app->get('/callback', function() use($app){
   // try {
   //   $user = $helper->getSessionFromRedirect();
   // } catch(FacebookRequestException $ex) {
      // When Facebook returns an error
   // } catch(\Exception $ex) {
      // When validation fails or other local issues
   // }
   // if ($user) {
   //    print_r($user);
   // }
//})->name('callback');

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
foreach(glob(CONTROLLERS_DIR.'*.php') as $router) {
  include_once $router;
}

$app->run();
