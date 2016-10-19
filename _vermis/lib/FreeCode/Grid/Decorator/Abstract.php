<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Decorator/Abstract.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Abstract.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Decorator_Abstract
 * @brief   Grid decorator.
 */
abstract class FreeCode_Grid_Decorator_Abstract
{

    protected $_view = null;
    protected $_grid = null;
    protected $_column = null;
    protected $_row = null;
    protected $_element = null;

    /**
     * Set view.
     * @param Zend_View_Interface $view
     * @return FreeCode_Grid_Decorator_Abstract
     */
    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
        return $this;
    }
    
    /**
     * Get view.
     * @return Zend_View_Interface
     */
    public function getView()
    {
        if ($this->_view == null) {
            $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
            $this->setView($viewRenderer->view);
        }
        return $this->_view;
    }
    
    /**
     * Set grid.
     * @param FreeCode_Grid $grid
     * @return FreeCode_Grid_Decorator_Abstract
     */
    public function setGrid(FreeCode_Grid $grid) 
    {
        $this->_grid = $grid;
        return $this;    
    }
    
    /**
     * Get grid.
     * @return FreeCode_Grid
     */
    public function getGrid()
    {
        return $this->_grid;
    }
    
    /**
     * Set column
     * @param FreeCode_Grid_Column $column
     * @return FreeCode_Grid_Decorator_Abstract
     */
    public function setColumn(FreeCode_Grid_Column $column)
    {
        $this->_column = $column;
        return $this;
    }
    
    /**
     * Get column.
     * @return FreeCode_Grid_Column
     */
    public function getColumn()
    {
        return $this->_column;
    }
    
    public function setRow(array $row)
    {
        $this->_row = $row;
        return $this;
    }
    
    public function getRow()
    {
        return $this->_row;
    }
    
    /**
     * Set element
     * @param FreeCode_Grid_Element $element
     * @return FreeCode_Grid_Decorator_Abstract
     */
    public function setElement(FreeCode_Grid_Element $element)
    {
        $this->_element = $element;
        return $this;
    }
    
    /**
     * Get element.
     * @return FreeCode_Grid_Element
     */
    public function getElement()
    {
        return $this->_element;
    }
    
    /**
     * Reneder grid.
     * @param string $content
     * @return string
     */
    public function render($content)
    {
        throw new FreeCode_Exception("render() not implemented!");
    }
    
    /**
     * Get an unique element id for html/js.
     * @throws FreeCode_Exception_InvalidArgument
     */
    protected function _getUniqueElementId()
    {
        $grid = $this->getGrid();
        if (!($grid instanceof FreeCode_Grid))
            throw new FreeCode_Exception_InvalidArgument("Grid instance is required!");
        $element = $this->getElement();
        if (!($element instanceof FreeCode_Grid_Element))
            throw new FreeCode_Exception_InvalidArgument("Element instance is requried!");
        return $grid->getId().'_'.$element->getId();
    }
    
}
