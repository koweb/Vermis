<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Element.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Element.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Element
 * @brief   Grid element.
 */
abstract class FreeCode_Grid_Element
{
    
    const FLOAT_LEFT = 'left';
    const FLOAT_RIGHT = 'right';
    
    protected $_id = null;
    protected $_decorator = null;
    protected $_float = self::FLOAT_RIGHT;
    
    /**
     * Construct.
     * @param string $id
     */
    public function __construct($id = null)
    {
        $this->_id = $id;
    }
    
    /**
     * Set id.
     * @param string $id
     * @return FreeCode_Grid_Element
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }
    
    /**
     * Get id.
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * Set decorator.
     * @param $decorator
     * @return FreeCode_Grid
     */
    public function setDecorator(FreeCode_Grid_Decorator_Abstract $decorator)
    {
        $this->_decorator = $decorator;
        return $this;
    }
    
    /**
     * Get decorator.
     * @return FreeCode_Grid_Decorator_Abstract
     */
    public function getDecorator()
    {
        return $this->_decorator;
    }
    
    public function setFloat($float)
    {
        $this->_float = $float;
        return $this;
    }
    
    public function getFloat()
    {
        return $this->_float;
    }
    
}
