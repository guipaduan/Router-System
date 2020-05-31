<?php

  namespace Router;

  /**
   * Class Route Recorder
   *
   * @author Guilherme Paduan <https://github.com/guipaduan>
   */
  trait RouterRecorder {

    /**
     * Registrador de rotas
     *
     * @param string $method
     * @param string $route
     * @param string|callable $trigger
     */
    protected function register(string $method, string $route, string $trigger) {
      if ($route === '/') {
        $route = str_replace('/', '', $route);
      }

      $route = ($this->group ? '/' . $this->group . $route : $route);
      $route = ($this->version ? str_replace('/'.$this->version, '', $route) : $route);
      $path = ($this->version ? str_replace('/'.$this->version, '', $this->path) : $this->path);
      $this->path = $path;

      preg_match_all("~\{\s* ([a-zA-Z_][a-zA-Z0-9_-]*) \}~x", $route, $params, PREG_SET_ORDER);
      $diff = array_values(array_diff(explode("/", $path), explode("/", $route)));

      // echo '<pre>';
      // print_r($route);
      // echo '<br />';
      // print_r($path);
      // print_r(explode("/", $path));
      // print_r(explode("/", $route));
      // print_r($diff);
      // print_r($params);
      // print_r(count($params) . '==' . count($diff));
      // echo '</pre>';

      if (count($params) === count($diff)) {
        foreach($params as $key => $value) {
          $data[$value[1]] = $diff[$key];
        }
      }

      $currentRoute = [
        'method' => $method,
        'key' => preg_replace('~{([^}]*)}~', '([^/]+)', $route),
        'route' => $route,
        'class' => $this->className($trigger),
        'function' => $this->classMethod($trigger),
        'data' => $data
      ];

      $endpoint = preg_replace('~{([^}]*)}~', "([^/]+)", $route);
      $this->routes[$method][$endpoint] = $currentRoute;
    }



    /**
     * Extrai classe do parametro $trigger passado para o register
     *
     * @param string $trigger :: Class::method
     * @return string Namespace\Class
     */
    private function className(string $trigger) {
      if (is_string($trigger)) {
        return ($this->namespace ? $this->namespace . '\\' : '') . explode('::', $trigger)[0];
      }
    }



    /**
     * Extrai método do parametro $trigger passado para o register
     *
     * @param string $trigger :: Class::method
     * @return string method
     */
    private function classMethod(string $trigger) {
      if (is_string($trigger)) {
        return explode('::', $trigger)[1];
      }
    }

  }
