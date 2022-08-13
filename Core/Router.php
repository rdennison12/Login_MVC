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
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
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
            return false;
        }
    }
    /**
     * Dispatches the requested route.
     *
     * @param string $url The route URL
     * @return void
     * @throws Exception
     */
    /** Helper functions
     *      a. getRoutes(): array
     *      b. getParams(): array
     *      c. convertToStudlyCaps(string $string): string
     *      d. convertToCamelCase(string $string): string
     *      e. getNamespace(): string
     */

}