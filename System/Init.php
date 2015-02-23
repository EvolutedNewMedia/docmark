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
 * @since  Version 0.3.0
 */

/**
 * debug function to make life easier
 *
 */
function debug($var, $die = false)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';

    if ($die) {

        die();
    }
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
        dirname(__DIR__),
        'UTF-8'
    )->ensureRight(DS)
);

// -------------------------------------------------------------------
// Set the storage directory (used for auto-updating docs)
// -------------------------------------------------------------------
define(
    'STORAGE_ROOT',
    ROOT . 'Storage' . DS
);

// -------------------------------------------------------------------
// Set the system autoloader
// -------------------------------------------------------------------
if (file_exists(ROOT . 'System' . DS . 'Autoloader.php')) {

    require_once(ROOT . 'System' . DS . 'Autoloader.php');
} else {

    die("Fatal Error: System autoload file not found!");
}

$loader = new Autoloader;
$loader->register();
$loader->addNamespace('DocMark', dirname(__DIR__));

// -------------------------------------------------------------------
// Start DocMark
// -------------------------------------------------------------------

$docmark = new \DocMark\System\Docmark();
