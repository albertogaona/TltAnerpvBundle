TltAnerpvBundle
=====================================

## Instalación

Asumiendo que ya ha instalado composer.phar o los binarios de composer:

``` bash
$ php composer.phar require albertogaona/anerpv-bundle 1.0.*
```


Después habilite el bundle en el Kernel:

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

### Config reference

- [Configuration reference](configuration-reference.md) for a reference on the available configuration options
- [Annotations reference](annotations-reference.md) for a reference on on the available configurations through annotations

### Example application(s)

The following bundles/applications use the FOSRestBundle and can be used as a
guideline:

- The LiipHelloBundle provides several examples for the RestBundle:
  https://github.com/liip/LiipHelloBundle

- There is also a fork of the Symfony2 Standard Edition that is configured to
  show the LiipHelloBundle examples:
  https://github.com/liip-forks/symfony-standard/tree/techtalk

- The FOSCommentBundle uses FOSRestBundle for its api:
  https://github.com/FriendsOfSymfony/FOSCommentBundle

- The Symfony2 Rest Edition provides a complete example of how to build a 
  controller that works for both HTML as well as JSON/XML:
  https://github.com/gimler/symfony-rest-edition
