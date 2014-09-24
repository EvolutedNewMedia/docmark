<?php
namespace DocMark\System\View;

use Symfony\Component\HttpFoundation\Response;

/**
 * Turn24/DocMark
 *
 * Page view for functioning document pages
 *
 * @author  Turn24 Team <info@turn24.com>
 * @copyright  Copyright (c), Turn 24 Ltd.
 * @license MIT
 * @link http://github.com/Turn24/DocMark
 * @since  Version 0.1.0
 */

class Error extends \DocMark\System\View
{
    /**
     * the template this view will load
     * set on child view classes
     *
     * @access public
     */
    public $template = 'error.php';

    /**
     * fatal system error. Used by the showError() method
     * to show something really went wrong
     *
     * @access public
     */
    public $systemError = null;

    /**
     * the system error page, doesn't show any menus / breadcrumbs
     * used to error after everything appeared okay, we don't know what could have failed
     *
     * @access public
     */
    public $systemErrorTemplate = 'systemError.php';

    /**
     * display the page
     *
     */
    public function display()
    {
        if ($this->systemError) {

            $this->template = $this->systemErrorTemplate;

        } else {

            // generate all the data
            $this->generateMenu();
        }
        $this->vars['pageTitle'] = 'Page not found';

        // process the template
        $output = $this->generateOutput();

        // send the page
        $response = new Response(
            $output,
            Response::HTTP_NOT_FOUND,
            array('content-type' => 'text/html')
        );

        $response->prepare($this->docmark->request);

        $response->send();
    }

}
