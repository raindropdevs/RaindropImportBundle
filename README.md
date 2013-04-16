# Raindrop Import Bundle

[![Build Status](https://travis-ci.org/raindropdevs/RaindropImportBundle.png?branch=master)](https://travis-ci.org/raindropdevs/RaindropImportBundle)

This bundle adds support for import data from different sources (csv, yml, xml ...) and map them to database entities.

### **INSTALLATION**:

First add the dependency to your composer.json` file:

    "require": {
        ...
        "raindrop/import-bundle": "dev-master"
    },

Then install the bundle with the command:

    php composer.phar update

Enable the bundle in your application kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Raindrop\ImportBundle\RaindropImportBundle(),
    );
}
```

Now the bundle is enabled.
