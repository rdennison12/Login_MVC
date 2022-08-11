<?php
/**
 * Created by Rick Dennison
 * Date:      8/5/22
 *
 * File Name: View.php
 * Project:   Login-MVC-2022
 */

namespace Core;

use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class View
{
    /**
     * Renders the view of a Twig template.
     * @param string $template The template file
     * @param array $args Associative array of data to display in the view (optional)
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public static function renderTemplate(string $template, array $args)
    {
        echo static::getTemplate($template, $args);
    }
    /**
     * Gets the contents of a view template using Twig
     * @param string $template The template file
     * @param array $args Associative array of data to display in the view (optional)
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public static function getTemplate(string $template, array $args = []): string
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig\Environment($loader);
           /** To be uncommented as functionality is added */
//            $twig->addGlobal('current_user', Auth::getUser());
//            $twig->addGlobal('flash_messages', Flash::getMessages());
//            $twig->addGlobal('comments', Comment::getAllComments());
//            $twig->addGlobal('replies', Comment::getAllReplies());
//            $twig->addGlobal('most_recent_comments', Comment::getMostRecentComments());
        }

        return $twig->render($template, $args);
    }
}