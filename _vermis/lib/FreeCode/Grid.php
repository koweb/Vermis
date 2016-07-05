<?php

/**
 * =============================================================================
 * @file        FreeCode/Grid.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: Grid.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_Grid
 * @brief   Grid.
 */
class FreeCode_Grid
{
    
    protected $_id = null;
    protected $_columns = array();
    protected $_decorators = array();
    protected $_rows = array();
    protected $_importer = null;
    protected $_ajaxAction = null;
    protected $_exportAction = null;
    protected $_sortColumnId = null;
    protected $_sortOrder = null;
    protected $_view = null;
    protected $_pager = null;
    protected $_toolbars = array();
    protected $_hasIndicator = false;
    protected $_hasMultiselect = false;
    protected $_hasFilter = false;
    protected $_multiselectColumnId = null;
    protected $_memory = null;
    protected $_exporters = array();
    
    /**
     * Constructor.
     */
    public function __construct($id = null)
    {
        $this->_id = $id;
        $this->setDefaultDecorators();
    }
    
    /**
     * Set grid id.
     * @note This is used by javascript and css!
     * @param string $id
     * @return FreeCode_Grid
     */
    public function setId($id)
    {
        $this->_id = strtolower($id);
        return $this;
    }
    
    /**
     * Get grid id.
     * @note If grid id is not set, then it will makes it by class name.
     * @return string
     */
    public function getId()
    {
        return (isset($this->_id) ? $this->_id : strtolower(get_class($this)));
    }
    
    /**
     * Set default decorators.
     * @return FreeCode_Grid
     */
    public function setDefaultDecorators()
    {
        $this->setDecorators(array(
            new FreeCode_Grid_Decorator_Body,
            new FreeCode_Grid_Decorator_Head,
            new FreeCode_Grid_Decorator_Table,
            new FreeCode_Grid_Decorator_Toolbars,
            new FreeCode_Grid_Decorator_Div
        ));
        return $this;
    }
    
    /**
     * Add a column to the grid.
     * @param FreeCode_Grid_Column $column
     * @return FreeCode_Grid
     */
    public function addColumn(FreeCode_Grid_Column $column)
    {
        $this->_columns[$column->getId()] = $column;
        return $this;
    }
    
    /**
     * Add a set of columns to the grid.
     * @param array $columns
     * @return FreeCode_Grid
     */
    public function addColumns(array $columns)
    {
        foreach ($columns as $column) {
            if (!($column instanceof FreeCode_Grid_Column))
                throw new FreeCode_Exception_InvalidInput;
            $this->addColumn($column);
        }
        return $this;
    }
    
    /**
     * Get a column by an id.
     * @param string $columnId
     * @return FreeCode_Grid_Column | null
     */
    public function getColumn($columnId)
    {
        return (isset($this->_columns[$columnId])
            ? $this->_columns[$columnId] : null);
    }
    
    /**
     * Get all columns.
     * @return array
     */
    public function getColumns()
    {
        return $this->_columns;
    }
    
    /**
     * Remove a column.
     * @param string $columnId
     * @return FreeCode_Grid
     */
    public function removeColumn($columnId)
    {
        if (isset($this->_columns[$columnId]))
            unset($this->_columns[$columnId]);
        return $this;
    }
    
    /**
     * Clear columns.
     * @return FreeCode_Grid
     */
    public function clearColumns()
    {
        $this->_columns = array();
        return $this;
    }
    
    /**
     * Set columns.
     * @param array $columns
     */
    public function setColumns(array $columns)
    {
        $this->clearColumns();
        $this->addColumns($columns);
        return $this;        
    }
    
    /**
     * Add decorator.
     * @param $decorator
     * @return FreeCode_Grid
     */
    public function addDecorator(FreeCode_Grid_Decorator_Abstract $decorator)
    {
        $className = get_class($decorator);
        $this->_decorators[$className] = $decorator;
        return $this;
    }
    
    /**
     * Add decorators.
     * @param array $decorators
     * @return FreeCode_Grid
     */
    public function addDecorators(array $decorators)
    {
        foreach ($decorators as $decorator) {
            if (!($decorator instanceof FreeCode_Grid_Decorator_Abstract))
                throw new FreeCode_Exception_InvalidInput;
            $this->addDecorator($decorator);
        }
        return $this;
    }
    
    /**
     * Clear decorators.
     * @return FreeCode_Grid
     */
    public function clearDecorators()
    {
        $this->_decorators = array();
        return $this;
    }
    
    /**
     * Get decorator.
     * @param string $name
     * @return FreeCode_Grid_Decorator_Abstract | null
     */
    public function getDecorator($name)
    {
        return (isset($this->_decorators[$name])
            ? $this->_decorators[$name] : null);
    }
    
