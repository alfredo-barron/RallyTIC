<?php
$app->post("/new-user", function () use ($app){
  $u = new User();
  $u = $u->save($app->request->post());
  if (isset($u->id)) {
    print json_encode(array(
          "status" => 1
          ));
  } else {
    print json_encode(array(
          "status" => 2
          ));
  }
})->name('new-user-post');
