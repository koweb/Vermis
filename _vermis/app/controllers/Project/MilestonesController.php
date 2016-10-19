<?php

/**
 * =============================================================================
 * @file        Project/MilestonesController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: MilestonesController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_MilestonesController
 * @brief   Milestones controller.
 */
class Project_MilestonesController extends Project_Controller
{

    public function init()
    {
        parent::init();
        $this->view->activeMenuTab = 'milestones';
        $this->view->headTitle()->prepend(_T('milestones'));
        $this->_breadCrumbs->addCrumb('milestones', 
            array('project_slug' => $this->_project->slug), 
            'project/milestones');
    }
    
    public function indexAction()
    {
        $milestonesGrid = new Grid_Project_Milestones(
            array(
            	'projectId' => $this->_project->id,
            	'projectSlug' => $this->_project->slug
            ),
            'project_milestones'.$this->_project->slug
        );
        $milestonesGrid
            ->restore()
            ->import();
        $this->view->milestonesGrid = $milestonesGrid;
    }
    
    public function newAction()
    {
        $this->_denyEditingForObservers();
        
        $this->_breadCrumbs->addCrumb('create_a_new_milestone');
        
        $form = new Form_Project_Milestone;
        $this->view->form = $form;
        
        $form->name->addValidator(new Validate_Project_Milestone($this->_project->id));

        if ($this->isPostRequest()) {
            if ($data = $this->validateForm($form)) {
                $milestone = new Project_Milestone;
                $milestone->setArray($data);
                $milestone->project_id = $this->_project->id;
                $milestone->description = stripslashes($data['description']);
                $milestone->name = stripslashes($data['name']);
                $milestone->author_id = $this->getIdentity()->id;
                $milestone->save();
            
                $this->view->success = true;
                $this->_flashMessages->addSuccess("milestone_has_been_created");
                $this->goToAction(
                    array(
                        'project_slug' => $this->_project->slug,
                        'milestone_slug' => $milestone->slug
                    ), 
                    'project/milestones/show');
            } else {
                $this->view->success = false;
            }
        }
    }
    
    public function showAction()
    {
        $milestone = $this->fetchMilestone();
        $this->view->milestone = $milestone;

        $params = array(
            'projectId' => $this->_project->id,
            'projectSlug' => $this->_project->slug,
            'milestoneId' => $milestone->id,
            'milestoneSlug' => $milestone->slug
        );
            
        if ($this->_identity) {
            $params['userId'] = $this->_identity->id;
        }
        
        $issuesGrid = new Grid_Project_Issues_Milestone(
            $params,
            'project_issues_milestone'.$this->_project->slug
        );
        $issuesGrid
            ->restore()
            ->import();
        $this->view->issuesGrid = $issuesGrid;
    }
    
    public function editAction()
    {
        $this->_denyEditingForObservers();
        
        $this->_breadCrumbs->addCrumb('Edit');
        
        $milestone = $this->fetchMilestone();
        $this->view->milestone = $milestone;
        
        $form = new Form_Project_Milestone;
        $this->view->form = $form;
        $form->populate($milestone->toArray());
        
        if ($this->isPostRequest()) {
            $data = $this->_request->getPost();
            
            if ($milestone->name != $data['name'])
                $form->name->addValidator(new Validate_Project_Milestone($this->_project->id));
            
            if ($data = $this->validateForm($form)) {
                $milestone->setArray($data);
                $milestone->description = stripslashes($data['description']);
                $milestone->name = stripslashes($data['name']);
                $milestone->changer_id = $this->getIdentity()->id;
                $milestone->save();
            
                $this->view->success = true;
                $this->_flashMessages->addSuccess("changes_have_been_saved");
                $this->goToAction(
                    array(
                        'project_slug' => $this->_project->slug,
                        'milestone_slug' => $milestone->slug
                    ), 
                    'project/milestones/show');
            } else {
                $this->view->success = false;
            }
        }
    }
    
    public function deleteAction()
    {
        $milestone = $this->fetchMilestone();
        $milestone->delete();
        $this->_flashMessages->addSuccess("milestone_has_been_deleted");
        $this->goToAction(array('project_slug' => $this->_project->slug), 
            'project/milestones');
    }
    
    public function historyAction()
    {
        $milestone = $this->fetchMilestone();
        $this->view->milestone = $milestone;
        
        $this->_breadCrumbs->addCrumb('history');
        
        $versions = $milestone->fetchVersions();
        $this->view->changes = ChangeProcessor::process($versions);
    }
    
    public function fetchMilestone()
    {
        $slug = $this->_request->getParam('milestone_slug');
        $milestone = Doctrine::getTable('Project_Milestone')
            ->fetchMilestone($this->_project->id, $slug);
        if (!$milestone)
            throw new FreeCode_Exception_RecordNotFound('Project_Milestone');
        $this->_breadCrumbs->addCrumb($milestone->name,
            array(
                'project_slug' => $this->_project->slug, 
                'milestone_slug' => $milestone->slug
            ),
            'project/milestones/show');
        $this->view->headTitle()->prepend($milestone->name);
        return $milestone;
    }
}
