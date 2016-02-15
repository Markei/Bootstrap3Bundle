README
======

About this bundle
-----------------

This bundle provides an easy and basic way to add Bootstrap 3 to your Symfony 
project. It does not require Assetic, NPM, Sass of LESS.

Installation
------------

**1** Add to composer.json to the `require` key

``` shell
    $composer require markei/bootstrap3bundle
``` 

**2** Register the bundle in ``app/AppKernel.php``

``` php
    $bundles = array(
        // ...
        new Markei\Bootstrap3Bundle\MarkeiBootstrap3Bundle(),
    );
```

**3** Run the following command to copy the files

``` shell
    $php bin/console markei:bootstrap3:copy
```

**4** Use it in your code

``` html
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    ...
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
```

Configuration
-------------

The following options can be controlled via app/config/config.yml

``` yml
    markei_bootstrap3:
        src_bootstrap_css: '%kernel.root_dir%/../vendor/twbs/bootstrap/dist/css/bootstrap.min.css'
        src_bootstrap_js: '%kernel.root_dir%/../vendor/twbs/bootstrap/dist/js/bootstrap.min.js'
        src_bootstrap_fonts: '%kernel.root_dir%/../vendor/twbs/bootstrap/fonts'
        src_jquery_js: '%kernel.root_dir%/../vendor/jquery/jquery.min.js'
        dst_bootstrap_css: %kernel.root_dir%/../web/css/bootstrap.min.css
        dst_bootstrap_js: %kernel.root_dir%/../web/js/bootstrap.min.js
        dst_bootstrap_fonts: %kernel.root_dir%/../web/fonts
        dst_jquery_js: %kernel.root_dir%/../web/js/jquery.min.js
```

Automatic copy on update and install
------------------------------------

Add the copy job to the scripts section of your composer.json
``` 
    "scripts": {
        "post-install-cmd": [
            ...
            "php bin/console markei:bootstrap3:copy"
        ],
        "post-update-cmd": [
            ...
            "php bin/console markei:bootstrap3:copy"
        ]
    },
```