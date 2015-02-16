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
    public function addDocmark(\Docmark\System\Docmark $docmark)
    {
        $this->docmark = $docmark;
    }

    /**
     * check for a post push message from github and try to update our files
     */
    public function updateFromGithub()
    {
        $git = $this->taskGitStack()
            ->stopOnFail();

        // check if we have a git repo already
        if (file_exists(STORAGE_ROOT . 'github') && is_dir(STORAGE_ROOT . 'github')) {

            $git->dir(STORAGE_ROOT . 'github')
                ->pull('origin', $this->docmark->config['docRepoBranch']);

        } else {

            $git->dir(STORAGE_ROOT)
                ->cloneRepo($this->docmark->config['docRepo'], 'github')
                ->exec('cd github')
                ->checkout($this->docmark->config['docRepoBranch']);
        }

        $git->run();
    }


}
