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
  $route->group('painel/usuario')->namespace('Test')->get('/autenticar', 'Classname::autenticar');
  $route->group('painel/usuario')->namespace('Test')->get('/autenticar/{id}/dominio/{idCliente}', 'Classname::method_get');
  $route->group('painel/usuario')->namespace('Test')->post('/autenticar/{id}/dominio/{idCliente}', 'Classname::method_post');
  $route->group('painel/modulo')->namespace('Test')->post('/autenticar/{id}/dominio/{idCliente}', 'Classname::autenticar');


  // $route->__debug();
  $route->execute();
