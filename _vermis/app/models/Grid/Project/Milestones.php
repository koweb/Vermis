<?php

/**
 * =============================================================================
 * @file        Grid/Project/Milestones.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Milestones.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Grid_Project_Milestones
 * @brief Project milestones grid.
 */
class Grid_Project_Milestones extends Grid 
{
    
    public function __construct(array $params, $id = 'milestones')
    {
        parent::__construct($id);
        
        $name = new FreeCode_Grid_Column('name');
        $name
            ->setTitle('name')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_Project_MilestoneLink);
        
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

        $this
            ->setImporter(new Grid_Importer_Project_Milestones($params))
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
            ->setCaption('milestones');  
    }
    
}
