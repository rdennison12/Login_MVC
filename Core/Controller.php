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
     * @param string $name Method name
     * @param array $args Arguments passed to the method
     * @throws \Exception
     */
    public function __call(string $name, array $args)
    {
        $method = $name . 'Action';
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller" . get_class($this));
        }
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
     * @param string $url Relative URL
     */
    public function redirect(string $url)
    {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $url, true, 303);
        exit;
    }

    /**
     * Requires user to login before gaining access to protected pages
     * And remember the requested page
     */
//    public function requireLogin()
//    {
//        if (! Auth::getUser()) {
//            Flash::addMessage('Please login to access this page.', Flash::INFO);
//            Auth::rememberRequestedPage();
//            $this->redirect('/login');
//        }
//    }

}