<?php

/**
 * =============================================================================
 * @file        FreeCode/PHPUnit/GridTestCase.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     FreeCode
 * @version	    $Id: GridTestCase.php 70 2011-01-23 12:56:16Z cepa $
 * @license     BSD License
 * 
 * @copyright   FreeCode PHP Extensions
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   FreeCode_PHPUnit_GridTestCase
 * @brief   Test case.
 */
abstract class FreeCode_PHPUnit_GridTestCase extends FreeCode_PHPUnit_TestCase
{

    public function assertIterativeTest(FreeCode_Grid $grid, $options = array())
    {
        $doImport = true;
        $doRestore = true;
        
        $columns = $grid->getColumns();
        foreach ($columns as $column) {
            $grid->setSortColumn($column->getId());
            
            $grid->setSortOrder('asc');
            if ($doRestore) $grid->restore();
            if ($doImport) $grid->import();
            $this->assertNumberOfRows($grid);
            $this->assertRowsOrder($grid, $column->getId(), 'asc');
            $this->assertWorkingExporters($grid);
            
            $grid->setSortOrder('desc');
            if ($doRestore) $grid->restore();
            if ($doImport) $grid->import(); 
            $this->assertNumberOfRows($grid);
            $this->assertRowsOrder($grid, $column->getId(), 'desc');
            $this->assertWorkingExporters($grid);
            
            $options = $column->getFilter()->getOptions();
            foreach ($options as $value => $label) {
                if (empty($value))
                    continue;

                $column->getFilter()->setValue($value);
                $grid->import();
                $rows = $grid->getRows();
                foreach ($rows as $row) {
                    $alias = $column->getFilter()->getAlias();
                    if (empty($alias))
                        $this->assertEquals($value, $row[$column->getId()]);
                    else
                        $this->assertEquals($value, $row[$alias]);
                }
            }
            $column->getFilter()->setValue(null);
        }
        
        $html = (string) $grid;
        $this->assertFalse(empty($html));
    }
    
    public function assertRowsOrder(FreeCode_Grid $grid, $columnId, $order)
    {
        $rows = $grid->getRows();
        $this->assertType('array', $rows);
        $old = null;
        $fail = false;
        
        if (count($rows) <= 0)
            $this->fail("Number of rows is zero!");

        foreach ($rows as $row) {
            $this->assertType('array', $row);
            $this->assertArrayHasKey($columnId, $row);
            
            if ($order == 'asc') { 
                /**
                 * @TODO:
                 * Cdode below doesnt make sense when it comes to sort an utf8 
                 * encoded text.
                 */   
                //if (!is_null($old) && strcmp($row[$columnId], $old) < 0)
                //    $fail = true; 
                    
            } else if ($order == 'desc') {
                //if (!is_null($old) && strcmp($row[$columnId], $old) > 0)
                //    $fail = true;
            
            } else {
                throw new FreeCode_Exception_InvalidInput;
            }
            
            $old = $row[$columnId];
            
            if ($fail)
                $this->fail("Invalid order in column '{$columnId}'!");
        }
    }
    
    public function assertNumberOfRows(FreeCode_Grid $grid)
    {
        $rowsPerPage = $grid->getPager()->getRowsPerPage();
        if ($rowsPerPage != 0)
            $this->assertTrue($rowsPerPage >= count($grid->getRows()));
    }
    
    public function assertWorkingExporters(FreeCode_Grid $grid)
    {
        $exporters = $grid->getExporters();
        foreach ($exporters as $exporter) {
            $exporter->setGrid($grid);
            $result = $exporter->exportAll();
            $this->assertFalse(empty($result));
            $result = $exporter->export();
            $this->assertFalse(empty($result));
        }
    }
    
}
