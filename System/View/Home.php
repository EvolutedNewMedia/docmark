<?php
namespace DocMark\System\View;

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

class Home extends \DocMark\System\View\Page
{
    /**
     * take the template and the variables and generate the page
     *
     * @return  string      HTML page to output
     */
    public function generateOutput()
    {
        $this->templates->addData(
            array(
                'pageTitle' => $this->docmark->config['indexTitle']
            )
        );

        return parent::generateOutput();
    }
}
