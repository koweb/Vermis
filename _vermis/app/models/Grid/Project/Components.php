<?php

/**
 * =============================================================================
 * @file        Grid/Project/Components.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Components.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class Grid_Project_Components
 * @brief Project milestones grid.
 */
class Grid_Project_Components extends Grid 
{
    
    public function __construct(array $params, $id = 'components')
    {
        parent::__construct($id);
        
        $name = new FreeCode_Grid_Column('name');
        $name
            ->setTitle('name')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_Project_ComponentLink);
        
        $description = new FreeCode_Grid_Column('description');
        $description
            ->setTitle('description')
            ->setSortable(true)
            ->setCellDecorator(new FreeCode_Grid_Decorator_Cell_SuperEscape);
            
        $numberOfIssues = new FreeCode_Grid_Column('num_issues');
        $numberOfIssues
            ->setTitle('issues')
            ->setSortable(true);

        $createdBy = new FreeCode_Grid_Column('author_name');
        $createdBy
            ->setTitle('Created by')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_UserLink('author_slug'));

        $updatedBy = new FreeCode_Grid_Column('changer_name');
        $updatedBy
            ->setTitle('Updated by')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_UserLink('changer_slug'));
            
        $createdAt = new FreeCode_Grid_Column('create_time');
        $createdAt
            ->setTitle('Created at')
            ->setSortable(true)
            ->setCellDecorator(new FreeCode_Grid_Decorator_Cell_Date);

        $updatedAt = new FreeCode_Grid_Column('update_time');
        $updatedAt
            ->setTitle('Updated at')
            ->setSortable(true)
            ->setCellDecorator(new FreeCode_Grid_Decorator_Cell_Date);

        $this
            ->setImporter(new Grid_Importer_Project_Components($params))
            ->addColumns(array(
                $name,
                $description,
                $numberOfIssues,
                $updatedBy,
                $updatedAt,
                $createdBy,
                $createdAt
            ))
            ->setSortColumn('name')
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
            ->setCaption('Components');  
    }
    
}
