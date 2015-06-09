<?php
$app->group("/api", function () use ($app) {
  $app->get("/usuarios", function () use ($app) {
    #/api/usuarios
  });

  $app->get("/grupos", function () use ($app) {
    #/api/grupos
  });
});
