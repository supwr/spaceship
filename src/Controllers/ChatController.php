<?php

namespace Controllers;

use Entities\Country;
use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use PDO;

class ChatController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {

        $factory = $app["controllers_factory"];
        $factory->get("/", "Controllers\ChatController::index");

        return $factory;
    }

    public function index(Application $app)
    {

      return new Response($app['twig']->render('chat/index.html.twig'));

    }

}


?>
