<?php

declare(strict_types=1);

namespace Hoop;

use DI\ContainerBuilder;
use Hoop\Database\DbalInstaller;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Hoop\Routing\Router;

final class App
{
    private $container;
    private $router;
    private $installer;

    public function __construct()
    {
        $builder = new ContainerBuilder();
        #$builder->useAutowiring(false);
        $builder->addDefinitions(dirname(__DIR__) . '/config/injections.php');
        $container = $builder->build();

        if (!$container instanceof ContainerInterface) {
            throw new \Exception('Container is not an instance of ContainerInterface');
        }

        $this->container = $container;
        $this->router = $this->container->get(Router::class);
        $this->installer = $this->container->get(DbalInstaller::class);
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    public function run()
    {
        $request = Request::createFromGlobals();
        $this->installer->installScripts();
        $router = $this->router->dispatch($request);
        switch ($router->getStatus()) {
            case Router::NOT_FOUND:
                $response = new Response('Page not found.', 404);
                break;
            case Router::METHOD_NOT_ALLOWED:
                $response = new Response('Method ' . $router->getStatus() . ' not allowed', 405);
                break;
            case Router::FOUND:
                [$controllerName, $method] = explode('::', $router->getHandler());
                $vars = $router->getVars();
                $controller = $this->container->get($controllerName);
                $response = call_user_func_array([$controller, $method], [$request, $vars]);
                break;
        }

        $response->prepare($request);
        $response->send();
    }
}