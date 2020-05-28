<?php
  /**
   * Headers
   */
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, PUT, PATCH, DELETE");
  header('Content-Type: application/json; charset=utf-8');
  header('Accept: application/json');
  header('Access-Control-Allow-Headers: Content-Type');

  /**
   * Requires
   */
  require_once('../config.php');
  require_once('../Router/RouterRecorder.php');
  require_once('../Router/RouterSecurity.php');
  require_once('../Router/RouterExecute.php');
  require_once('../Router/Router.php');

  require_once('../Test/Class.php');

  $route = new Router\Router;

  $route->version('v1');
  $route->namespace('Test')->group('group/path')->get('/route/{id}', 'Classname::method_get');
  $route->namespace('Test')->group('group/path')->post('/route/{id}', 'Classname::method_post');
  $route->namespace('Test')->group('group/path')->put('/route/{id}', 'Classname::method_put');
  $route->namespace('Test')->group('group/path')->patch('/route/{id}', 'Classname::method_patch');
  $route->namespace('Test')->group('group/path')->delete('/route/{id}', 'Classname::method_delete');


  // $route->__debug();
  $route->execute();
