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
     * set the theme to use
     */
    'themeName' => 'default',

    /**
     * set the label for home
     */
    'siteTitle' => 'DocMark Documentation',

    /**
     * set the home url
     */
    'siteLink' => 'http://doc-mark.com/',

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

    'docs' => array(
        /**
         * Documentation Root (Relative to root)
         */
        'root' => 'docs/',

        /**
         * URL to the repo containing your docs, for use with post commit hooks
         * to auto update your documentation.
         * n.b. If authorisation is needed, include these details within the repo URL.
         */
        'repo' => '',

        /**
         * Supported Repo types are: GIT, GITHUB, GITLAB. 
         * Using repoType GIT with Github and Gitlab will work it just won't check if the webhook
         * was called for the right branch
         */
        'repoType' => "GITHUB",

        /**
         * The branch to pull from
         */
        'repoBranch' => 'master'
    ),

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
