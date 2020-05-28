<?php

  namespace Test;

  class Classname {

    function method_get(array $data) {
      // echo 'Aqui vamo fazê magia';
      //
      // echo '<pre>';
      // print_r($data);
      // echo '</pre>';

      echo json_encode($data);
    }

    function method_post(array $data) {
      // echo 'Retorna aê postman';
      //
      // echo '<pre>';
      // print_r($data);
      // echo '</pre>';

      echo json_encode($data);
    }

  }
