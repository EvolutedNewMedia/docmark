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

        return ($return) ? $output : $this->output = $output;
    }

    /**
     * generate the menu array
     *
     *
     * @param   bool            Whether to return the output or not
     * @return  void|string     String output if param is true
     */
    public function generateMenu($return = false)
    {
        $finder = new Finder();

        // setup the root for all the doc files
        $docRoot = \Stringy\Stringy::create(ROOT . $this->documenter->config['doc_root'], 'UTF-8');
        if ((string) $docRoot->last(1) === '/') {

            $docRoot = (string) $docRoot->substr(0, -1);
        }

        // array of menu items
        $menu = array();

        // loop docs
        $finder->in($docRoot)->depth('==0');

        $menu = $this->processMenuDirectory($finder, $docRoot, true);

        return ($return) ? $menu : $this->menu = $menu;
    }

    /**
     * process the directory of menu items
     *
     * @param   object  the finder object we are searching
     * @param   string  url path to prepend to any children
     * @param   bool    top level menu loop
     * @return  array   array of menu items
     */
    protected function processMenuDirectory($finder, $urlPath, $topLevel = false)
    {
        $menu = array();

       // loop the directories
        foreach ($finder->directories() as $item) {

            // reset the urlPath if it's the top level
            if ($topLevel) {
                $urlPath = str_replace($urlPath, '', $item->getPath());
            }

            $menuItem = $this->processMenuItem($item, $urlPath, 'dir');
            if (! empty($menuItem)) {

                $menu[] = $menuItem;
            }
        }

        foreach ($finder->files() as $item) {

            // reset the urlPath if it's the top level
            if ($topLevel) {
                $urlPath = str_replace($urlPath, '', $item->getPath());
            }

            $menuItem = $this->processMenuItem($item, $urlPath, 'file');

            if (! empty($menuItem)) {

                $menu[] = $menuItem;
            }
        }

        return $menu;
    }

    /**
     * process an individual menu item
     *
     * @param   object      the menu item - \Symfony\Component\Finder\Finder Object
     * @param   string      url path to prepend to the item
     * @param   string      type, dir or file.
     * @return  array       Menu item array to add to the main array
     */
    protected function processMenuItem($item, $urlPath, $type)
    {
        $menuItem = array();

        // Work ouit the item name
        // remove any name prefixing for order
        $itemName = $item->getBasename();
        if (preg_match("/^[0-9_]+$/", substr($itemName, 0, 1)) === 1) {

            $itemName = substr($itemName, (strpos($itemName, '_') + 1));
        }
        $itemName = str_replace('.md', '', $itemName);

        // set the name of the item
        $menuItem['label'] = $itemName;

        // check whether we are dealing with directory or file
        // file path to check differs as does the type check
        if ($type === 'dir') {

            $filePath  = $item->getRealpath() . DS . 'index.md';
            $typeCheck = $item->isDir();

        } elseif ($type === 'file') {

            $filePath = $item->getRealPath();
            $typeCheck = $item->isFile();
        } else {

            return false;
        }

        // check the file exists, set the url
        if (
            $typeCheck &&
            file_exists($filePath) &&
            is_readable($filePath)
        ) {
            $urlPath = (string) \Stringy\Stringy::create($urlPath, 'UTF-8')->ensureRight('/');
            $urlPath .= $itemName;

            $menuItem['link'] = $urlPath;

            // check active status
            if ($menuItem['link'] === $this->documenter->url) {

                // current menu item
                $menuItem['active'] = true;

            } elseif (\Stringy\Stringy::create($this->documenter->url, 'UTF-8')->startsWith($menuItem['link'])) {

                // this is a parent of the active item
                $menuItem['activeParent'] = true;
            }
        }

        // it's a directory, get any child elements
        if ($type === 'dir' && isset($urlPath)) {

            $menuItem['children'] = $this->getMenuChildren($item->getRealpath(), $urlPath);
        }

        return $menuItem;
    }

    /**
     * get any child menu items
     *
     * @param   string  directory path to check for children
     * @param   string  url path to prepend to any children
     * @return  array   array of children
     */
    protected function getMenuChildren($dirPath, $urlPath)
    {
        $menu = array();

        $finder = new Finder();

        // loop docs
        $finder->in($dirPath)->depth('==0');

        $menu = $this->processMenuDirectory($finder, $urlPath);

        return (! empty($menu)) ? $menu : false;
    }


    public function display()
    {
        $this->generatePage();
        $menu = $this->generateMenu();
        debug($menu);

        echo $this->output;
    }

}
