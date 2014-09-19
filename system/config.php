<?php
/**
 * Turn24/Documenter
 *
 * Config file stores all needed configuration information
 *
 * @author  Turn24 Team <info@turn24.com>
 * @copyright  Copyright (c), Turn 24 Ltd.
 * @license MIT
 * @link http://github.com/Turn24/Documenter
 * @since  Version 0.1.0
 */

$config = array(

    /**
     * Documentation Root (Relative to root)
     */
    'doc_root' => 'docs/',

    'cache' => array( // TODO: Coming in later version
        /**
         * Enable caching. Half way house between on fly and static generation
         */
        'enable' => false,

        /**
         * Cache Lifetime in seconds
         */
        'cache_time' => 3600,

        /**
         * Cache location
         */
        'cache_root' => 'cache/'
    )






);