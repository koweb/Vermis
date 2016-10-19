<?php

/**
 * =============================================================================
 * @file        Grid/Project/Issues.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Issues.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class Grid_Project_Issues
 * @brief Project issues grid.
 */
class Grid_Project_Issues extends Grid 
{
    
    public function __construct(array $params, $id = 'issues')
    {
        parent::__construct($id);
        
        $membersOptions = $this->getMembersOptions($params);
        
        $projectId = new FreeCode_Grid_Column('project_id');
        $projectId->setHidden(true);
        
        $milestoneId = new FreeCode_Grid_Column('milestone_id');
        $milestoneId->setHidden(true);
        
        $componentId = new FreeCode_Grid_Column('component_id');
        $componentId->setHidden(true);
        
        $assigneeId = new FreeCode_Grid_Column('assignee_id');
        $assigneeId->setHidden(true);
        
        $reporterId = new FreeCode_Grid_Column('reporter_id');
        $reporterId->setHidden(true);
        
        $number = new FreeCode_Grid_Column('number');
        $number
            ->setTitle('ID')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_Project_IssueId);
        if (!isset($params['projectId']))
            $number->getFilter()
                ->setAlias('project_id')
                ->setOptions($this->getProjectsAsOptions($params));
        
        $title = new FreeCode_Grid_Column('title');
        $title
            ->setTitle('title')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_Project_IssueTitle);

        $type = new FreeCode_Grid_Column('type');
        $type
            ->setTitle('type')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_Project_IssueType);
        $type->getFilter()->setOptions($this->getTypeOptions());

        $status = new FreeCode_Grid_Column('status');
        $status
            ->setTitle('status')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_Project_IssueStatus);
        $status->getFilter()->setOptions($this->getStatusOptions());

        $priority = new FreeCode_Grid_Column('priority');
        $priority
            ->setTitle('priority')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_Project_IssuePriority);
        $priority->getFilter()->setOptions($this->getPriorityOptions());
        
        $progress = new FreeCode_Grid_Column('progress');
        $progress
            ->setTitle('progress')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_Project_ProgressBar);
        
        $assigneeName = new FreeCode_Grid_Column('assignee_name');
        $assigneeName
            ->setTitle('assignee')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_UserLink('assignee_slug'));
        $assigneeName->getFilter()
            ->setAlias('assignee_id')
            ->setOptions($membersOptions);
        
        $reporterName = new FreeCode_Grid_Column('reporter_name');
        $reporterName
            ->setTitle('reporter')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_UserLink('reporter_slug'));
        $reporterName->getFilter()
            ->setAlias('reporter_id')
            ->setOptions($membersOptions);
            
        $componentName = new FreeCode_Grid_Column('component_name');
        $componentName
            ->setTitle('component')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_Project_ComponentLink('component_slug'));
        if (isset($params['projectId']))
            $componentName->getFilter()
                ->setAlias('component_id')
                ->setOptions($this->getComponentOptions($params));
            
        $milestoneName = new FreeCode_Grid_Column('milestone_name');
        $milestoneName
            ->setTitle('milestone')
            ->setSortable(true)
            ->setCellDecorator(new Grid_Decorator_Project_MilestoneLink('milestone_slug'));
        if (isset($params['projectId']))
            $milestoneName->getFilter()
                ->setAlias('milestone_id')
                ->setOptions($this->getMilestoneOptions($params));
            
        $createTime = new FreeCode_Grid_Column('create_time');
        $createTime
            ->setTitle('created_at')
            ->setSortable(true)
            ->setCellDecorator(new FreeCode_Grid_Decorator_Cell_Date)
            ->setHidden(true);
            
        $updateTime = new FreeCode_Grid_Column('update_time');
        $updateTime
            ->setTitle('updated_at')
            ->setSortable(true)
            ->setCellDecorator(new FreeCode_Grid_Decorator_Cell_Date)
            ->setHidden(true);
            
        $this
            ->enableFilter(true)
            ->setImporter(new Grid_Importer_Project_Issues($params))
            ->addColumns(array(
                $projectId,
                $milestoneId,
                $componentId,
                $assigneeId,
                $reporterId,
                $number,
                $title,
                $type,
                $status,
                $priority,
                $assigneeName,
                $reporterName,
                $componentName,
                $milestoneName,
                $createTime,
                $updateTime,
                $progress
            ))
            ->setSortColumn('update_time')
            ->setSortOrder('desc');
            
        $this
            ->getToolbar('top')
            ->getElement('title')
            ->setCaption('Issues');
            
        $this->getPager()->setRowsPerPage(10);
            
        $this->_setActionsForDashboardGrid($params);
    }
    
    protected function _setActionsForDashboardGrid($params)
    {
        if (isset($params['projectSlug'])) {
            $this
                ->setAjaxAction($this->getView()->url(
                    array('project_slug' => $params['projectSlug']), 
                    'project/grid'))
                ->setExportAction($this->getView()->url(
                    array('project_slug' => $params['projectSlug']), 
                    'project/grid/export'));
            
        } else {
            $this
                ->setAjaxAction($this->getView()->url(
                    array(), 
                    'grid'))
                ->setExportAction($this->getView()->url(
                    array(), 
                    'grid/export'));
        }
    }
    
    protected function _setActionsForUserGrid($params)
    {
        $this
            ->setAjaxAction($this->getView()->url(
                array('user_slug' => $params['userSlug']), 
                'grid_user'))
            ->setExportAction($this->getView()->url(
                array('user_slug' => $params['userSlug']), 
                'grid_user/export'));
    }
    
    public function getTypeOptions()
    {
        return array_merge(array('' => '- any -'), Project_Issue::$typeLabels);
    }
    
    public function getStatusOptions()
    {
        return array_merge(array('' => '- any -'), Project_Issue::$statusLabels);
    }
    
    public function getPriorityOptions()
    {
        return array(
            '' => '- any -',
            Project_Issue::PRIORITY_CRITICAL => 'critical',
            Project_Issue::PRIORITY_HIGH => 'high',
            Project_Issue::PRIORITY_LOW => 'low',
            Project_Issue::PRIORITY_NORMAL => 'normal',
            Project_Issue::PRIORITY_POSTPONED => 'postponed'
        );
    }
    
    public function getMembersOptions($params)
    {
        if (isset($params['projectId']))
            return Doctrine::getTable('Project_Member')
                ->fetchMembersAsOptions($params['projectId']);
        return Doctrine::getTable('User')->fetchUsersAsOptions();
    }
    
    public function getComponentOptions($params)
    {
        if (!isset($params['projectId']))
            throw new FreeCode_Exception("Component filter needs a specified project id!");
        return Doctrine::getTable('Project_Component')
            ->fetchComponentsAsOptions($params['projectId']);
    }
    
    public function getMilestoneOptions($params)
    {
        if (!isset($params['projectId']))
            throw new FreeCode_Exception("Milestone filter needs a specified project id!");
        return Doctrine::getTable('Project_Milestone')
            ->fetchMilestonesAsOptions($params['projectId']);
    }
    
    public function getProjectsAsOptions($params)
    {
        $table = Doctrine::getTable('Project');
        if (isset($params['userId'])) {
            $query = $table->getAvailableProjectsQuery($params['userId']);
        } else {
            $query = $table->getPublicProjectsQuery();
        }
        
        $options = array();
        $options[0] = '- any -';
        $records = $query->execute();
        foreach ($records as $record)
            $options[$record['id']] = $record['name'];
        return $options;
    }
    
}
