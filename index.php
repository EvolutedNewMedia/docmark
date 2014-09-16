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
        dirname(__FILE__)
    )->ensureRight('/')
);

// -------------------------------------------------------------------
// Set the system autoloader
// -------------------------------------------------------------------
if (file_exists('system' . DS . 'SplClassLoader.php')) {

    require_once('system' . DS . 'SplClassLoader.php');
} else {

    die("Fatal Error: Composer autoload file not found!");
}

$classLoader = new SplClassLoader('Documenter24', dirname(__FILE__));
$classLoader->register();

// -------------------------------------------------------------------
// Start Documenter24
// -------------------------------------------------------------------

$documenter = new \Documenter24\System\Documenter();

echo '<pre>';
print_r($documenter->request);
echo '</pre>';


