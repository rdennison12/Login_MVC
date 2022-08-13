<?php
/**
 * Created by Rick Dennison
 * Date:      8/2/22
 *
 * File Name: index.php
 * Project:   Login-MVC-2022
 */

/**
 * Autoloader
 */
require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Error and Exception handling
 */

/**
 * Sessions
 */

/**
 * Routing
 */
$router = new Core\Router();
/**
 * Routing Table
 * To include routes for logging in and out, and dispatching URLs
 */
$router->add('', ['controller'=>'Home', 'action'=>'index']);