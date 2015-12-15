definition-interop services discovery POC (aka Harmony packages)
================================================================

This repository contains a proof of concept for Harmony packages usage.
Harmony packages are:

- packages that define entries compatible with [definition-interop](https://github.com/container-interop/definition-interop/)
- packages that make these definitions automatically discoverable by the main application using [Puli](http://puli.io)

What does this repository do?
-----------------------------

This repository is used to test the whole architecture for Harmony packages.

We are including one Harmony package: [`thecodingmachine/doctrine-cache-harmony`](https://github.com/thecodingmachine/doctrine-cache-harmony/).
This package provides a Doctrine Cache service (as a [YML file](https://github.com/thecodingmachine/doctrine-cache-harmony/blob/1.0/services/services.yml)).

The YML file is automatically detected by the [Yaml definition loader](https://github.com/thecodingmachine/yaml-definition-loader), using Puli.

The Yaml definition loader provides a definition provider that is it itself automatically detected by [Yaco](https://github.com/thecodingmachine/yaco), using its [Puli discovery factory](https://github.com/thecodingmachine/yaco-discovery).

Yaco is a compiler. It will compile the definitions on the fly (the first time the application is accessed), and generate a PHP class (a container).

Finally, the generated container itself is automatically detected by a [composite container factory](https://github.com/thecodingmachine/composite-container-factory) that aggregates any PSR-11 container in the application. In this demo app, there is only one container so this step is completely optional.

To sum this:

```
Composite container >> Yaco >> YAML Definition Loader >> service.yml
```

The result
----------

This repository contains a simple `test.php` file. This `test.php` creates an instance of the (composite) container, and fetches the `doctrine.cache` entry.
On the first run, the container is generated (`.yaco/Container.php`). On the other runs, the generated container is directly used (maximum performance!)

Finally, if other dependencies are added in the `composer.json`, a custom Puli plugin is triggered that will delete the Yaco old container (no need to purge the container manually).

Try it yourself!
----------------

Simply run:

```sh
$ composer install
$ php test.php
```

You should get a `var_dump` from the Doctrine cache service.
