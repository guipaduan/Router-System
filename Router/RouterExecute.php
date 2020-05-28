<?php

  namespace Router;

  /**
   * Class Routing Execute
   *
   * @author Guilherme Paduan <https://github.com/guipaduan>
   */
  class RouterExecute {

    use RouterRecorder;
    use RouterSecurity;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var null|string
     */
    protected $path;
    protected $requestMethod;
    protected $version;
    protected $group;
    protected $namespace;

    /**
     * @var array
     */
    protected $routes;
    protected $route;



    public function __construct() {
      $this->checkBasicAuth();
      $this->checkQuerys();

      $this->requestMethod = $_SERVER['REQUEST_METHOD'];
      $this->path = parse_url($_SERVER['REQUEST_URI'])['path'];
    }



    /**
     * Retorna dados de todas as rotas registradas
     * Para facilitar a visualização do todo.
     */
    public function __debug() {
      echo '__debug::Execute <br />';
      echo '<b>method ::</b> ' . $this->requestMethod . '<br />';
      echo '<b>version ::</b> ' . $this->version . '<br />';
      echo '<b>path ::</b> ' . ($this->version ? str_replace('/' . $this->version, '', $this->path) : $this->path) . '<br />';

      echo '<pre>';
      print_r($this->routes);
      echo '</pre>';
      exit;
    }



    /**
     * @param string version
     * @return Router
     */
    public function version(string $version) {
      $this->version = (is_string($version) ? strtolower($version) : null);
      return $this;
    }

    

    /**
     * @param string namespace
     * @return Router
     */
    public function namespace(string $namespace) {
      $this->namespace = ($namespace ? ucwords($namespace) : null);
      return $this;
    }



    /**
     * @param string group
     * @return Router
     */
    public function group(string $group) {
      $this->group = (is_string($group) ? strtolower($group) : null);
      return $this;
    }



    /**
     * Processa a rota atual
     * Faz chamada do método loader de classe da rota
     */
    public function execute() {
      if (empty($this->routes) || empty($this->routes[$this->requestMethod])) {
        $this->response(501);
        return;
      }

      foreach ($this->routes[$this->requestMethod] as $key => $route) {
        if (preg_match("~^" . $key . "$~", $this->path, $found)) {
          $this->route = $route;
        }
      }

      $this->classLoader();
    }



    /**
     * Verifica e faz o load da classe e método registrado na rota atual
     *
     * @param array data
     * @return boolean
     */
    private function classLoader() {
      if ($this->route) {
        $class = $this->route['class'];
        $method = $this->route['function'];

        if (class_exists($class)) {
          $controller = new $class($this);

          if (method_exists($class, $method)) {
            $controller->$method($this->getContents());
            return true;
          }

          $this->response(405);
          return false;
        }

        $this->response(400);
        return false;
      }

      $this->response(404);
      return false;
    }



    /**
     * Processa dados enviados para a API
     *
     * @return array
     */
    private function getContents() {
      if (in_array($this->requestMethod, ['POST', 'PUT', 'PATCH', 'DELETE']) && isset($_SERVER['CONTENT_LENGTH'])) {
        $data = json_decode(trim(file_get_contents('php://input')), true);
      }

      $data = [
        'body' => $data,
        'param' => $this->route['data']
      ];

      return ($data ?? []);
    }

  }
