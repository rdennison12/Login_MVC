<?php
/**
 * Created by Rick Dennison
 * Date:      8/5/22
 *
 * File Name: Home.php
 * Project:   Login-MVC-2022
 */

namespace App\Controllers;

use Core\Controller;
use Core\View;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Home extends Controller
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function indexAction()
    {
        View::renderTemplate('Home/index.html', [
            'title' => 'Home Page'
        ]);
    }
}