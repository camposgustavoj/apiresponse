# Ministerio de Justicia y Derecho Humanos.

## Repositorio 

https://packagist.org/packages/mjydh/httpclient


## Instalación del paquete, por ahora la instalación se realiza manualmente.

## Opcion via repositories, agregar al composer.json

    "repositories": [
        {"type": "package", 
            "package": { 
                "name": "mjydh/httpclientbundle", 
                "version": "1.0.2", 
                "source": {
                    "url": "https://github.com/camposgustavoj/httpclient.git",
                    "type": "git",
                    "reference": "main" 
                }
            }
        }
    ],
    
## ejecutar composer require mjydh/httpclientbundle

1 - Descargar el proyecto desde https://github.com/camposgustavoj/httpclient <br>
2 - crear la carpeta mjydh dentro de vendor y colocar el paquete descargado dentro. <br>
3 - agregar en el autoload / psr-4 del composer.json del proyecto la referencia al paquete 

```json
"autoload": {
        "psr-4": {
        "MJYDH\\HttpClientBundle\\": "vendor/mjydh/HttpClientBundle"
    },
},
```

4 - ejecutar <br>
```bash
composer dump-autoload -o
```

En caso de no poder ejecutar el dump-autoload (como sucede en adminformel y formularioelectronico), se debe agregar en \vendor\composer\autoload_psr4.php la siguiente linea
```php
'MJYDH\\HttpClientBundle\\' => array($vendorDir . '/mjydh/HttpClientBundle'),
```

5 - Symfony < 3.4 Agregar en el AppKernel.php<br>

```php
new MJYDH\HttpClientBundle\HttpClientBundle(),
```
5 - Symfony > 4 Agregar en el config/bundles.php<br>

```php
MJYDH\HttpClientBundle\HttpClientBundle::class=>['all'=>true]
```

## Como implementarlo

```php
// Http client 
use MJYDH\HttpClientBundle\Service\HttpClient;
use MJYDH\HttpClientBundle\Exception\HttpException;
use MJYDH\HttpClientBundle\Exception\CatchExceptions;


try
{
    $http = new HttpClient();
    $http->setAuth($user, $pass); //En caso que sea por BASIC AUTH
    $http->setHeaderApiKey($keyValue, "apikey"); //En case que el auto sea por apikey
    //Se agrega al array todos los http_codes que se quieran recortar cuando se llama al Execute();
    $http->setHttpCodeResponses(array(200));
    //Se agregan todos los http_codes que tiran un CatchExceptions
    $http->setCatchExceptions(array(502=> new CatchExceptions("Titulo - Error 502", "Mensaje de error"), 
                                    0=> new CatchExceptions("Titulo - Error 502", "Mensaje de error")));

    //Ejecuta el http request y retorna un HttpResult
    $result = $http->Execute('GET', $url);      

}
} catch (CatchExceptions $cehttp) {
    return $this->showError($cehttp->getMessage(), $cehttp->getTitle()); 
}catch (HttpException $ehttp){
    return $this->showError($ehttp->getMessage(), $ehttp->getTitle()); 
}
```

## Fuctions

### setHttpCodeResponses($codesArray)
     * Setea los http code que debe responder el execute.
     * Los http code que no esten en las lista, los maneja el execute automaticamente.
     * 
     * @param $codesArray array("http_code")

### setCatchExceptions($catchExceptions)
     * Setea los http codes y sus respectivos mensajes de error que debe capturarse
     * 
     * @param $catchExceptions array("http_code" => "Mensaje de error")
     
# Comentarios extras al proyecto 

Versionado - https://semver.org/lang/es/<br>

Dado un número de versión MAYOR.MENOR.PARCHE, se incrementa:

la versión MAYOR cuando realizas un cambio incompatible en el API,
la versión MENOR cuando añades funcionalidad que compatible con versiones anteriores, y
la versión PARCHE cuando reparas errores compatibles con versiones anteriores.
Hay disponibles etiquetas para prelanzamiento y metadata de compilación como extensiones al formato MAYOR.MENOR.PARCHE.
