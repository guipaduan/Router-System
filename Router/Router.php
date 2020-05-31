<?php
  namespace Router;

  /**
   * Class Routes
   *
   * @author Guilherme Paduan <https://github.com/guipaduan>
   */
  class Router extends RouterExecute {

    /**
     * @param string $route :: endpoint do serviço
     * @param string $trigger :: classe e método para instância de objeto
     */
    public function get(string $route, string $trigger) {
      $this->register('GET', $route, $trigger);
    }

    public function post(string $route, string $trigger) {
      $this->register('POST', $route, $trigger);
    }

    public function put(string $route, string $trigger) {
      $this->register('PUT', $route, $trigger);
    }

    public function patch(string $route, string $trigger) {
      $this->register('PATCH', $route, $trigger);
    }

    public function delete(string $route, string $trigger) {
      $this->register('DELETE', $route, $trigger);
    }

  }
