<?php
require_once 'vendor/autoload.php';

$container = \TheCodingMachine\CompositeContainer\CompositeContainerFactory::get();

var_dump($container->get('doctrine.cache'));
