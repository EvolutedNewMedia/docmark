<?php
/**
 * Turn24/DocMark
 *
 * Config file stores all needed configuration information
 *
 * @author  Turn24 Team <info@turn24.com>
 * @copyright  Copyright (c), Turn 24 Ltd.
 * @license MIT
 * @link http://github.com/Turn24/DocMark
 * @since  Version 0.1.0
 */

$config = array(

    /**
     * set the label for home
     */
    'siteTitle' => 'WHSuite Documentation',

    /**
     * set the home url
     */
    'siteLink' => 'http://docs.whsuite.com/',

    /**
     * set the title for the main index page
     */
    'indexTitle' => 'Welcome',

    /**
     * ignore list for the menus
     * these are current global across the whole docs folder
     */
    'ignore' => array(
        'folders' => array(

        ),
        'files' => array(
            'index.md',
            'empty',
            'LICENSE',
            'README.md'
        )
    ),

    /**
     * Documentation Root (Relative to root)
     */
    'docRoot' => 'docs/',

    'cache' => array( // TODO: Coming in later version
        /**
         * Enable caching. Half way house between on fly and static generation
         */
        'enable' => false,

        /**
         * Cache Lifetime in seconds
         */
        'cacheTime' => 3600,

        /**
         * Cache location
         */
        'cacheRoot' => 'cache/'
    )



);
