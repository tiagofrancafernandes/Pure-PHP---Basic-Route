<?php

namespace Utils;

use Utils\RequestHelper;

class Route
{
    protected array $routes = [];
    protected array $routeNames = [];

    public function __construct(
        ?array $routes = null
    ) {
        $this->initRoutes($routes);
    }

    /**
     * function initRoutes
     *
     * @param ?array $routes = null
     * @return void
     */
    public function initRoutes(?array $routes = null): void
    {
        if ($routes && count($routes)) {
            foreach ($routes as $route) {
                if (!is_array($route) || count($route) < 3) {
                    continue;
                }
            }
        }
    }

    /**
     * function route
     *
     * @param array|string $method,
     * @param string $uri,
     * @param callable $action,
     * @param ?string $routeName = null
     *
     * return void
     */
    public function route(
        array |string $method,
        string $uri,
        callable $action,
        ?string $routeName = null
    ): void {
        $uri = trim($uri);

        $methods = is_string($method) ? [trim($method)] : $method;

        if (!is_array($methods)) {
            return;
        }

        foreach ($methods as $_method) {
            if (
                !is_string($_method) ||
                !trim($_method) ||
                !in_array(strtoupper(trim($_method)), [
                    'GET',
                    'POST',
                    'PUT',
                    'PATCH',
                    'DELETE',
                ])
            ) {
                continue;
            }

            $_method = strtoupper(trim($_method));

            $routeName = $routeName ?: static::routeNameByRouteAndUri($_method, $uri);

            $this->routeNames[$routeName] = $uri;
            $this->routes[$_method][$uri] = $action;
        }
    }

    /**
     * function listen
     *
     * @param array $request
     * @return void
     */
    public function listen(): void
    {
        $method = RequestHelper::getMethod();
        $finalUri = RequestHelper::getFinalUri();
        $callable = $this->routes[$method][$finalUri] ?? $this->routes[$method][trim($finalUri, '/')] ?? null;

        if (!is_callable($callable)) {
            Response::json([
                'message' => 'Not Found',
            ], 404);
            die();
        }

        call_user_func($callable);
    }

    /**
     * function routeNameByRouteAndUri
     *
     * @param ?string $method
     * @param ?string $uri
     *
     * @return string
     */
    protected static function routeNameByRouteAndUri(
        ?string $method,
        ?string $uri
    ): string {
        return sprintf('%s_%s', $method, $uri);
    }

    /**
     * function get
     *
     * @param string $uri,
     * @param callable $action,
     * @param ?string $routeName = null
     *
     * return void
     */
    public function get(
        string $uri,
        callable $action,
        ?string $routeName = null
    ): void {
        $this->route('GET', $uri, $action, $routeName);
    }

    /**
     * function post
     *
     * @param string $uri,
     * @param callable $action,
     * @param ?string $routeName = null
     *
     * return void
     */
    public function post(
        string $uri,
        callable $action,
        ?string $routeName = null
    ): void {
        $this->route('POST', $uri, $action, $routeName);
    }

    /**
     * function put
     *
     * @param string $uri,
     * @param callable $action,
     * @param ?string $routeName = null
     *
     * return void
     */
    public function put(
        string $uri,
        callable $action,
        ?string $routeName = null
    ): void {
        $this->route('PUT', $uri, $action, $routeName);
    }

    /**
     * function patch
     *
     * @param string $uri,
     * @param callable $action,
     * @param ?string $routeName = null
     *
     * return void
     */
    public function patch(
        string $uri,
        callable $action,
        ?string $routeName = null
    ): void {
        $this->route('PATCH', $uri, $action, $routeName);
    }

    /**
     * function delete
     *
     * @param string $uri,
     * @param callable $action,
     * @param ?string $routeName = null
     *
     * return void
     */
    public function delete(
        string $uri,
        callable $action,
        ?string $routeName = null
    ): void {
        $this->route('DELETE', $uri, $action, $routeName);
    }

    /**
     * function match
     *
     * @param array $methods,
     * @param string $uri,
     * @param callable $action,
     * @param ?string $routeName = null
     *
     * return void
     */
    public function match(
        array $methods,
        string $uri,
        callable $action,
        ?string $routeName = null
    ): void {
        $this->route($methods, $uri, $action, $routeName);
    }
}
