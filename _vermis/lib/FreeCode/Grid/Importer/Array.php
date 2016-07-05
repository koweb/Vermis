<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Importer/Array.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Array.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Importer_Array
 * @brief   Grid importer.
 */
class FreeCode_Grid_Importer_Array extends FreeCode_Grid_Importer_Abstract
{
    
    protected $_array = array();
    
    /**
     * Constructor.
     * @param array $array Data
     */
    public function __construct($array = array())
    {
        if (!is_array($array))
            throw new FreeCode_Exception_InvalidArgument('Array was expected!');
        $this->_array = $array;
    }
    
    /**
     * Set data.
     * @param array $array
     * @return FreeCode_Grid_Importer_Array
     */
    public function setArray(array $array)
    {
        $this->_array = $array;
        return $this;
    }
    
    /**
     * Get data.
     * @return array
     */
    public function getArray()
    {
        return $this->_array;
    }
    
    /**
     * Import data.
     * @note: Overloaded method for data importing.
     * @return array
     */
    public function import()
    {
        return $this->getArray();
    }
    
    /**
     * Import data.
     * @note: Overloaded method for data importing.
     * @return array
     */
    public function importAll()
    {
        return $this->getArray();
    }
    
}
