<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Importer/Abstract.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Abstract.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Importer_Abstract
 * @brief   Grid importer.
 */
abstract class FreeCode_Grid_Importer_Abstract
{

    protected $_grid;
    
    /**
     * Set grid.
     * @param FreeCode_Grid $grid
     * @return FreeCode_Grid_Importer_Abstract
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
     * Import data and return it as a set of rows.
     * @return array
     */
    public function import()
    {
        throw new FreeCode_Exception("import() not implemented!");
    }
    
    public function importAll()
    {
        throw new FreeCode_Exception("importAll() not implemented!");
    }
    
}
