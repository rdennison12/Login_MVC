<?php
/**
 * Created by Rick Dennison
 * Date:      8/2/22
 *
 * File Name: Router.php
 * Project:   Login-MVC-2022
 */

namespace Core;

use Exception;

class Router
{
    /**
     * @var array
     */
    protected array $routes = [];
    /**
     * @var array
     */
    protected array $params = [];

    /** 2. Main functions
     *      a. add(string route, params=[])
     *      b. match(string url): bool
     *      c. dispatch(string url)
     *      d. removeQueryStringVariables(string url):string
     */
    /**
     * Add a route to the routing table
     *
     * @param string $route The route URL
     * @param array $params Parameters (controller, action, etc.)
     *
     * @return void
     */
    public function add(string $route, array $params = [])
    {
        // Convert the route to a regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);
        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}', '(?P<\1>[a-z]+)', $route);
        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/{([a-z]+):([^\}]+)}/', '(?P<\1>\2)', $route);
        // Add start and end delimiters, and case-insensitive flag
        $route = '/^' . $route . '$/i';
        $this->routes[$route] = $params;
    }

    /**
     * Match the route to the routes in the routing table, setting the $params
     * property if a route is found.
     *
     * @param string $url route URL
     * @return boolean true if match is found
     */
    public function match(string $url): bool
    {
        foreach ($this->routes as $route => $params) {
            // Get named capture group values
            if (preg_match($route, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * Dispatches the requested route.
     *
     * @param string $url The route URL
     * @return void
     * @throws Exception
     */
    public function dispatch(string $url)
    {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);

            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (preg_match('/action$/i', $action) == 0) {
                    $controller_object->$action();

                } else {
                    throw new Exception("Method $action (in controller $controller) not found");
                }
            } else {
                throw new Exception("Controller class $controller not found");
            }
        } else {
            throw new Exception('No route matched.', 404);
        }
    }

    /**
     * Remove the query string variables from the URL (if any). As the full
     * query string is used for the route, any variables at the end will need
     * to be removed before the route is matched to the routing table. For
     *
     * @param string $url the full URL
     *
     * @return string The URL with the query string variables removed
     */
    protected function removeQueryStringVariables(string $url): string
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (!str_contains($parts[0], '=')) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }
    /** Helper functions
     *      a. getRoutes(): array
     *      b. getParams(): array
     *      c. convertToStudlyCaps(string $string): string
     *      d. convertToCamelCase(string $string): string
     *      e. getNamespace(): string
     */
    /**
     * Helper functions
     */
    /**
     * Get all the routes from the routing table
     *
     * @return array
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * Convert the string with hyphens to StudlyCaps,
     * e.g. post-authors => PostAuthors
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToStudlyCaps(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert the string with hyphens to camelCase,
     * e.g. add-new => addNew
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToCamelCase(string $string): string
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Get the namespace for the controller class. The namespace defined in the
     * route parameters is added if present.
     *
     * @return string The request URL
     */
    protected function getNamespace(): string
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }
}