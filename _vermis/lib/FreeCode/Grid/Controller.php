<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Controller.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Controller.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Controller
 * @brief   Grid controller.
 */
abstract class FreeCode_Grid_Controller extends FreeCode_Controller_Action
{

    protected $_grids = array();
    
    public function init()
    {
        parent::init();
        $this
            ->disableLayout()
            ->disableView();            
    }
    
    /**
     * Fetch grid by ajax.
     * @return void
     */
    public function ajaxAction()
    {
        $grid = $this->_setupGrid();

        if ($grid->getImporter())
            $grid->import();
        
        if (!FreeCode_Test::isEnabled()) {
            echo $grid->render();
            echo $this->view->headScript();
        
        } else {
            return $grid;
        }
    }
    
    /**
     * Export grid data using a specified exporter.
     * @return void
     */
    public function exportAction()
    {
        $grid = $this->_setupGrid();
        
        $exporter = $grid->getExporter($this->getExporterParam());
        if (!$exporter)
            throw new FreeCode_Exception("Invalid exporter!");
        
        $result = $exporter
            ->setGrid($grid)
            ->exportAll();

        $response = $this->getResponse();
        if ($exporter->getContentType() != '')
            $response->setHeader('Content-Type', $exporter->getContentType());
        if ($exporter->getFileName() != '')
            $response->setHeader(
                'Content-Disposition', 
                'attachment; filename='.$exporter->getFileName().';');
        $response->appendBody((string) $result);
    }
    
    /**
     * Register a grid.
     * @param FreeCode_Grid $grid
     * @return FreeCode_Grid_Controller
     */
    public function registerGrid(FreeCode_Grid $grid)
    {
        $this->_grids[$grid->getId()] = $grid;
        return $this;
    }
    
    /**
     * Unregister a grid.
     * @param string $id
     * @return FreeCode_Grid_Controller
     */
    public function unregisterGrid($id)
    {
        if (isset($this->_grids[$id]))
            unset($this->_grids[$id]);
        return $this;
    }
    
    /**
     * Get grids.
     * @return array
     */
    public function getGrids()
    {
        return $this->_grids;
    }
    
    /**
     * Get a registered grid.
     * @param string $id
     * @return FreeCode_Grid
     */
    public function getGrid($id)
    {
        if (!isset($this->_grids[$id]))
            throw new FreeCode_Exception("Grid '{$id}' is not registered!");
        return $this->_grids[$id];
    }
    
    /**
     * Get a grid id param.
     * @return string
     */
    public function getIdParam()
    {
        return $this->_request->getParam('id');
    }
    
    /**
     * Get a sort column param.
     * @return string
     */
    public function getSortParam()
    {
        return $this->_request->getParam('sort');
    }
    
    /**
     * Get an order param.
     * @return string
     */
    public function getOrderParam()
    {
        return $this->_request->getParam('order');
    }
    
    /**
     * Get a page param.
     * @return int
     */
    public function getPageParam()
    {
        return (int) $this->_request->getParam('page', 1);
    }
    
    /**
     * Get a rows param.
     * @return int
     */
    public function getRowsParam()
    {
        return (int) $this->_request->getParam('rows', 0);
    }
    
    /**
     * Get a exporter param.
     * @return string
     */
    public function getExporterParam()
    {
        return $this->_request->getParam('exporter', 'undefined');
    }
    
    protected function _setupGrid()
    {
        $grid = $this->getGrid($this->getIdParam());
        
        if ($grid->getMemory())
            $grid->restore();
        
        $grid->setOptions($this->getRequest()->getParams());
            
        if ($grid->getMemory())
            $grid->remember();
        
        return $grid;
    }
    
}
