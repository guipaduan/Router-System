<?php

  namespace Router;

  /**
   * Class Router Security
   *
   * @author Guilherme Paduan <https://github.com/guipaduan>
   */
  trait RouterSecurity {

    /**
     * @param int $code :: http status code
     */
    protected function response($code) {
			switch ($code) {
        case 100: $msg = 'Continue'; break;
        case 101: $msg = 'Switching Protocols'; break;
        case 200: $msg = 'OK'; break;
        case 201: $msg = 'Created'; break;
        case 202: $msg = 'Accepted'; break;
        case 203: $msg = 'Non-Authoritative Information'; break;
        case 204: $msg = 'No Content'; break;
        case 205: $msg = 'Reset Content'; break;
        case 206: $msg = 'Partial Content'; break;
        case 300: $msg = 'Multiple Choices'; break;
        case 301: $msg = 'Moved Permanently'; break;
        case 302: $msg = 'Moved Temporarily'; break;
        case 303: $msg = 'See Other'; break;
        case 304: $msg = 'Not Modified'; break;
        case 305: $msg = 'Use Proxy'; break;
        case 400: $msg = 'Bad Request'; break;
        case 401: $msg = 'Unauthorized'; break;
        case 402: $msg = 'Payment Required'; break;
        case 403: $msg = 'Forbidden'; break;
        case 404: $msg = 'Not Found'; break;
        case 405: $msg = 'Method Not Allowed'; break;
        case 406: $msg = 'Not Acceptable'; break;
        case 407: $msg = 'Proxy Authentication Required'; break;
        case 408: $msg = 'Request Time-out'; break;
        case 409: $msg = 'Conflict'; break;
        case 410: $msg = 'Gone'; break;
        case 411: $msg = 'Length Required'; break;
        case 412: $msg = 'Precondition Failed'; break;
        case 413: $msg = 'Request Entity Too Large'; break;
        case 414: $msg = 'Request-URI Too Large'; break;
        case 415: $msg = 'Unsupported Media Type'; break;
        case 500: $msg = 'Internal Server Error'; break;
        case 501: $msg = 'Not Implemented'; break;
        case 502: $msg = 'Bad Gateway'; break;
        case 503: $msg = 'Service Unavailable'; break;
        case 504: $msg = 'Gateway Time-out'; break;
        case 505: $msg = 'HTTP Version not supported'; break;
        default: exit('Unknown http status code "' . htmlentities($code) . '"');
        break;
      }

      http_response_code($code);

      if ($code != 200 && $code != 201) {
        echo json_encode([
          'code' => $code,
          'message' => $msg
        ]);
      }
		}



    /**
     * Verifica se request_uri contem query string
     */
    protected function checkQuerys() {
      $parse = parse_url($_SERVER['REQUEST_URI']);

      if (array_key_exists('query', $parse)) {
        $this->response(406);
        exit;
      }

      return;
    }



    /**
     * Verifica se as credenciais enviadas são válidas
     */
    protected function checkBasicAuth() {
      if (!(isset($_SERVER['PHP_AUTH_USER']) && $_SERVER['PHP_AUTH_USER'] === AUTH_USER) && !(isset($_SERVER['PHP_AUTH_PW']) && $_SERVER['PHP_AUTH_USER'] == AUTH_PASS)) {
        $this->response(401);
        exit;
      }
    }
  }
