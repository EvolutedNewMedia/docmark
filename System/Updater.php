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
     * check if it' a valid push
     *
     * @todo    Add in checks for X-Hub-Signature
     * @param   object  The Object sent from github
     * @return  bool
     */
    public function isValidPush($data)
    {
        // If repoType is not GITHUB or GITLAB then we can't check it is a valid push 
        // so just return true. 
        if($this->docmark->config['docs']['repoType'] != "GITHUB" || $this->docmark->config['docs']['repoType'] != "GITLAB") {
            return true;
        }


        // get the repo name
        $repoName = parse_url($this->docmark->config['docs']['repo'], PHP_URL_PATH);
        $repoName = str_replace('.git', '', $repoName);

        //Remove proceeding / if it is there 
        if (substr($repoName, 0, 1) == '/') {
            $repoName = substr($repoName, 1);
        }

        // decode the json from github
        $data = json_decode($data);

        // Set which header to look for based on the repoType
        switch ($this->docmark->config['docs']['repoType']) {
            case 'GITHUB':
                $header = 'x-github-event'
                break;
            
            default:
                $header = 'X-Gitlab-Event'
                break;
        }

        if (
            $this->docmark->request->headers->get($header) === 'push' &&
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
    public function updateFromGit()
    {
        $repoType = $this->docmark->config['docs']['repoType'];

        // check if we have a git repo already
        if (
            ! file_exists(STORAGE_ROOT . $repoType) ||
            ! is_dir(STORAGE_ROOT . $repoType)
        ) {

            $this->taskGitStack()
                ->stopOnFail()
                ->dir(STORAGE_ROOT)
                ->cloneRepo($this->docmark->config['docs']['repo'], $repoType)
                ->run();
        }

        $this->taskGitStack()
            ->stopOnFail()
            ->dir(STORAGE_ROOT . $repoType)
            ->checkout($this->docmark->config['docs']['repoBranch'])
            ->pull('origin', $this->docmark->config['docs']['repoBranch'])
            ->run();

        $this->moveFiles($repoType);
    }

}
