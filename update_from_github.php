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

if (! defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

// -------------------------------------------------------------------
// Setup DocMark
// -------------------------------------------------------------------
require_once('System' . DS . 'Init.php');

$Updater = new \DocMark\System\Updater;
$Updater->addDocmark($docmark);

$debug = print_r($docmark->request, true);

file_put_contents(STORAGE_ROOT . 'request-' . time() . '.log', $debug);

if (php_sapi_name() === 'cli') {

    $data = file_get_contents('php://stdin');
} else {

    $data = file_get_contents('php://input');
}

file_put_contents(STORAGE_ROOT . 'webhook-' . time() . '.log', print_r(json_decode($data), true));
if ($Updater->checkGithub($data)) {

    $Updater->updateFromGithub();
}
