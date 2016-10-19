<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Pager.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Pager.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Pager
 * @brief   Grid pager.
 */
class FreeCode_Grid_Pager extends FreeCode_Grid_Element
{
    
    protected $_totalRows = 0;
    protected $_rowsPerPage = 0;
    protected $_page = 1;
    
    /**
     * Constructor.
     * @param string $id
     */
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->setDecorator(new FreeCode_Grid_Decorator_Pager);
    }
    
    /**
     * Set the total number of rows in the grid.
     * @param int $totalRows
     * @return FreeCode_Grid_Pager
     */
    public function setTotalRows($totalRows)
    {
        $this->_totalRows = (int) $totalRows;
        return $this;
    }
    
    /**
     * Get the total number of rows in the grid.
     * @return int
     */
    public function getTotalRows()
    {
        return $this->_totalRows;
    }
    
    /**
     * Set the number of rows per page.
     * @param int $rowsPerPage
     * @return FreeCode_Grid_Pager
     */
    public function setRowsPerPage($rowsPerPage)
    {
        $this->_rowsPerPage = (int) $rowsPerPage;
        return $this;
    }
    
    /**
     * Get the number of rows per page.
     * @return int
     */
    public function getRowsPerPage()
    {
        return $this->_rowsPerPage;
    }
    
    /**
     * Set the current page number
     * @param int $page
     * @return FreeCode_Grid_Pager
     */
    public function setPage($page)
    {
        $this->_page = (int) $page;
        return $this;
    }
    
    /**
     * Get the current page number.
     * @return int
     */
    public function getPage()
    {
        return $this->_page;
    }
    
    /**
     * Get the offset in rows to the first row of the current page.
     * @return int
     */
    public function getRowsOffset()
    {
        if ($this->_page == 0)
            return 0;
        $offset = $this->_rowsPerPage * ($this->_page - 1);
        if ($offset > $this->_totalRows)
            return $this->_totalRows;
        return $offset;
    }
    
    /**
     * Get the total number of pages in the grid.
     * @return int 
     */
    public function getTotalPages()
    {
        if ($this->_totalRows == 0 || $this->_rowsPerPage == 0)
            return 1;
            
        if ($this->_totalRows % $this->_rowsPerPage == 0)
            return $this->_totalRows / $this->_rowsPerPage;
        return ((int) ($this->_totalRows / $this->_rowsPerPage)) + 1;        
    }
    
    /**
     * Get the number of the first page.
     * @return int
     */
    public function getFirstPage()
    {
        return 1;
    }
    
    /**
     * Get the number of the previous page.
     * @return int
     */
    public function getPreviousPage()
    {
        if ($this->_page > 1)
            return $this->_page - 1;
        return $this->getFirstPage();
    }
    
    /**
     * Get the number of the next page.
     * @return int
     */
    public function getNextPage()
    {
        if ($this->_page < $this->getTotalPages())
            return $this->_page + 1;
        return $this->getLastPage();
    }
    
    /**
     * Get the number of the last page.
     * @return int
     */
    public function getLastPage()
    {
        return $this->getTotalPages();    
    }
    
}
