<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Filter.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Filter.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Filter
 * @brief   Grid filter.
 */
class FreeCode_Grid_Filter
{

    protected $_id = null;
    protected $_value = null;
    protected $_alias = null;
    protected $_options = array();
    
    /**
     * Constructor
     * @param string $id
     * @param string $column
     * @param mixed $value
     */
    public function __construct($id = null, $value = null)
    {
        $this->_id = $id;
        $this->_value = $value;
    }
    
    /**
     * Set filter's id.
     * @param string $id
     * @return FreeCode_Grid_Filter
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }
    
    /**
     * Get filter's id.
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }
    
    /**
     * Set value.
     * @param mixed $value
     * @return FreeCode_Grid_Filter
     */
    public function setValue($value)
    {
        $this->_value = $value;
        return $this;
    }
    
    /**
     * Get value.
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }
    
    /**
     * Set options for filter's decorator.
     * @param array $options
     * @return FreeCode_Grid_Filter
     */
    public function setOptions(array $options)
    {
        $this->_options = $options;
        return $this;
    }
    
    /**
     * Get options for filter's decorator.
     * @return array
     */
    public function getOptions()
    {
        return $this->_options;
    }
    
    public function setAlias($alias)
    {
        $this->_alias = $alias;
        return $this;
    }
    
    public function getAlias()
    {
        return $this->_alias;
    }
    
}
