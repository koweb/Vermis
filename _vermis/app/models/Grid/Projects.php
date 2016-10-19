<?php

/**
 * =============================================================================
 * @file        Grid/Projects.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Projects.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class Grid_Projects
 * @brief Projects grid.
 */
class Grid_Projects extends Grid 
{
    
    public function __construct(array $params, $id = 'projects')
    {
        parent::__construct($id);
        
        $name = new FreeCode_Grid_Column('name');
        $name
            ->setTitle('name')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_ProjectLink);
        
        $description = new FreeCode_Grid_Column('description');
        $description
            ->setTitle('description')
            ->setSortable(true)
            ->setCellDecorator(new FreeCode_Grid_Decorator_Cell_SuperEscape);

        $isPrivate = new FreeCode_Grid_Column('is_private');
        $isPrivate
            ->setTitle('access')
            ->setSortable(true)
            ->setCellDecorator(new FreeCode_Grid_Decorator_Cell_Boolean(_T('Private'), _T('Public')));

        $numberOfIssues = new FreeCode_Grid_Column('num_issues');
        $numberOfIssues
            ->setTitle('issues')
            ->setSortable(true);

        $createdBy = new FreeCode_Grid_Column('author_name');
        $createdBy
            ->setTitle('created_by')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_UserLink('author_slug'));

        $updatedBy = new FreeCode_Grid_Column('changer_name');
        $updatedBy
            ->setTitle('updated_by')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_UserLink('changer_slug'));
            
        $createdAt = new FreeCode_Grid_Column('create_time');
        $createdAt
            ->setTitle('created_at')
            ->setSortable(true)
            ->setCellDecorator(new FreeCode_Grid_Decorator_Cell_Date);

        $updatedAt = new FreeCode_Grid_Column('update_time');
        $updatedAt
            ->setTitle('updated_at')
            ->setSortable(true)
            ->setCellDecorator(new FreeCode_Grid_Decorator_Cell_Date);

        $pager = new FreeCode_Grid_Pager('pager');
        $pager->setRowsPerPage(20);

        $this
            ->setImporter(new Grid_Importer_Projects($params))
            ->addColumns(array(
                $name,
                $description,
                $numberOfIssues,
                $isPrivate,
                $updatedBy,
                $updatedAt,
                $createdBy,
                $createdAt
            ))
            ->setSortColumn('name')
            ->setSortOrder('asc')
            ->setAjaxAction($this->getView()->url(array(), 'grid'))
            ->setExportAction($this->getView()->url(array(), 'grid/export'));
    
        $this
            ->getToolbar('top')
            ->getElement('title')
            ->setCaption('projects');
    }
    
}
