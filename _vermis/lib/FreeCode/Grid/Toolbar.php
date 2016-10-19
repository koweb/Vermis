<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Toolbar.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Toolbar.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Toolbar
 * @brief   Grid toolbar.
 */
class FreeCode_Grid_Toolbar extends FreeCode_Grid_Element
{
    
    const POSITION_TOP = 'top';
    const POSITION_BOTTOM = 'bottom';
    
    protected $_elements = array();
    protected $_position = self::POSITION_BOTTOM;
    
    /**
     * Constructor.
     * @param string $id
     */
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->setDecorator(new FreeCode_Grid_Decorator_Toolbar);
    }
    
    /**
     * Add an element.
     * @param FreeCode_Grid_Element $element
     * @return FreeCode_Grid_Toolbar
     */
    public function addElement(FreeCode_Grid_Element $element)
    {
        $this->_elements[$element->getId()] = $element;
        return $this;
    }
    
    /**
     * Add a set of elements.
     * @param array $elements
     * @return FreeCode_Grid_Toolbar
     */
    public function addElements(array $elements)
    {
        foreach ($elements as $element) {
            if (!($element instanceof FreeCode_Grid_Element))
                throw new FreeCode_Exception_InvalidInput;
            $this->addElement($element);
        }
        return $this;
    }
    
    /**
     * Clear elements.
     * @return FreeCode_Grid_Toolbar
     */
    public function clearElements()
    {
        $this->_elements = array();
        return $this;
    }
    
    /**
     * Get element by id.
     * @param string $elementId
     * @return FreeCode_Grid_Element
     */
    public function getElement($elementId)
    {
        return (isset($this->_elements[$elementId])
            ? $this->_elements[$elementId] : null);
    }
    
    /*
     * Get elements.
     * @return array
     */
    public function getElements()
    {
        return $this->_elements;
    }
    
    /**
     * Remove element by id.
     * @param string $elementId
     * @return FreeCode_Grid_Toolbar
     */
    public function removeElement($elementId)
    {
        if (isset($this->_elements[$elementId]))
            unset($this->_elements[$elementId]);
        return $this;
    }
    
    /**
     * Set elements.
     * @param array $elements
     * @return FreeCode_Grid_Toolbar
     */
    public function setElements(array $elements)
    {
        return $this
            ->clearElements()
            ->addElements($elements);
    }
    
    /**
     * Set position.
     * @param $position POSITION_BOTTOM | POSITION_TOP
     * @return FreeCode_Grid_Toolbar
     */
    public function setPosition($position)
    {
        $this->_position = $position;
        return $this;
    }
    
    /**
     * Get position.
     * @return POSITION_BOTTOM | POSITION_TOP
     */
    public function getPosition()
    {
        return $this->_position;
    }
    
}
