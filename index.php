<?php
/**
 * Snscripts/DocMark
 *
 * Index file, receives all requests and process
 *
 * @author  Mike Barlow <mike@mikebarlow.co.uk>
 * @copyright  Copyright (c), Mike Barlow.
 * @license MIT
 * @link http://github.com/Snscripts/DocMark
 * @since  Version 0.5.0
 */

if (! defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

// -------------------------------------------------------------------
// Set the root directory and add trailing slash
// -------------------------------------------------------------------
define(
    'ROOT',
    rtrim(
        dirname(__FILE__),
        '/'
    ) . DS
);

// -------------------------------------------------------------------
// Set the storage directory (used for auto-updating docs)
// -------------------------------------------------------------------
define(
    'STORAGE_ROOT',
    ROOT . 'storage' . DS
);

// -------------------------------------------------------------------
// load composer
// -------------------------------------------------------------------
if (file_exists(ROOT . 'vendor' . DS . 'autoload.php')) {
    require_once(ROOT . 'vendor' . DS . 'autoload.php');
} else {
    die("Fatal Error: Composer autoload file not found!");
}

// -------------------------------------------------------------------
// load Docmark
// -------------------------------------------------------------------
$DocMark = new \Snscripts\Docmark\Docmark;

// -------------------------------------------------------------------
// boot Docmark
// -------------------------------------------------------------------
$DocMark->boot();

// -------------------------------------------------------------------
// run Docmark
// -------------------------------------------------------------------
$DocMark->run();
