<?php

/**
 * =============================================================================
 * @file        Project/GridController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: GridController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Project_GridController
 * @brief   Project grid controller.
 */
class Project_GridController extends FreeCode_Grid_Controller
{

    public function init()
    {
        parent::init();
        
        $projectSlug = $this->_request->getParam('project_slug');
        $project = Doctrine::getTable('Project')->findOneBySlug($projectSlug);
        if (!$project)
            throw new FreeCode_Exception_RecordNotFound("Project");
        $s = $project->slug;

        $params = array(
            'projectId' => $project->id,
            'projectSlug' => $project->slug
        );
            
        $this
            ->registerGrid(new Grid_Project_Issues($params, 'project_issues'.$s))
            ->registerGrid(new Grid_Project_Notes($params, 'project_notes'.$s))
            ->registerGrid(new Grid_Project_Milestones($params, 'project_milestones'.$s))
            ->registerGrid(new Grid_Project_Components($params, 'project_components'.$s))
            ;
            
        if ($this->_identity) {
            $params = array(
                'projectId' => $project->id,
                'projectSlug' => $project->slug,
                'userId' => $this->_identity->id,
                'userSlug' => $this->_identity->slug
            );
            $this->registerGrid(new Grid_Project_Issues_My($params, 'project_issues_my'.$s));
        }
        
        $this
            ->registerGrid(new Grid_Project_Issues_Latest($params, 'project_issues_latest'.$s))
            ->registerGrid(new Grid_Project_Issues_Navigator($params, 'project_issues_navigator'.$s))
            ->registerGrid(new Grid_Project_Members($params, 'project_members'.$s));
            
        $componentSlug = $this->_request->getParam('component_slug');
        if (!empty($componentSlug)) {
            $component = Doctrine::getTable('Project_Component')
                ->fetchComponent($project->id, $componentSlug);
            if (!$component)
                throw new FreeCode_Exception_RecordNotFound("Project_Component");
            $params = array(
                'projectId' => $project->id,
                'projectSlug' => $project->slug,
                'componentId' => $component->id,
                'componentSlug' => $component->slug
            );
            if ($this->_identity) {
                $params['userId'] = $this->_identity->id;
            }
            $this->registerGrid(new Grid_Project_Issues_Component($params, 
            	'project_issues_component'.$s));
        }
            
        $milestoneSlug = $this->_request->getParam('milestone_slug');
        if (!empty($milestoneSlug)) {
            $milestone = Doctrine::getTable('Project_Milestone')
                ->fetchMilestone($project->id, $milestoneSlug);
            if (!$milestone)
                throw new FreeCode_Exception_RecordNotFound("Project_Milestone");
            $params = array(
                'projectId' => $project->id,
                'projectSlug' => $project->slug,
                'milestoneId' => $milestone->id,
                'milestoneSlug' => $milestone->slug
            );
            if ($this->_identity) {
                $params['userId'] = $this->_identity->id;
            }
            $this->registerGrid(new Grid_Project_Issues_Milestone($params, 
            	'project_issues_milestone'.$s));
        }
    }
}
