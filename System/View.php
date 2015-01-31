<?php
namespace DocMark\System;

use \Symfony\Component\Finder\Finder;

/**
 * Turn24/DocMark
 *
 * Main view for standard view functionality
 *
 * @author  Turn24 Team <info@turn24.com>
 * @copyright  Copyright (c), Turn 24 Ltd.
 * @license MIT
 * @link http://github.com/Turn24/DocMark
 * @since  Version 0.1.0
 */

abstract class View
{
    /**
     * the template this view will load, relative to the templates dir
     * set on child view classes
     *
     * @access public
     */
    public $template = null;

    /**
     * copy of the DocMark object
     *
     * @access protected
     */
    protected $docmark = null;

    /**
     * the file we are loading
     *
     * @access protected
     */
    protected $view = null;

    /**
     * the template engine
     *
     * @access protected
     */
    protected $templates = null;

    /**
     * the markdown converter
     *
     * @access protected
     */
    protected $converter = null;

    /**
     * display method to determine how each page template should
     * handle the data / it's templates
     */
    abstract public function display();

    /**
     * constructor, set the file we are loading
     *
     * @param object        Copy of the DocMark object
     * @param object        Copy of the Markdown Converter object
     * @param object        Copy of the Plates Template Engine
     * @param string        The file to load
     */
    public function __construct($docmark, $converter, $templates, $view)
    {
        $this->docmark = $docmark;
        $this->converter = $converter;
        $this->templates = $templates;
        $this->view = $view;

        // setup some default data variables
        $this->templates->addData(
            array(
                'site' => array(
                    'title' => $this->docmark->config['siteTitle'],
                    'link' => $this->docmark->config['siteLink']
                ),
                'theme' => $this->docmark->config['themeName']
            )
        );
    }

    /**
     * take the template and the variables and generate the page
     *
     * @return  string      HTML page to output
     */
    public function generateOutput()
    {
        $template = $this->docmark->config['themeName'] . '::' .$this->template;

        try {

            if ($this->templates->exists($template)) {

                return $this->templates->render($template);
            } else {

                $this->showError();
            }

        } catch (\Exception $e) {

            $this->showError();
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
        $page = $this->converter->convertToHtml($contents);
        $this->templates->addData(
            array(
                'page' => $page
            )
        );

        if ($return) {

            return $page;
        }
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
        $docRoot = \Stringy\Stringy::create(ROOT . $this->docmark->config['docRoot'], 'UTF-8');
        if ((string) $docRoot->last(1) === '/') {

            $docRoot = (string) $docRoot->substr(0, -1);
        }

        // array of menu items
        $menu = array();

        // loop docs
        $finder->in($docRoot)->depth('==0')->sortByName();

        $menu = $this->processMenuDirectory($finder, $docRoot, true);

        $this->templates->addData(
            array(
                'menu' => $menu
            )
        );

        if ($return) {

            return $menu;
        }
    }

    /**
     * process the directory of menu items
     *
     * @param   object  the finder object we are searching
     * @param   string  url path to prepend to any children
     * @param   bool    top level menu loop
     * @return  array   array of menu items
     */
    protected function processMenuDirectory($finder, $urlPathOrig, $topLevel = false)
    {
        $menu = array();

       // loop the directories
        foreach ($finder->directories() as $item) {

            // check for ignores
            if (in_array($item->getBasename(), $this->docmark->config['ignore']['folders'])) {

                continue;
            }

            // reset the urlPath if it's the top level
            $urlPath = $urlPathOrig;
            if ($topLevel) {
                $urlPath = str_replace($urlPath, '', $item->getPath());
            }

            $menuItem = $this->processMenuItem($item, $urlPath, 'dir');
            if (! empty($menuItem)) {

                $menu[] = $menuItem;
            }
        }

        foreach ($finder->files() as $item) {

            // check for ignores
            if (in_array($item->getBasename(), $this->docmark->config['ignore']['files'])) {

                continue;
            }

            // reset the urlPath if it's the top level
            $urlPath = $urlPathOrig;
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
        $menuItem['label'] = (string) \Stringy\Stringy::create($itemName, 'UTF-8')->humanize();

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
            if ($menuItem['link'] === $this->docmark->url) {

                // current menu item
                $menuItem['active'] = true;

                // set the page title
                $this->templates->addData(
                    array(
                        'pageTitle' => $menuItem['label']
                    )
                );

            } elseif (\Stringy\Stringy::create($this->docmark->url, 'UTF-8')->startsWith($menuItem['link'])) {

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
        $finder->in($dirPath)->depth('==0')->sortByName();

        $menu = $this->processMenuDirectory($finder, $urlPath);

        return (! empty($menu)) ? $menu : false;
    }

    /**
     * generate the breadcrumb array
     * Uses the menu array at $this->menu
     * unless an array was passed (incase the menu was returned and not set)
     *
     * @param   bool            Whether to return the output or not
     * @param   array           array of menu options, should have active / activeParent elements set
     * @return  void|string     String output if param is true
     */
    public function generateBreadcrumb($return = false, $menu = null)
    {
        if (empty($menu)) {

            $vars = $this->templates->getData();
            $menu = $vars['menu'];
        }

        // set the home item
        $breadcrumb = array(
            array(
                'label' => $this->docmark->config['siteTitle'],
                'link' => $this->docmark->config['siteLink']
            )
        );

        // loop the menu
        if (! empty($menu)) {

            foreach ($menu as $item) {

                if (
                    (isset($item['activeParent']) && $item['activeParent']) ||
                    (isset($item['active']) && $item['active'])
                ) {

                    $breadcrumb[] = array(
                        'label' => $item['label'],
                        'link' => $item['link']
                    );
                }

                // if it's jsut an active parent check children
                if (
                    isset($item['activeParent']) && $item['activeParent'] &&
                    isset($item['children']) && ! empty($item['children'])
                ) {

                    $this->getBreadcrumbChildren($breadcrumb, $item['children']);
                }
            }
        }

        $this->templates->addData(
            array(
                'breadcrumb' => $breadcrumb
            )
        );

        if ($return) {

            return $breadcrumb;
        }
    }

    /**
     * recursive function for getting breadcrumb children
     *
     * @param   array   the current breadcrumb items, passed by reference
     * @param   array   the child elements to check
     */
    protected function getBreadcrumbChildren(&$breadcrumb, $menu)
    {
        // loop the menu
        if (! empty($menu)) {

            foreach ($menu as $item) {

                if (
                    (isset($item['activeParent']) && $item['activeParent']) ||
                    (isset($item['active']) && $item['active'])
                ) {

                    $breadcrumb[] = array(
                        'label' => $item['label'],
                        'link' => $item['link']
                    );
                }

                // if it's jsut an active parent check children
                if (
                    isset($item['activeParent']) && $item['activeParent'] &&
                    isset($item['children']) && ! empty($item['children'])
                ) {

                    $this->getBreadcrumbChildren($breadcrumb, $item['children']);
                }
            }
        }
    }

    /**
     * get out of jail error function
     * if something happens while processing the view
     * and it was otherwise "ok" can use this to show a 404
     *
     */
    public function showError()
    {
        $view = new \DocMark\System\View\Error($this->docmark, $this->converter, $this->templates, false);

        $view->systemError = true;
        $view->display();
    }
}
