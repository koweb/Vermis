<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Importer/Array.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Array.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
