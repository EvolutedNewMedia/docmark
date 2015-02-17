<?php
namespace DocMark\System;

/**
 * Turn24/DocMark
 *
 * Index file, receives all requests and process
 *
 * @author  Turn24 Team <info@turn24.com>
 * @copyright  Copyright (c), Turn 24 Ltd.
 * @license MIT
 * @link http://github.com/Turn24/DocMark
 * @since  Version 0.3.0
 */

class Updater extends \Robo\Tasks
{
    /**
     * copy of the DocMark object
     *
     * @access protected
     */
    protected $docmark = null;

    /**
     * add a copy of docmark to our object
     *
     * @param   object  Docmark Object
     */
    public function addDocmark(\DocMark\System\Docmark $docmark)
    {
        $this->docmark = $docmark;
    }

    /**
     * check for a post push message from github and try to update our files
     */
    public function updateFromGithub()
    {
        // check if we have a git repo already
        if (
            ! file_exists(STORAGE_ROOT . 'github') ||
            ! is_dir(STORAGE_ROOT . 'github')
        ) {

            $this->taskGitStack()
                ->stopOnFail()
                ->dir(STORAGE_ROOT)
                ->cloneRepo($this->docmark->config['docRepo'], 'github')
                ->run();
        }

        $this->taskGitStack()
            ->stopOnFail()
            ->dir(STORAGE_ROOT . 'github')
            ->checkout($this->docmark->config['docRepoBranch'])
            ->pull('origin', $this->docmark->config['docRepoBranch'])
            ->run();


        $this->moveFiles('github');
    }


    /**
     * move the updated files from source to the docroot specified in config
     *
     * @param   string      source folder in storage
     */
    protected function moveFiles($source)
    {
        if (
            empty($source) ||
            ! file_exists(STORAGE_ROOT . $source) ||
            ! is_dir(STORAGE_ROOT . $source)
        ) {

            return false;
        }

        $this->taskCopyDir([
            STORAGE_ROOT . $source => ROOT . $this->docmark->config['docRoot']
        ])->run();
    }

}
