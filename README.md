# Router-System
Sistema simples de implementação de rotas com basic auth suportando verbos `GET` `POST` `PUT` `PATCH` e `DELETE`

### Uso

```
require_once('../Router/RouterRecorder.php');
require_once('../Router/RouterSecurity.php');
require_once('../Router/RouterExecute.php');
require_once('../Router/Router.php');

use Router\Router;
$route = new Router\Router;

$route->namespace('Test')->group('group/path')->get('/route/{id}', 'Classname::method_get');
$route->namespace('Test')->group('group/path')->post('/route/{id}', 'Classname::method_post');
$route->namespace('Test')->group('group/path')->put('/route/{id}', 'Classname::method_put');
$route->namespace('Test')->group('group/path')->patch('/route/{id}', 'Classname::method_patch');
$route->namespace('Test')->group('group/path')->delete('/route/{id}', 'Classname::method_delete');

$route->execute();
```

### Métodos

`$route->version('v1')`

É definido uma versão para o roteador, essa versão é requerida somente se sua aplicação estiver em algum subdiretório com um folder criado. Ex.: **localhost/v1**, nesse caso **`v1`** será onde estará definido todas as suas rotas. **`localhost/v1/router/{id}`**



`$route->namespace('Test')`

É definido somente se os __Controllers__ de cada método estiver utilizando `namespace`. Ex.:

```
namespace Test;

class Classname {

  function method_get(array $data) {
    echo 'Método responsável por responder o get';
  }

  function method_post(array $data) {
    echo 'Método responsável por responder o post';
  }
}
```



`$route->group('group/path')`

Use para criar agrupamentos antes de cada rota, ex.: **`localhost/group/path/route/{id}`**, neste caso, **group/path** não será considerado para mapeamento de parâmetros. Caso definido com versão: **`localhost/v1/group/path/route/{id}`**




### Debug
Para visualizar o que ocorre por debaixo dos panos existe a o método **`__debug()`**, ao chama-lá o processamento de rotas é parado e será retornado os dados de todas as rotas registradas
