<?php

/**
 * =============================================================================
 * @file        FreeCode/Process.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Process.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Process
 * @brief   Process runner.
 */
class FreeCode_Process
{
    
    protected $_command = null;
    protected $_stdin = null;
    protected $_stdout = null;
    protected $_stderr = null;
    protected $_cwd = null;
    protected $_env = array();
    protected $_exitCode = null;
    
    /**
     * Constructor
     * @param string $command 
     */
    public function __construct($command = null)
    {
        $this->_command = $command;
        $this->_cwd = ROOT_DIR;
    }
    
    /**
     * Set command.
     * @param string $command
     * @return FreeCode_Process
     */
    public function setCommand($command)
    {
        $this->_command = $command;
        return $this;
    }
    
    /**
     * Get command.
     * @return string
     */
    public function getCommand()
    {
        return $this->_command;
    }
    
    /**
     * Set STDIN value.
     * @param string $stdin
     * @return FreeCode_Process
     */
    public function setStdin($stdin)
    {
        $this->_stdin = (string) $stdin;
        return $this;
    }

    /**
     * Get STDIN value.
     * @return string
     */
    public function getStdin()
    {
        return $this->_stdin;
    }
    
    /**
     * Get STDOUT value.
     * @return string
     */
    public function getStdout()
    {
        return $this->_stdout;
    }
    
    /**
     * Get STDERR value.
     * @return string
     */
    public function getStderr()
    {
        return $this->_stderr;
    }
    
    /**
     * Set current working directory.
     * @param string $cwd
     * @return FreeCode_Process
     */
    public function setCwd($cwd)
    {
        $this->_cwd = $cwd;
        return $this;
    }
    
    /**
     * Get current working directory.
     * @return string
     */
    public function getCwd()
    {
        return $this->_cwd;
    }
    
    /**
     * Set environment variables.
     * @param array $env
     * @return FreeCode_Process
     */
    public function setEnv(array $env)
    {
        $this->_env = $env;
        return $this;
    }
    
    /**
     * Get environment variables.
     * @return array
     */
    public function getEnv()
    {
        return $this->_env;
    }
    
    /**
     * Get an exit code.
     * @return int
     */
    public function getExitCode()
    {
        return $this->_exitCode;
    }
    
    /**
     * Execute a process.
     * Returns an error code from a process.
     * @throws FreeCode_Exception
     * @return int
     */
    public function run()
    {
        $desc = array(
            0 => array('pipe', 'r'),
            1 => array('pipe', 'w'),
            2 => array('pipe', 'w')
        );
        
        $process = proc_open(
            $this->_command, 
            $desc, 
            $pipes, 
            $this->_cwd, 
            $this->_env);
        if (is_resource($process)) {
            
            if (!empty($this->_stdin)) {
                fwrite($pipes[0], $this->_stdin);
                fclose($pipes[0]);
            }
            
            $this->_stdout = stream_get_contents($pipes[1]);
            $this->_stderr = stream_get_contents($pipes[2]);
            
            fclose($pipes[1]);
            fclose($pipes[2]);
            
            $this->_exitCode = proc_close($process);
            return $this->_exitCode;
        
        } else {
            throw new FreeCode_Exception("proc_open failed!");
        }
        
        return false;
    }
    
}
