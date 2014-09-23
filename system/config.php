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
    ),

    'breadcrumb' => array(
        /**
         * set the label for breadcrumb home
         */
        'homeLabel' => 'Home',

        /**
         * set the home url
         */
        'homeLink' => '/'
    )



);
