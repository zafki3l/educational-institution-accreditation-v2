<?php

namespace Core;

use App\Shared\Middlewares\CSRF_Authenticator;
use Exception;
use ReflectionMethod;

/** 
 * Handles route registration and request dispatching
 * Supports GET, POST, PUT, PATCH, DELETE HTTP methods
 */
class Router
{
    private array $routes = [];
    private array $middlewares = [];

    public function middleware(array $middlewares): self
    {
        $this->middlewares = $middlewares;
        return $this;
    }

    /**
     * Register a GET route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function get(string $path, mixed $action): void
    {
        $this->add('GET', $path, $action);
    }

    /**
     * Register a POST route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function post(string $path, mixed $action): void
    {
        $this->add('POST', $path, $action);
    }

    /**
     * Register a PUT route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function put(string $path, mixed $action): void
    {
        $this->add('PUT', $path, $action);
    }

    /**
     * Register a PATCH route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function patch(string $path, mixed $action): void
    {
        $this->add('PATCH', $path, $action);
    }

    /**
     * Register a DELETE route
     * @param string $path
     * @param mixed $callback
     * @return void
     */
    public function delete(string $path, mixed $action): void
    {
        $this->add('DELETE', $path, $action);
    }

    private function add(string $method, string $path, mixed $action): void
    {
        $this->routes[$method][$path] = [
            'action' => $action,
            'middlewares' => $this->middlewares
        ];

        $this->middlewares = [];
    }

    /**
     * Dispatch the request to the matched route
     * 
     * @param string $path
     * @param string $method
     * @return void
     */
    /**
     * Dispatch the request to the matched route
     * 
     * @param string $path
     * @param string $method
     * @return void
     */
    public function dispatch(string $path, string $method): Response
    {
        // Override PUT/PATCH and DELETE method
        $method = $this->overrideMethod($method);

        $result = $this->match($path, $method);

        if (!$result) {
            throw new Exception('Page not found');
        }

        [$route, $params] = $result;

        $middlewares = $route['middlewares'];
        if (!empty($middlewares)) {
            foreach ($middlewares as $middlwareClass) {
                $middleware = new $middlwareClass();
                $middleware->handle();
            }
        }

        if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $middleware = new CSRF_Authenticator();
            $middleware->handle();
        }

        $action = $route['action'];
        if (is_array($action)) {
            [$class, $action] = $action;

            $class = App::resolve($class);

            return $this->invokeAction($class, $action, $params);
        }

        return $this->invokeClosure($action, $params);
    }

    /**
     * Match the given path with a registered route
     * 
     * @param string $path
     * @param string $method
     * @return array<array|mixed|null>|null
     */
    private function match(string $path, string $method): mixed
    {
        foreach ($this->routes[$method] as $route => $callback) {
            preg_match_all('#\{([^/]+)\}#', $route, $paramNames);

            $pattern = preg_replace('#\{[^/]+\}#', '([^/]+)', $route);

            if (preg_match("#^$pattern$#", $path, $matches)) {
                array_shift($matches);

                $params = [];
                foreach ($paramNames[1] as $i => $name) {
                    $params[$name] = $matches[$i];
                }

                return [$callback, $params];
            }
        }

        return null;
    }

    /**
     * Allow method override via hidden from input '_method'
     * @param string $method
     * @return string
     */
    private function overrideMethod(string $method): string
    {
        $override = isset($_POST['_method']) ? $_POST['_method'] : null;

        if ($method === 'POST' && $override && $this->isAllowedMethod($override)) {
            return strtoupper($override);
        }

        return $method;
    }

    /**
     * Check if the override method is allowed
     * @param string $override
     * @return bool
     */
    private function isAllowedMethod(string $override): bool
    {
        return $override === 'PUT' || $override === 'DELETE' || $override === 'PATCH';
    }

    private function invokeAction(object $controller, string $method, array $routeParams): mixed
    {
        if (!method_exists($controller, $method)) {
            throw new Exception("Method $method not found in " . $controller::class);
        }

        $reflection = new ReflectionMethod($controller, $method);
        $dependencies = [];

        foreach ($reflection->getParameters() as $param) {
            $type = $param->getType();
            $name = $param->getName();

            // Class → container
            if ($type && !$type->isBuiltin()) {
                $dependencies[] = App::resolve($type->getName());
            }
            // Route param theo tên
            elseif (isset($routeParams[$name])) {
                $dependencies[] = $routeParams[$name];
            }
            // Default value
            elseif ($param->isDefaultValueAvailable()) {
                $dependencies[] = $param->getDefaultValue();
            }
            else {
                throw new Exception("Cannot resolve parameter \${$name}");
            }
        }

        return $reflection->invokeArgs($controller, $dependencies);
    }

    private function invokeClosure(callable $closure, array $routeParams): mixed
    {
        $reflection = new \ReflectionFunction($closure);
        $dependencies = [];

        foreach ($reflection->getParameters() as $param) {
            $type = $param->getType();
            $name = $param->getName();

            if ($type && !$type->isBuiltin()) {
                $dependencies[] = App::resolve($type->getName());
            }
            elseif (isset($routeParams[$name])) {
                $dependencies[] = $routeParams[$name];
            }
            elseif ($param->isDefaultValueAvailable()) {
                $dependencies[] = $param->getDefaultValue();
            }
            else {
                throw new Exception("Cannot resolve parameter \${$name}");
            }
        }

        return $closure(...$dependencies);
    }
}
