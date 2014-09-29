<?php
/**
 * Turn24/DocMark
 *
 * Index file, receives all requests and process
 *
 * @author  Turn24 Team <info@turn24.com>
 * @copyright  Copyright (c), Turn 24 Ltd.
 * @license MIT
 * @link http://github.com/Turn24/DocMark
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
if (file_exists('System' . DS . 'Psr4AutoloaderClass.php')) {

    require_once('System' . DS . 'Psr4AutoloaderClass.php');
} else {

    die("Fatal Error: System autoload file not found!");
}

$loader = new Psr4AutoloaderClass;
$loader->register();
$loader->addNamespace('DocMark', dirname(__FILE__));

// -------------------------------------------------------------------
// Start DocMark
// -------------------------------------------------------------------

$docmark = new \DocMark\System\Docmark();

// process the request
// will return a view object
$view = $docmark->process();

// Display the page to the user
$view->display();
