<?php

/*
MIT License
Copyright (...)
*/

class AltoRouter
{
    /**
     * @var array Array of all routes (incl. named routes).
     */
    protected $routes = [];

    /**
     * @var array Array of all named routes.
     */
    protected $namedRoutes = [];

    /**
     * @var string Base path of the application (useful when app is in a subfolder)
     */
    protected $basePath = '';

    /**
     * @var array Default match types (regex helpers)
     */
    protected $matchTypes = [
        'i'  => '[0-9]++',
        'a'  => '[0-9A-Za-z]++',
        'h'  => '[0-9A-Fa-f]++',
        '*'  => '.+?',
        '**' => '.++',
        ''   => '[^/\.]++'
    ];

    /**
     * Constructor
     */
    public function __construct(array $routes = [], string $basePath = '', array $matchTypes = [])
    {
        $this->addRoutes($routes);
        $this->setBasePath($basePath);
        $this->addMatchTypes($matchTypes);
    }

    /**
     * Get all routes
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Add multiple routes
     */
    public function addRoutes($routes)
    {
        if (!is_array($routes) && !$routes instanceof Traversable) {
            throw new RuntimeException('Routes should be an array or Traversable');
        }

        foreach ($routes as $route) {
            call_user_func_array([$this, 'map'], $route);
        }
    }

    /**
     * Set base path
     */
    public function setBasePath(string $basePath)
    {
        // Always ensure basePath starts with /
        if ($basePath !== '' && $basePath[0] !== '/') {
            $basePath = '/' . $basePath;
        }

        // Remove trailing slash
        $this->basePath = rtrim($basePath, '/');
    }

    /**
     * Add custom match types
     */
    public function addMatchTypes(array $matchTypes)
    {
        $this->matchTypes = array_merge($this->matchTypes, $matchTypes);
    }

    /**
     * Map a route
     */
    public function map(string $method, string $route, $target, ?string $name = null)
    {
        $this->routes[] = [$method, $route, $target, $name];

        if ($name) {
            if (isset($this->namedRoutes[$name])) {
                throw new RuntimeException("Cannot redeclare route '{$name}'");
            }
            $this->namedRoutes[$name] = $route;
        }
    }

    /**
     * Generate URL for a named route
     */
    public function generate(string $routeName, array $params = []): string
    {
        if (!isset($this->namedRoutes[$routeName])) {
            throw new RuntimeException("Route '{$routeName}' does not exist.");
        }

        $route = $this->namedRoutes[$routeName];
        $url = $this->basePath . $route;

        if (preg_match_all('`(/|\.|)

\[([^:\]

]*+)(?::([^:\]

]*+))?\]

(\?|)`', $route, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $index => $match) {
                list($block, $pre, $type, $param, $optional) = $match;

                if ($pre) {
                    $block = substr($block, 1);
                }

                if (isset($params[$param])) {
                    $url = str_replace($block, $params[$param], $url);
                } elseif ($optional && $index !== 0) {
                    $url = str_replace($pre . $block, '', $url);
                } else {
                    $url = str_replace($block, '', $url);
                }
            }
        }

        return $url;
    }

    /**
     * Match a request URL
     */
    public function match(?string $requestUrl = null, ?string $requestMethod = null)
    {
        $params = [];

        if ($requestUrl === null) {
            $requestUrl = $_SERVER['REQUEST_URI'] ?? '/';
        }

        // Remove basePath
        if ($this->basePath !== '' && strpos($requestUrl, $this->basePath) === 0) {
            $requestUrl = substr($requestUrl, strlen($this->basePath));
        }

        // Remove query string
        if (($pos = strpos($requestUrl, '?')) !== false) {
            $requestUrl = substr($requestUrl, 0, $pos);
        }

        $lastChar = $requestUrl ? $requestUrl[strlen($requestUrl) - 1] : '';

        if ($requestMethod === null) {
            $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        }

        foreach ($this->routes as $handler) {
            list($methods, $route, $target, $name) = $handler;

            if (stripos($methods, $requestMethod) === false) {
                continue;
            }

            if ($route === '*') {
                $match = true;
            } elseif ($route[0] === '@') {
                $match = preg_match('`' . substr($route, 1) . '`u', $requestUrl, $params) === 1;
            } elseif (($pos = strpos($route, '[')) === false) {
                $match = strcmp($requestUrl, $route) === 0;
            } else {
                if (strncmp($requestUrl, $route, $pos) !== 0 && ($lastChar === '/' || $route[$pos - 1] !== '/')) {
                    continue;
                }

                $regex = $this->compileRoute($route);
                $match = preg_match($regex, $requestUrl, $params) === 1;
            }

            if ($match) {
                foreach ($params as $key => $value) {
                    if (is_numeric($key)) {
                        unset($params[$key]);
                    }
                }

                return [
                    'target' => $target,
                    'params' => $params,
                    'name'   => $name
                ];
            }
        }

        return false;
    }

    /**
     * Compile route regex
     */
    protected function compileRoute(string $route): string
    {
        if (preg_match_all('`(/|\.|)

\[([^:\]

]*+)(?::([^:\]

]*+))?\]

(\?|)`', $route, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                list($block, $pre, $type, $param, $optional) = $match;

                $type = $this->matchTypes[$type] ?? $type;
                if ($pre === '.') {
                    $pre = '\.';
                }

                $optional = $optional !== '' ? '?' : null;

                $pattern = '(?:'
                    . ($pre ?: '')
                    . '(' . ($param ? "?P<$param>" : '') . $type . ')'
                    . $optional
                    . ')'
                    . $optional;

                $route = str_replace($block, $pattern, $route);
            }
        }

        return "`^$route$`u";
    }
}
