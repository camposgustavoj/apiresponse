# Ministerio de Justicia y Derecho Humanos.

## Instalación del paquete, por ahora la instalación se realiza manualmente.

## Opcion via repositories, agregar al composer.json

    "repositories": [
        {"type": "package", 
            "package": { 
                "name": "mjydh/apiresponse", 
                "version": "1.0.2", 
                "source": {
                    "url": "https://github.com/camposgustavoj/apiresponse.git",
                    "type": "git",
                    "reference": "main" 
                }
            }
        }
    ],
    
## ejecutar composer require mjydh/httpclientbundle

1 - Descargar el proyecto desde https://github.com/camposgustavoj/apiresponse.git <br>
2 - crear la carpeta mjydh dentro de vendor y colocar el paquete descargado dentro. <br>
3 - agregar en el autoload / psr-4 del composer.json del proyecto la referencia al paquete 

```json
"autoload": {
        "psr-4": {
        "MJYDH\\ApiResponseBundle\\": "vendor/mjydh/ApiResponseBundle"
    },
},
```

4 - ejecutar <br>
```bash
composer dump-autoload -o
```

En caso de no poder ejecutar el dump-autoload (como sucede en adminformel y formularioelectronico), se debe agregar en \vendor\composer\autoload_psr4.php la siguiente linea
```php
'MJYDH\\ApiResponseBundle\\' => array($vendorDir . '/mjydh/ApiResponseBundle'),
```

5 - Symfony < 3.4 Agregar en el AppKernel.php<br>

```php
new MJYDH\ApiResponseBundle\ApiResponseBundle(),
```
5 - Symfony > 4 Agregar en el config/bundles.php<br>

```php
MJYDH\ApiResponseBundle\ApiResponseBundle::class=>['all'=>true]
```