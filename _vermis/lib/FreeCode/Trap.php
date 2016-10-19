<?php

/**
 * =============================================================================
 * @file        FreeCode/Trap.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Trap.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Trap
 * @brief   The trap.
 */
class FreeCode_Trap
{

    protected $_stack = array();
    protected $_counter = 0;
    
    protected function __construct() {}
    
    public static function getInstance()
    {
        static $instance;
        if (!isset($instance))
            $instance = new self;
        return $instance;
    }
    
    /**
     * Add an entity to the end of the trap.
     * @param $entity
     * @return FreeCode_Trap
     */
    public function push($entity)
    {
        $this->_stack[$this->_counter++] = $entity;
        return $this;
    }
    
    /**
     * Remove the last element from the trap.
     * @return FreeCode_Trap
     */
    public function pop()
    {
        unset($this->_stack[--$this->_counter]);
        return $this;
    }
    
    /**
     * Get the last element from the trap.
     * @return mixed | null
     */
    public function getLast()
    {
        if ($this->_counter > 0)
            return $this->_stack[$this->_counter - 1];
        return null;
    }
    
    /**
     * Get the number of trapped entities.
     * @return int
     */
    public function getCount()
    {
        return $this->_counter;
    }
    
    /**
     * Clear the trap.
     * @return FreeCode_Trap
     */
    public function clear()
    {
        $this->_stack = array();
        $this->_counter = 0;
        return $this;
    }
    
}
