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

if (php_sapi_name() === 'cli') {

    $data = file_get_contents('php://stdin');
} else {

    $data = file_get_contents('php://input');
}

// Check if we need to update the docs, if the repo type is GIT then we can't validate the push 
// so we just run update. Otherwise check it is a valid change to the docs.
if ($Updater->isValidPush($data)) {
    $Updater->updateFromGit();
}
