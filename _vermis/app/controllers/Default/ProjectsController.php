<?php

/**
 * =============================================================================
 * @file        Default/ProjectsController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ProjectsController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   ProjectsController
 * @brief   Projects controller.
 */
class ProjectsController extends Default_Controller
{

    public function init()
    {
        parent::init();
        $this->view->activeMenuTab = 'projects';
        $this->view->headTitle()->prepend(_T('Projects'));
        $this->_breadCrumbs->addCrumb('Projects', array(), 'projects');
    }
    
    public function indexAction()
    {
        if (!$this->_identity) {
            $projectsGrid = new Grid_Projects(array(
                'publicOnly' => true
            ));
        
        } else if ($this->_identity->isAdmin()) {
            $projectsGrid = new Grid_Projects(array());
        
        } else {
            $projectsGrid = new Grid_Projects(array(
                'userId' => $this->_identity->id,
                'userSlug' => $this->_identity->slug
            ));
        }
        
        $projectsGrid
            ->restore()
            ->import();
        $this->view->projectsGrid = $projectsGrid;
    }
    
    public function newAction()
    {
        $this->_breadCrumbs->addCrumb('create_a_new_project', array(), 'projects/new');
        
        $form = new Form_Project(Form_Project::TYPE_NEW);
        $this->view->form = $form;

        $form->name->addValidator(new FreeCode_Validate_Doctrine_Unique('Project', 'name'));
        $form->name->addValidator(new FreeCode_Validate_Doctrine_UniqueSlug('Project', 'slug'));
        
        if ($this->isPostRequest()) {
            if ($data = $this->validateForm($form)) {
                
                $project = new Project;
                $project->name = stripslashes($data['name']);
                $project->slug = FreeCode_String::normalize($data['name']);
                $project->author_id = $this->getIdentity()->id;
                $project->changer_id = $this->getIdentity()->id;
                $project->description = stripslashes($data['description']);
                $project->is_private = $data['is_private'];
                $project->save();
            
                if (isset($data['join_project']) && $data['join_project'] == 1) {
                    $pm = new Project_Member;
                    $pm->project_id = $project->id;
                    $pm->user_id = $this->_identity->id;
                    $pm->role = Project_Member::ROLE_LEADER;
                    $pm->save();
                }
                
                $this->view->success = true;
                $this->_flashMessages->addSuccess("project_has_been_created");
                $this->goToAction(array('project_slug' => $project->slug), 'project');
            } else {
                $this->view->success = false;
            }
        }
    }
    
}
