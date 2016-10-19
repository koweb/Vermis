<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Exporter/Abstract.php
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
 * @class   FreeCode_Grid_Exporter_Abstract
 * @brief   Grid Exporter.
 */
abstract class FreeCode_Grid_Exporter_Abstract
{

    protected $_grid = null;
    protected $_name = null;
    protected $_contentType = null;
    protected $_fileName = null;
    
    /**
     * Constructor.
     * @param string $name
     */
    public function __construct($name = null)
    {
        $this->_name = $name;
    }
    
    /**
     * Set name.
     * @param string $name
     * @return FreeCode_Grid_Exporter_Abstract
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }
    
    /**
     * Get name.
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }
    
    /**
     * Set grid.
     * @param FreeCode_Grid $grid
     * @return FreeCode_Grid_Exporter_Abstract
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
     * Set content type.
     * @param string $contentType
     * @return FreeCode_Grid_Exporter_Abstract
     */
    public function setContentType($contentType)
    {
        $this->_contentType = $contentType;
        return $this;
    }
    
    /**
     * Get content type.
     * @return string
     */
    public function getContentType()
    {
        return $this->_contentType;
    }
    
    /**
     * Set file name.
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->_fileName = $fileName;
        return $this;
    }
    
    /**
     * Get file name.
     * @return string
     */
    public function getFileName()
    {
        return $this->_fileName;
    }
    
    /**
     * Export data.
     * @return mixed
     */
    public function export()
    {
        $importer = $this->getGrid()->getImporter();
        $rows = $importer->setGrid($this->getGrid())->import();
        return $this->_process($rows);
    }
    
    /**
     * Export data.
     * @return mixed
     */
    public function exportAll()
    {
        $importer = $this->getGrid()->getImporter();
        $rows = $importer->setGrid($this->getGrid())->importAll();
        return $this->_process($rows);
    }
    
    protected function _process($rows)
    {
        $out = array();
        $columns = $this->getGrid()->getColumns();
        foreach ($rows as $r) {
            $o = array();
            foreach ($columns as $column) {
                if ($column->isHidden())
                    continue;
                $id = $column->getId();
                $o[$id] = $r[$id];
            }
            $out[] = $o;
        }
        return $out;
    }
    
}
