<?php

/**
 * =============================================================================
 * @file        Grid.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Grid.php 122 2011-01-29 23:37:26Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Grid
 * @brief   Default base grid.
 */
abstract class Grid extends FreeCode_Grid
{
    
    public function __construct($id = null)
    {
        parent::__construct(Grid::hashId($id));
        
        $titleLabel = new FreeCode_Grid_Label('title');
        $titleLabel->setCaption(get_class($this));
        
        $csvButton = new FreeCode_Grid_Button('csv');
        $csvButton
            ->setDecorator(new FreeCode_Grid_Decorator_Button_Csv)
            ->setCaption('csv');
        
        $topToolbar = new FreeCode_Grid_Toolbar('top');
        $topToolbar
            ->setPosition(FreeCode_Grid_Toolbar::POSITION_TOP)
            ->addElement($titleLabel)
            ->addElement($csvButton);
        
        $numberOfRecordsLabel = new FreeCode_Grid_Label('number_of_rows');
        $numberOfRecordsLabel
            ->setCaption('Records:')
            ->setDecorator(new FreeCode_Grid_Decorator_Label_NumberOfRecords)
            ->setFloat(FreeCode_Grid_Element::FLOAT_RIGHT);
            
        $rowsPerPage = new FreeCode_Grid_RowsPerPage('rows_per_page');
            
        $pager = new FreeCode_Grid_Pager('pager');
        $pager->setRowsPerPage(20);

        $bottomToolbar = new FreeCode_Grid_Toolbar('bottom');
        $bottomToolbar
            ->setPosition(FreeCode_Grid_Toolbar::POSITION_BOTTOM)
            ->addElement($rowsPerPage)
            ->addElement($numberOfRecordsLabel)
            ->addElement($pager);
        
        $this
            ->enableIndicator(true)
            ->addExporter(new FreeCode_Grid_Exporter_Csv)
            ->setMemory(new FreeCode_Grid_Memory_Session)
            ->setPager($pager)
            ->addToolbars(array($topToolbar, $bottomToolbar));
    }
    
    public static function hashId($id)
    {
        return 'grid_'.dechex(crc32($id));
    }
    
}
