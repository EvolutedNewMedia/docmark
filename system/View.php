<?php
namespace Documenter24\System;

use \Symfony\Component\Finder\Finder;

/**
 * Turn24/Documenter
 *
 * Main view for standard view functionality
 *
 * @author  Turn24 Team <info@turn24.com>
 * @copyright  Copyright (c), Turn 24 Ltd.
 * @license MIT
 * @link http://github.com/Turn24/Documenter
 * @since  Version 0.1.0
 */

class View
{
    /**
     * copy of the documenter object
     *
     * @access protected
     */
    protected $documenter = null;

    /**
     * the file we are loading
     *
     * @access protected
     */
    protected $view = null;

    /**
     * the main content output
     *
     * @access protected
     */
    protected $output = null;

    /**
     * the menu array
     *
     * @access protected
     */
    protected $menu = null;

    /**
     * constructor, set the file we are loading
     *
     * @param object        Copy of the documenter object
     * @param string        The file to load
     * @param null|string   Copy of the html to output (optional)
     */
    public function __construct($documenter, $view, $output = null)
    {
        $this->documenter = $documenter;
        $this->view = $view;

        if (! empty($output)) {

            $this->output = $output;
        }
    }

    /**
     * convert the markdown page into html page
     *
     * @param   bool            Whether to return the output or not
     * @return  void|string     String output if param is true
     */
    public function generatePage($return = false)
    {
        $contents = file_get_contents($this->view);
        $output = \Michelf\MarkdownExtra::defaultTransform($contents);

        if ($return) {

            return $output;
        } else {

            $this->output = $output;
        }
    }

    /**
     * generate the menu
     *
     * @param   bool            Whether to return the output or not
     * @return  void|string     String output if param is true
     */
    public function generateMenu($return = false)
    {
        $finder = new Finder();

        // setup the root for all the doc files
        $docRoot = ROOT . $this->documenter->config['doc_root'];

        // array of menu items
        $menu = array();







    }



    public function display()
    {
        $this->generatePage();

        echo $this->output;
    }

}
