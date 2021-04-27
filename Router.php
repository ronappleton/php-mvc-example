<?php

declare(strict_types=1);

namespace CarClub;

/**
 * Class Router
 * @package CarClub
 */
class Router
{
    /**
     * @var array
     */
    private static array $routes = [];

    /**
     * @param string $route
     * @param string $method
     * @param string $resource
     */
    public static function addRoute(string $route, string $method, string $resource): void
    {
        if (!str_contains($resource, '@')) {
            throw new \InvalidArgumentException('Resource should follow the pattern controller@method');
        }

        $resource = explode('@', $resource);
        $parameters = [];

        if (str_contains($route, '/')) {
            $routeComponents = explode('/', $route);

            $routeComponents = array_filter($routeComponents, static function ($routeComponent) {
                return !empty($routeComponent);
            });

            $route = array_shift($routeComponents);

            $componentCount = count($routeComponents);

            for ($i = 0; $i < $componentCount; $i++) {
                $newParameter['required'] = !str_contains($routeComponents[$i], '[');
                $newParameter['parameter'] = str_replace(['{', '}', '[', ']'], '', $routeComponents[$i]);
                $parameters[] = $newParameter;
            }
        }

        self::$routes[] = [
            'route' => $route ?? '/',
            'method' => $method,
            'controller' => $resource[0],
            'function' => $resource[1],
            'parameters' => $parameters,
        ];
    }

    /**
     * @throws \ReflectionException
     */
    public function resolveRequest(): void
    {
        $parsedUrl = parse_url($_SERVER['REQUEST_URI']);
        $path = str_replace(DIRECTORY_SEPARATOR . 'index.php', '', $parsedUrl['path']);

        $pathParts = array_filter(explode(DIRECTORY_SEPARATOR, $path), static function ($part) {
            return !empty($part);
        });

        $route = empty($pathParts) ? '/' : array_shift($pathParts);

        $routeData = self::findRoute($route);

        if ($routeData === null) {
            var_dump(self::$routes);
            header("HTTP/1.0 404 Not Found");
            die;
        }

        if (strtoupper($routeData['method']) !== $_SERVER['REQUEST_METHOD']) {
            header("HTTP/1.0 405 Method Not Allowed");
            die;
        }

        $controller = self::getControllerClass($routeData['controller']);

        if (!class_exists($controller)) {
            header("HTTP/1.0 503 Service Not Available");
            die;
        }

        $controller = new $controller();
        $method = $routeData['function'];
        $reflector = new \ReflectionClass($controller);

        if (!$reflector->hasMethod($method)) {
            header("HTTP/1.0 503 Service Not Available");
            die;
        }

        $reflector = new \ReflectionMethod($controller, $method);

        $parameters = $reflector->getParameters();
        $parameterCount = count($parameters);

        for ($i = 0; $i < $parameterCount; $i++) {
            $routeParam = $routeData['parameters'][$i];
            if ($routeParam['parameter'] !== $parameters[$i]->getName()) {
                header("HTTP/1.0 503 Service Not Available");
                die;
            }
        }

        echo call_user_func_array([$controller, $method], $pathParts);
    }

    /**
     * @param $route
     * @return mixed
     */
    private static function findRoute($route): mixed
    {
        foreach (self::$routes as $routeEntry) {
            if ($routeEntry['route'] === $route) {
                return $routeEntry;
            }
        }

        return null;
    }

    private static function getIndexPath(): string
    {
        $dirParts = explode(DIRECTORY_SEPARATOR, __DIR__);
        $currentDir = $dirParts[count($dirParts) - 1];

        return DIRECTORY_SEPARATOR
            . $currentDir
            . DIRECTORY_SEPARATOR
            . 'public'
            . DIRECTORY_SEPARATOR
            . 'index.php';
    }

    private static function getControllerClass($controller)
    {
        return "\\CarClub\\Controllers\\" . $controller;
    }
}
