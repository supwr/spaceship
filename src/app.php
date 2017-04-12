<?php

use Silex\Application;
use Silex\Provider\AssetServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Services\User;


$app = new Application();
$app->register(new ServiceControllerServiceProvider());
$app->register(new AssetServiceProvider());
$app->register(new TwigServiceProvider());
$app->register(new HttpFragmentServiceProvider());


$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v6',
    'assets.named_packages' => array(
        'assets' => array('base_path' => '/web/assets'),
    ),
));

// $app["pdo.mongo.connection"] = function(){
//   return new PDO("doctrine-orm-service-provider")
// };

// $app["pdo.mysql.server"] = getenv()
//
$app["pdo.mysql.connection"] = function(){
  return new PDO('mysql:host='.getenv("MYSQL_SERVER").';dbname='.getenv("MYSQL_DB"), getenv("MYSQL_USER"), getenv("MYSQL_PWD"));
};

$app["user.service"] = function() use ($app){
  $userService = new Services\User();
  $userService->setPdo($app["pdo.mysql.connection"]);

  return $userService;
};

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    return $twig;
});


return $app;
