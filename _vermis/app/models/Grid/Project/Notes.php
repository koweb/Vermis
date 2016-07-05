<?php

/**
 * =============================================================================
 * @file        Grid/Project/Notes.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Notes.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Project_Notes
 * @brief Project notes grid.
 */
class Grid_Project_Notes extends Grid 
{
    
    public function __construct(array $params, $id = 'notes')
    {
        parent::__construct($id);
        
        $title = new FreeCode_Grid_Column('title');
        $title
            ->setTitle('title')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_Project_NoteLink);
        
        $pager = new FreeCode_Grid_Pager('pager');
        $pager->setRowsPerPage(20);

        $this
            ->setImporter(new Grid_Importer_Project_Notes($params))
            ->addColumns(array(
                $title
            ))
            ->setSortColumn('title')
            ->setSortOrder('asc')
            ->setAjaxAction($this->getView()->url(
                array('project_slug' => $params['projectSlug']), 
                'project/grid'))
            ->setExportAction($this->getView()->url(
                array('project_slug' => $params['projectSlug']), 
                'project/grid/export'));
        
        $this
            ->getToolbar('top')
            ->getElement('title')
            ->setCaption('notes');  
    }
    
}
