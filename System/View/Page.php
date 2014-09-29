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

class Page extends \DocMark\System\View
{
    /**
     * the template this view will load
     * set on child view classes
     *
     * @access public
     */
    public $template = 'page.php';

    /**
     * display the page
     *
     */
    public function display()
    {
        // generate all the data
        $this->generatePage();
        $this->generateMenu();
        $this->generateBreadcrumb();

        // process the template
        $output = $this->generateOutput();

        // send the page
        $response = new Response(
            $output,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );

        $response->prepare($this->docmark->request);

        $response->send();
    }

}
