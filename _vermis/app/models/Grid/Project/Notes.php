<?php

/**
 * =============================================================================
 * @file        Grid/Project/Notes.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Notes.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
