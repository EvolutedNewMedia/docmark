<?php
/**
 * Turn24/Documenter
 *
 * Index file, receives all requests and process
 *
 * @author  Turn24 Team <info@turn24.com>
 * @copyright  Copyright (c), Turn 24 Ltd.
 * @license MIT
 * @link http://github.com/Turn24/Documenter
 * @since  Version 0.1.0
 */

/**
 * debug function to make life easier
 *
 */
function debug($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

if (! defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

// -------------------------------------------------------------------
// load composer
// -------------------------------------------------------------------
if (file_exists('vendor' . DS . 'autoload.php')) {

    require_once('vendor' . DS . 'autoload.php');
} else {

    die("Fatal Error: Composer autoload file not found!");
}

// -------------------------------------------------------------------
// Set the root directory and add trailing slash
// -------------------------------------------------------------------
define(
    'ROOT',
    \Stringy\Stringy::create(
        dirname(__FILE__),
        'UTF-8'
    )->ensureRight('/')
);

// -------------------------------------------------------------------
// Set the system autoloader
// -------------------------------------------------------------------
if (file_exists('system' . DS . 'Psr4AutoloaderClass.php')) {

    require_once('system' . DS . 'Psr4AutoloaderClass.php');
} else {

    die("Fatal Error: System autoload file not found!");
}

$loader = new Psr4AutoloaderClass;
$loader->register();
$loader->addNamespace('Documenter24', dirname(__FILE__));

// -------------------------------------------------------------------
// Start Documenter24
// -------------------------------------------------------------------

$documenter = new \Documenter24\System\Documenter();

// process the request
// will return a view object
$view = $documenter->process();

// Display the page to the user
$view->display();
