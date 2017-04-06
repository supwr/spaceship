<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());


$app->register(new Silex\Provider\DoctrineServiceProvider, array(
    'db.options' => array(
        'dbname' => 'spaceship',
        'user' => 'root',
        'password' => 'root',
        'host' => 'localhost',
        'port' => 3306,
        'charset' => 'utf8',
        'driver' => 'pdo_mysql'
    )
));
$app->register(new DoctrineOrmServiceProvider, array(
    'orm.em.options' => array(
        'mappings' => array(
            array(
                'type' => 'annotation',
                'namespace' => 'Entities',
                'path' => __DIR__.'/Entities',
            )
        )
    )
));
$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v6',
    'assets.named_packages' => array(
        'assets' => array('base_path' => '/web/assets'),
    ),
));

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});


return $app;
