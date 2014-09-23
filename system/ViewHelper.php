<?php
namespace DocMark\System;

/**
 * Turn24/DocMark
 *
 * View Helper for processing templates
 * and also including other templates
 *
 * @author  Turn24 Team <info@turn24.com>
 * @copyright  Copyright (c), Turn 24 Ltd.
 * @license MIT
 * @link http://github.com/Turn24/DocMark
 * @since  Version 0.1.0
 */

class ViewHelper
{
    /**
     * hold all the variables we assign to the templates
     * new ones will override old data
     */
    protected $variables = array();


    /**
     * include another element template
     *
     * @param   string    Element to load
     * @param   array     Array of variables to make available
     * @return  string    The compiled page
     */
    public function includeTemplate($element, $variables = array())
    {
        $elementPath = ROOT . 'templates' . DS . 'elements' . DS . $element;

        if (file_exists($elementPath) && is_readable($elementPath)) {

            return $this->processTemplate($elementPath, $variables);
        }

        return '';
    }

    /**
     * process the given template
     *
     * @param   string      Path to the template to load
     * @param   array       Array of variables to make available
     * @return  string      The compiled page
     */
    public function processTemplate($template, $variables)
    {
        $this->variables = array_merge($this->variables, $variables);

        // extract the variables
        extract($this->variables);

        // we're just fetching the contents, get and eval them so we can return the output
        $tpl = file_get_contents($template);

        ob_start();
        eval("?>".$tpl);
        $tpl = ob_get_contents();
        ob_end_clean();

        return $tpl;
    }
}
