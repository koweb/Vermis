<?php

/**
 * =============================================================================
 * @file        Project/IndexController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IndexController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_IndexController
 * @brief   Index controller.
 */
class Project_IndexController extends Project_Controller
{

    public function init()
    {
        parent::init();
        $this->view->activeMenuTab = 'index';
        
        $this->view->milestones = $this->_project->getMilestonesQuery()->execute();
        $this->view->components = $this->_project->getComponentsQuery()->execute();
        $this->view->leaders = $this->_project->getLeadersQuery()->execute();
        $this->view->developers = $this->_project->getDevelopersQuery()->execute();
        $this->view->observers = $this->_project->getObserversQuery()->execute();
    }
    
    public function indexAction()
    {
        $gridParams = array(
            'projectId' => $this->_project->id,
            'projectSlug' => $this->_project->slug
        );
            
        if ($this->_identity) {
            
            $gridParams['userId'] = $this->_identity->id;
            $gridParams['userSlug'] = $this->_identity->slug;
            
            $myGrid = new Grid_Project_Issues_My(
                $gridParams,
                'project_issues_my'.$this->_project->slug
            );
            $myGrid
                ->restore()
                ->import();
            $this->view->myGrid = $myGrid;
        }
        
        $latestGrid = new Grid_Project_Issues_Latest(
            $gridParams,
            'project_issues_latest'.$this->_project->slug
        );
        $latestGrid->restore();
        $latestGrid->setSortColumn('update_time')->setSortOrder('desc');
        $latestGrid->import();
        $this->view->latestGrid = $latestGrid;
                
        $this->view->activity = $this->_project
            ->getActivityQuery()
            ->limit(10)
            ->execute();
    }
    
    public function editAction()
    {
        $this->_denyEditingForObservers();
        
        $this->_breadCrumbs->addCrumb(
            'edit', array('project_slug' => $this->_project->slug), 'project/index/edit');
            
        $form = new Form_Project;
        $form->populate($this->_project->toArray());
        $this->view->form = $form;

        if ($this->isPostRequest()) {
            $data = $this->_request->getPost();
            
            if ($this->_project->name != $data['name']) {
                $form->name->addValidator(new FreeCode_Validate_Doctrine_Unique('Project', 'name'));
                $form->name->addValidator(new FreeCode_Validate_Doctrine_UniqueSlug('Project', 'slug'));
            }
            
            if ($data = $this->validateForm($form)) {
                $this->_project->name = stripslashes($data['name']);
                $this->_project->description = stripslashes($data['description']);
                $this->_project->is_private = $data['is_private'];
                $this->_project->changer_id = $this->getIdentity()->id;
                $this->_project->save();
                
                $this->view->success = true;
                $this->_flashMessages->addSuccess("changes_have_been_saved");
                $this->goToAction(array('project_slug' => $this->_project->slug), 'project');
            } else {
                $this->view->success = false;
            }
        }
    }
    
    public function deleteAction()
    {
        $this->_project->delete();
        $this->_flashMessages->addSuccess("project_has_been_deleted");
        $this->goToAction(array(), 'projects');
    }
    
    public function historyAction()
    {
        $this->_breadCrumbs->addCrumb(
            'History', array('project_slug' => $this->_project->slug), 'project/index/history');
        
        $versions = $this->_project->fetchVersions();
        $this->view->changes = ChangeProcessor::process($versions);
    }
    
}
