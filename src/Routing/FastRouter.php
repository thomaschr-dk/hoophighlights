<?php

declare(strict_types=1);

namespace Hoop\Routing;

use FastRoute;
use Symfony\Component\HttpFoundation\Request;

final class FastRouter implements Router
{
    private $routes;

    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function dispatch(Request $request): Route
    {
        $routes = $this->routes;
        $dispatcher = FastRoute\simpleDispatcher(
            function(FastRoute\RouteCollector $r) use ($routes) {
                foreach ($routes as $route) {
                    $r->addRoute($route['method'], $route['path'], $route['controller']);
                }
            }
        );
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPathInfo());

        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                $route = new Route($routeInfo[0]);
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $route = new Route($routeInfo[0]);
                break;
            case FastRoute\Dispatcher::FOUND:
                $route = new Route($routeInfo[0], $routeInfo[1], $routeInfo[2]);
                break;
        }

        return $route;
    }
}