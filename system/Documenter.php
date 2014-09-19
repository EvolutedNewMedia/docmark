<?php
namespace Documenter24\System;

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;

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

        if (isset($query['0']) && ! empty($query['0'])) {

            $query['0'] = ltrim($query['0'], '/');
            $queryBits = explode('/', $query['0']);





        } else {

            // homepage
        }


        echo '<pre>';
        print_r($this->request->query->keys());
        echo '</pre>';

        return new \Documenter24\System\View();
    }
}
