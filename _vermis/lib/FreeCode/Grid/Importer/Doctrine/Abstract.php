<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid/Importer/Doctrine/Abstract.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     FreeCode
 * @version	    $Id: Abstract.php 1753 2012-12-26 10:08:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2010 - 2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid_Importer_Doctrine_Abstract
 * @brief   Grid importer.
 */
abstract class FreeCode_Grid_Importer_Doctrine_Abstract extends FreeCode_Grid_Importer_Abstract
{

    protected $_countQuery = null;
    protected $_recordsQuery = null;
    
    public function __construct()
    {
        /// @TODO: Probably this is a bug!
        //$this->_countQuery = Doctrine_Query::create();
        //$this->_recordsQuery = Doctrine_Query::create();
    }
    
    /**
     * Get query returning count of records.
     * @return Doctrine_Query
     */
    public function getCountQuery()
    {
        return $this->_countQuery;
    }
    
    /**
     * Set the count query.
     * @param $query
     * @return FreeCode_Grid_Importer_Doctrine_Abstract
     */
    public function setCountQuery(Doctrine_Query $query)
    {
        $this->_countQuery = $query;
        return $this;
    }
    
    /**
     * Get query returning records.
     * @return Doctrine_Query
     */
    public function getRecordsQuery()
    {
        return $this->_recordsQuery;
    }
    
    /**
     * Set the records query.
     * @param $query
     * @return FreeCode_Grid_Importer_Doctrine_Abstract
     */
    public function setRecordsQuery(Doctrine_Query $query)
    {
        $this->_recordsQuery = $query;
        return $this;
    }
    
    /**
     * Fetch number of records.
     * @return int
     */
    public function fetchCount()
    {
        $query = $this->getCountQuery();
        $query = $this->applyFilter($query);
        return $query->execute();
    }
    
    /**
     * Fetch records.
     * @return array
     */
    public function fetchRecords()
    {
        $query = $this->getRecordsQuery();
        $query = $this->applyLimitsAndOrder($query);
        $query = $this->applyFilter($query);
        return $query->execute();
    }
    
    /**
     * Fetch all records.
     * @return array
     */
    public function fetchAllRecords()
    {
        $query = $this->getRecordsQuery();
        $query = $this->applyLimitsAndOrder($query);
        return $query
            ->limit(0)
            ->offset(0)
            ->execute();
    }
    
    /**
     * Import data.
     * @return array
     */
    public function import()
    {
        if (!$this->getGrid())
            throw new FreeCode_Exception_InvalidArgument("Grid required!");
            
        $this->getGrid()->getPager()->setTotalRows($this->fetchCount());
        
        $rows = array();
        $records = $this->fetchRecords();
        foreach ($records as $record)
            $rows[] = $this->processRecord($record);
        return $rows;
    }
    
    /**
     * Import all data.
     * @return array
     */
    public function importAll()
    {
        $rows = array();
        $records = $this->fetchAllRecords();
        foreach ($records as $record)
            $rows[] = $this->processRecord($record);
        return $rows;
    }
    
    /**
     * Process (filter) record.
     * @param array $record
     * @return array:
     */
    public function processRecord(array &$record)
    {
        return $record;
    }
    
    /**
     * Apply grid limits to the query.
     * @param Doctrine_Query $query
     * @return Doctrine_Query
     */
    public function applyLimitsAndOrder(Doctrine_Query $query)
    {
        if (!$this->getGrid())
            throw new FreeCode_Exception_InvalidArgument("Grid required!");
            
        $options = $this->getGrid()->getOptions();
        
        if (isset($options['sort']) && isset($options['order']))
            $query->orderBy("{$options['sort']} {$options['order']}");
        if (isset($options['rows']) && $options['rows'] > 0)
            $query->limit((int) $options['rows']);
        if (isset($options['page']))
            $query->offset((int) $this->getGrid()->getPager()->getRowsOffset());
        
        return $query;   
    }
    
    /**
     * Apply grid filter to the query.
     * @param Doctrine_Query $query
     * @return Doctrine_Query
     */
    public function applyFilter(Doctrine_Query $query)
    {
        if (!($grid = $this->getGrid()))
            throw new FreeCode_Exception_InvalidArgument("Grid required!");
            
        $options = $grid->getOptions();

        if (isset($options['filter'])) {
            foreach ($options['filter'] as $column => $value) {
                $alias = $grid->getColumn($column)->getFilter()->getAlias();
                if (empty($alias))
                    $query->addWhere("{$column} = ?", $value);
                else
                    $query->addWhere("{$alias} = ?", $value);
            }
        }
        
        return $query;
    }
    
}
