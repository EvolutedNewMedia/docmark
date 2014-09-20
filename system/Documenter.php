<?php
namespace Documenter24\System;

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\Finder\Finder;

/**
 * Turn24/Documenter
 *
 * Main documenter file that handles the requires and
 * processes accordingly
 *
 * @author  Turn24 Team <info@turn24.com>
 * @copyright  Copyright (c), Turn 24 Ltd.
 * @license MIT
 * @link http://github.com/Turn24/Documenter
 * @since  Version 0.1.0
 */

class Documenter
{
    /**
     * holds all the configuration settings
     *
     * @access public
     */
    public $config = array();

    /**
     * hold the request object
     *
     * @access public
     */
    public $request = null;

    /**
     * start up the system, load configs etc...
     *
     * @access public
     */
    public function __construct()
    {
        // load up the configuration
        $this->loadConfig();

        // load up the request
        $this->request = Request::createFromGlobals();
    }

    /**
     * load up the config and set to the config property
     *
     * @access protected
     */
    protected function loadConfig()
    {
        $path = ROOT . 'system' . DS . 'Config.php';

        if (file_exists($path) && is_readable($path)) {

            require_once($path);

            $this->config = $config;
        } else {

            die('Fatal Error: The config could not be loaded');
        }
    }

    /**
     * process the request so we can work out
     * what view we need to process and serve
     *
     * @access public
     * @return object   Documenter24\System\View Object
     */
    public function process()
    {
        $query = $this->request->query->keys();

        // setup the root for all the doc files
        $docRoot = ROOT . $this->config['doc_root'];

        if (isset($query['0']) && ! empty($query['0'])) {

            $query['0'] = ltrim($query['0'], '/');
            $queryBits = explode('/', $query['0']);

        } else {

            // homepage
            $queryBits = array();
        }

        $path = $this->findFile($queryBits, $docRoot);


        return new \Documenter24\System\View($this, $path);
    }


    /**
     * loop the query bits to try and find the path
     *
     * @param  array     Current array of query bits
     * @param  string    File path
     * @return string    Path to the file to load
     */
    protected function findFile($queryBits, $path)
    {
        if (! empty($queryBits)) {

            // make sure the path has a trailing slash
            $path = (string) \Stringy\Stringy::create($path, 'UTF-8')->ensureRight('/');

            // get the next bit to find
            $bitName = array_shift($queryBits);

            // set the directory
            $finder = new Finder();
            $dirList = $finder->in($path)->name('*' . $bitName . '*');

            if ($dirList->count() > 0) {

                foreach ($dirList as $item) {

                    $filename = $item->getFilename();
                    $path .= $filename;
                    break;
                }

                $path = $this->findFile($queryBits, $path);

                return $path;
            }

        } else {

            // we have no bits left.
            // check the path we have if it's valid
            $splFile = new \SplFileInfo($path);

            if ($splFile->isFile()) {

                return $path;

            } elseif ($splFile->isDir()) {

                // we're in a directory, check for an index.md file
                $finder = new Finder();
                $finder->in($path)->name('index.md');

                if ($finder->count() == 1) {

                    // make sure the path has a trailing slash
                    $path = (string) \Stringy\Stringy::create($path, 'UTF-8')->ensureRight('/');
                    $path .= 'index.md';

                    return $path;
                }
            }
        }

        // if we're here, something went wrong
        // return false
        return false;
    }

}