    /**
     * Get decorators.
     * @return array
     */
    public function getDecorators()
    {
        return $this->_decorators;
    }
    
    /**
     * Remove decorator by name.
     * @param string $name
     * @return $this
     */
    public function removeDecorator($name)
    {
        if (isset($this->_decorators[$name]))
            unset($this->_decorators[$name]);
        return $this;
    }
    
    /**
     * Set decorators.
     * @param array $decorators
     * @return FreeCode_Grid
     */
    public function setDecorators(array $decorators)
    {
        return $this
            ->clearDecorators()
            ->addDecorators($decorators);
    }
    
    /**
     * Add row.
     * @param  array $row
     * @return FreeCode_Grid
     */
    public function addRow(array $row)
    {
        $this->_rows[] = $row;
        return $this;
    }
    
    /**
     * Add rows.
     * @param array $rows
     * @return FreeCode_Grid
     */
    public function addRows(array $rows)
    {
        foreach ($rows as $row)
            $this->addRow($row);
        return $this;
    }
    
    /**
     * Clear rows.
     * @return FreeCode_Grid
     */
    public function clearRows()
    {
        $this->_rows = array();
        return $this;
    }
    
    /**
     * Get rows.
     * @return array
     */
    public function getRows()
    {
        return $this->_rows;
    }
    
    /**
     * Set rows.
     * @param array $rows
     * @return FreeCode_Grid
     */
    public function setRows(array $rows)
    {
        $this->_rows = $rows;
        return $this;
    }
    
    /**
     * Set data importer.
     * @param $importer
     * @return FreeCode_Grid
     */
    public function setImporter(FreeCode_Grid_Importer_Abstract $importer)
    {
        $this->_importer = $importer;
        return $this;
    }
    
    /**
     * Get data importer.
     * @return FreeCode_Grid_Importer_Abstract
     */
    public function getImporter()
    {
        return $this->_importer;
    }
    
    /**
     * Call data importer to fetch set of records.
     * @return FreeCode_Grid
     */
    public function import()
    {
        if (!isset($this->_importer))
            throw new FreeCode_Exception("Importer is not set!");
        $this->_importer->setGrid($this);
        return $this->setRows($this->_importer->import());
    }
    
    /**
     * Set ajax action url.
     * @param string $lifeAction
     * @return FreeCode_Grid
     */
    public function setAjaxAction($ajaxAction)
    {
        $this->_ajaxAction = $ajaxAction;
        return $this;
    }
    
    /**
     * Get ajax action.
     * @return string
     */
    public function getAjaxAction()
    {
        return $this->_ajaxAction;
    }
    
    public function setExportAction($exportAction)
    {
        $this->_exportAction = $exportAction;
        return $this;
    }
    
    public function getExportAction()
    {
        return $this->_exportAction;
    }
    
    /**
     * Set sort column by columnId.
     * @note It will sets a sort column only if this column is defined!
     * @param string $columnId
     * @return FreeCode_Grid
     */
    public function setSortColumn($columnId)
    {
        if (isset($this->_columns[$columnId]))
            $this->_sortColumnId = $columnId;
        else
            throw new FreeCode_Exception_InvalidArgument("Undefined column '{$columnId}'!");
        return $this;
    }
    
    /**
     * Get sort column.
     * @note If none is selected then first column will be returned.
     * @return FreeCode_Grid_Column
     */
    public function getSortColumn()
    {
        if (isset($this->_sortColumnId))
            return $this->_columns[$this->_sortColumnId];
        reset($this->_columns);
        return current($this->_columns);
    }
    
    /**
     * Set sort order.
     * @param string $order 'ASC' | 'DESC'
     * @param string $default
     * @return FreeCode_Grid
     */
    public function setSortOrder($order, $default = 'ASC')
    {
        switch (strtoupper($order)) {
            case 'ASC': $this->_sortOrder = 'ASC'; break;
            case 'DESC': $this->_sortOrder = 'DESC'; break;
            default:
                $this->_sortOrder = $default;
        }
        return $this;
    }
    
    /**
     * Get sort order.
     * @param string $default
     * @return 'ASC' | 'DESC'
     */
    public function getSortOrder($default = 'ASC')
    {
        return (isset($this->_sortOrder) ? $this->_sortOrder : $default);
    }
    
