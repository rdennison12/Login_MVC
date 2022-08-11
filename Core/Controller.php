<?php
/**
 * Created by Rick Dennison
 * Date:      8/5/22
 *
 * File Name: Controller.php
 * Project:   Login-MVC-2022
 * Description: Creates a middleware script in order to stop repetitive code elsewhere in the application.
 */

namespace Core;

abstract class Controller
{
    /**
     * Route parameters array from the matched route
     * @var array
     */
    protected array $route_params = [];

    /**
     * Class constructor
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }
    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     */
    public function __call(string $name, array $args)
    {
        $method = $name . 'Action';
    }

    /**
     * Before filter - called before an action method.
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     * @return void
     */
    protected function after()
    {
    }

    /**
     * Redirects user back to or to another page.
     */

    /**
     * Requires user to login before gaining access to protected pages
     * And remember the requested page
     */
}