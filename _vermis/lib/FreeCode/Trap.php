<?php

/**
 * =============================================================================
 * @file        FreeCode/Trap.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Trap.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