    /**
     * Set view.
     * @param $view
     * @return FreeCode_Grid
     */
    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
        return $this;
    }
    
    /**
     * Get view.
     * @note If a view was not set, then get a default view from ViewRenderer.
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
     * Set pager.
     * @param $pager
     * @return FreeCode_Grid
     */
    public function setPager(FreeCode_Grid_Pager $pager)
    {
        $this->_pager = $pager;
        return $this;
    }
    
    /**
     * Get pager.
     * @return FreeCode_Grid_Pager
     */
    public function getPager()
    {
        if (!isset($this->_pager))
            $this->_pager = new FreeCode_Grid_Pager;
        return $this->_pager;
    }
    
    /**
     * Add a toolbar to the grid.
     * @param FreeCode_Grid_Toolbar $toolbar
     * @return FreeCode_Grid
     */
    public function addToolbar(FreeCode_Grid_Toolbar $toolbar)
    {
        $this->_toolbars[$toolbar->getId()] = $toolbar;
        return $this;
    }
    
    /**
     * Add toolbars.
     * @param array $toolbars
     * @return FreeCode_Grid
     */
    public function addToolbars(array $toolbars)
    {
        foreach ($toolbars as $toolbar) {
            if (!($toolbar instanceof FreeCode_Grid_Toolbar))
                throw new FreeCode_Exception_InvalidInput;
            $this->addToolbar($toolbar);
        }
        return $this;
    }
    
    /**
     * Clear toolbars.
     * @return FreeCode_Grid
     */
    public function clearToolbars()
    {
        $this->_toolbars = array();
        return $this;
    }
    
    /**
     * Get toolbar by id.
     * @param string $toolbarId
     * @return FreeCode_Grid_Toolbar | null
     */
    public function getToolbar($toolbarId)
    {
        return (isset($this->_toolbars[$toolbarId])
            ? $this->_toolbars[$toolbarId] : null);
    }
    
    /**
     * Get toolbars.
     * @return array
     */
    public function getToolbars()
    {
        return $this->_toolbars;
    }
    
    /**
     * Remove toolbar.
     * @param string $toolbarId
     * @return FreeCode_Grid
     */
    public function removeToolbar($toolbarId)
    {
        if (isset($this->_toolbars[$toolbarId]))
            unset($this->_toolbars[$toolbarId]);
        return $this;
    }
    
    /**
     * Set toolbars.
     * @param array $toolbars
     * @return FreeCode_Grid
     */
    public function setToolbars(array $toolbars)
    {
        return $this
            ->clearToolbars()
            ->addToolbars($toolbars);
    }
    
    /**
     * Add exporter
     * @param $exporter
     * @return FreeCode_Grid
     */
    public function addExporter(FreeCode_Grid_Exporter_Abstract $exporter)
    {
        $this->_exporters[$exporter->getName()] = $exporter;
        return $this;
    }
    
    /**
     * Add a set of exporters.
     * @param array $exporters
     * @return FreeCode_Grid
     */
    public function addExporters(array $exporters)
    {
        foreach ($exporters as $exporter) {
            if (!($exporter instanceof FreeCode_Grid_Exporter_Abstract))
                throw new FreeCode_Exception_InvalidInput;
            $this->addExporter($exporter);
        }
        return $this;
    }
    
    /**
     * Clear exporters.
     * @return FreeCode_Grid
     */
    public function clearExporters()
    {
        $this->_exporters = array();
        return $this;
    }
    
    /**
     * Get an exporter by name.
     * @param string $name
     * @return FreeCode_Grid_Exporter_Abstract
     */
    public function getExporter($name)
    {
        return (isset($this->_exporters[$name])
            ? $this->_exporters[$name] : null);
    } 
    
    /**
     * Get exporters.
     * @return array
     */
    public function getExporters()
    {
        return $this->_exporters;
    }
    
    /**
     * Remove an exporter.
     * @param string $name
     * @return FreeCode_Grid
     */
    public function removeExporter($name)
    {
        if (isset($this->_exporters[$name]))
            unset($this->_exporters[$name]);
        return $this;
    }
    
    /**
     * Set exporters.
     * @param array $exporters
     * @return FreeCode_Grid
     */
    public function setExporters(array $exporters)
    {
        return $this
            ->clearExporters()
            ->addExporters($exporters);
    }
    
    /**
     * Enable indicator.
     * @param $bool
     * @return FreeCode_Grid
     */
    public function enableIndicator($bool)
    {
        $this->_hasIndicator = $bool;
        return $this;
    }
    
    /**
     * Has indicator?
     * @return boolean
     */
    public function hasIndicator()
    {
        return $this->_hasIndicator;
    }
    
    /**
     * Enable/disable multiselector.
     * @param boolean $bool
     * @return FreeCode_Grid
     */
    public function enableMultiselect($bool)
    {
        $this->_hasMultiselect = $bool;
        return $this;
    }
    
    /**
     * Has multiselect?
     * @return boolean
     */
    public function hasMultiselect()
    {
        return $this->_hasMultiselect;
    }
    
    /**
     * Enable/disable filter.
     * @param boolean $bool
     * @return FreeCode_Grid
     */
    public function enableFilter($bool)
    {
        $this->_hasFilter = $bool;
        return $this;
    }
    
    /**
     * Has filter?
     * @return boolean
     */
    public function hasFilter()
    {
        return $this->_hasFilter;
    }
    
    /**
     * Set multiselect column for taking values.
     * @param string $columnId
     * @return FreeCode_Grid
     */
    public function setMultiselectColumn($columnId)
    {
        if (isset($this->_columns[$columnId]))
            $this->_multiselectColumnId = $columnId;
        else
            throw new FreeCode_Exception_InvalidArgument("Undefined column '{$columnId}'!");
        return $this;
    }
    
    /**
     * Get multiselect column.
     * @return FreeCode_Grid_Column
     */
    public function getMultiselectColumn()
    {
        if (isset($this->_multiselectColumnId))
            return $this->_columns[$this->_multiselectColumnId];
        reset($this->_columns);
        return current($this->_columns);
    }
    
    /**
     * Set a memory adapter.
     * @param FreeCode_Grid_Memory_Abstract $memory
     * @return FreeCode_Grid
     */
    public function setMemory(FreeCode_Grid_Memory_Abstract $memory)
    {
        $this->_memory = $memory;
        return $this;
    }
    
    /**
     * Get a memory adapter.
     * @return FreeCode_Grid_Memory_Abstract
     */
    public function getMemory()
    {
        return $this->_memory;
    }
    
    /**
     * Remember current grid settings.
     * @return FreeCode_Grid
     */
    public function remember()
    {
        if (!isset($this->_memory))
            throw new FreeCode_Exception("Memory adapter is not set!");
        $this->_memory
            ->setGrid($this)
            ->remember();
        return $this;
    }
    
    /**
     * Restore previous grid settings.
     * @return FreeCode_Grid 
     */
    public function restore()
    {
        if (!isset($this->_memory))
            throw new FreeCode_Exception("Memory adapter is not set!");
        $this->_memory
            ->setGrid($this)
            ->restore();
        return $this;
    }
    
    /**
     * Render grid.
     * @return string
     */
    public function render(Zend_View_Interface $view = null)
    {
        if ($view !== null)
            $this->setView($view);
        
        $content = '';
        foreach ($this->getDecorators() as $decorator) {
            $decorator
                ->setView($this->getView())
                ->setGrid($this);
            $content = $decorator->render($content);
        }
        return $content;
    }
    
    /**
     * Serialize to string.
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->render();

        } catch (Exception $e) {
            $message = 
                "Exception caught by form: ".$e->getMessage().
                "\nStack Trace:\n".$e->getTraceAsString();
            trigger_error($message, E_USER_WARNING);
            return '';
        }
    }
    
    /**
     * Set grid options.
     * Apply options to the other grid's components.
     * @param array $options
     * @return FreeCode_Grid
     */
    public function setOptions($options)
    {
        if (!is_array($options) || count($options) == 0)
            return $this;
        
        if (isset($options['id']))
            $this->setId($options['id']);
        if (isset($options['sort']))
            $this->setSortColumn($options['sort']);
        if (isset($options['order']))
            $this->setSortOrder($options['order']);
        if (isset($options['page']))
            $this->getPager()->setPage($options['page']);
        if (isset($options['rows']))
            $this->getPager()->setRowsPerPage($options['rows']);
            
        if (isset($options['filter'])) {
            foreach ($options['filter'] as $column => $value) {
                $this->getColumn($column)->getFilter()->setValue($value);
            }
        }
            
        return $this;
    }
    
    /**
     * Get grid options.
     * Collect options from other grids.
     * @return array
     */
    public function getOptions()
    {
        $filter = array();
        
        if (count($this->getColumns()) == 0)
            throw new FreeCode_Exception("Grid must have at least one column!");
        
        foreach ($this->getColumns() as $column) {
            $value = $column->getFilter()->getValue();
            if (!empty($value))
                $filter[$column->getId()] = $value;
        }
        
        return array(
            'id'        => $this->getId(),
            'sort'      => $this->getSortColumn()->getId(),
            'order'	    => $this->getSortOrder(),
            'page'	    => $this->getPager()->getPage(),
            'rows'	    => $this->getPager()->getRowsPerPage(),
            'filter'	=> $filter
        );
    }
    
}
