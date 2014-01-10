TltAnerpvBundle
=====================================

## Instalaci�n

Asumiendo que ya ha instalado composer.phar o los binarios de composer:

``` bash
$ php composer.phar require albertogaona/anerpv-bundle 1.0.*
```


Despu�s habilite el bundle en el Kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Tlt\AnerpvBundle\TltAnerpvBundle(),
        
    );
}
```


