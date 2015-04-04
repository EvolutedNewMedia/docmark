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

        $this->taskMirrorDir([
            STORAGE_ROOT . $source => ROOT . $this->docmark->config['docs']['root']
        ])->run();
    }


    /**
     * check if it' a valid github push
     *
     * @todo    Add in checks for X-Hub-Signature
     * @param   object  The Object sent from github
     * @return  bool
     */
    public function checkGithub($data)
    {
        // get the repo name
        list($url, $repoName) = explode('github.com/', $this->docmark->config['docs']['repo']);
        $repoName = str_replace('.git', '', $repoName);

        // decode the json from github
        $data = json_decode($data);

        if (
            $this->docmark->request->headers->get('x-github-event') === 'push' &&
            strtolower(trim($repoName)) === strtolower(trim($data->repository->full_name)) &&
            $data->ref === 'refs/heads/' . $this->docmark->config['docs']['repoBranch']
        ) {

            return true;
        }

        return false;
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
                ->cloneRepo($this->docmark->config['docs']['repo'], 'github')
                ->run();
        }

        $this->taskGitStack()
            ->stopOnFail()
            ->dir(STORAGE_ROOT . 'github')
            ->checkout($this->docmark->config['docs']['repoBranch'])
            ->pull('origin', $this->docmark->config['docs']['repoBranch'])
            ->run();

        $this->moveFiles('github');
    }

}
