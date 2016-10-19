<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Column.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Column.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Column
 * @brief   Grid column.
 */
class FreeCode_Grid_Column
{
    
    protected $_id = null;
    protected $_title = null;
    protected $_titleDecorator = null;
    protected $_cellDecorator = null;
    protected $_isSortable = false;
    protected $_isHidden = false;
    protected $_filter = null;
    
    /**
     * Constructor.
     * @param string $id Unique column name.
     */
    public function __construct($id)
    {
        $this->_id = $id;
        $this
            ->setTitleDecorator(new FreeCode_Grid_Decorator_Title)
            ->setCellDecorator(new FreeCode_Grid_Decorator_Cell);
    }

    /**
     * Set unique column id (name).
     * @param string $id
     * @return FreeCode_Grid_Column
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }
    
    /**
     * Get column id.
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * Set title.
     * @param string $title
     * @return FreeCode_Grid_Column
     */
    public function setTitle($title)
    {
        $this->_title = $title;
        return $this;
    }
    
    /**
     * Get title.
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }
    
    /**
     * Set title decorator.
     * @param $decorator
     * @return FreeCode_Grid_Column
     */
    public function setTitleDecorator(FreeCode_Grid_Decorator_Abstract $decorator)
    {
        $this->_titleDecorator = $decorator;
        return $this;
    }
    
    /**
     * Get title decorator.
     * @return FreeCode_Grid_Decorator_Abstract
     */
    public function getTitleDecorator()
    {
        return $this->_titleDecorator;
    }
    
    /**
     * Set cell decorator.
     * @param $decorator
     * @return FreeCode_Grid_Column
     */
    public function setCellDecorator(FreeCode_Grid_Decorator_Abstract $decorator)
    {
        $this->_cellDecorator = $decorator;
        return $this;
    }
    
    /**
     * Get cell decorator.
     * @return FreeCode_Grid_Decorator_Abstract
     */
    public function getCellDecorator()
    {
        return $this->_cellDecorator;
    }
    
    /**
     * Set sortable.
     * @param boolean $bool
     * @return FreeCode_Grid_Column
     */
    public function setSortable($bool)
    {
        $this->_isSortable = $bool;
        return $this;
    }
    
    /**
     * Is sortable.
     * @return boolean
     */
    public function isSortable()
    {
        return $this->_isSortable;
    }
    
    /**
     * Set hidden.
     * @param boolean $bool
     * @return FreeCode_Grid_Column
     */
    public function setHidden($bool)
    {
        $this->_isHidden = $bool;
        return $this;
    }
    
    /**
     * Is hidden.
     * @return boolean
     */
    public function isHidden()
    {
        return $this->_isHidden;
    }
    
    public function setFilter(FreeCode_Grid_Filter $filter)
    {
        $this->_filter = $filter;
        return $this;
    }
    
    public function getFilter()
    {
        if (!isset($this->_filter))
            $this->_filter = new FreeCode_Grid_Filter($this->_id);
        return $this->_filter;
    }
    
}
