YAML Configuration Loader
================

Es posible añadir parametros desde PHP y usarlos en la configuración.

```php
FactoryLoader::factory()->add( ['app_directory' => __DIR__] );
```

Asi ya disponemos de un nuevo parámetro en nuestra archivo yaml de configuración

```yaml
doctrine:
    annotation:
        paths: '%app_directory%/library/Entity'
```

Dispone de una pequeña funcionalidad que simula la asignación de variables de symfony2 configuration component.
Es posible declarar un nuevo parametro asignadole el valor de otro.

```yaml
doctrine:
    dbname:             %parameters.database_name%
    host:               localhost
    port:               %parameters.database_port%
    user:               root
    password:           %parameters.database_password%
    driver:             pdo_mysql
    charset:            %parameters.charset%

parameters:
   database_name: test
   database_password: passwordtest
   database_port: 3307
```
