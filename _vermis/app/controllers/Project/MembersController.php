<?php

/**
 * =============================================================================
 * @file        Project/MembersController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: MembersController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Project_MembersController
 * @brief   Members controller.
 */
class Project_MembersController extends Project_Controller
{

    public function init()
    {
        parent::init();
        $this->view->activeMenuTab = 'members';
        $this->view->headTitle()->prepend(_T('members'));
        $this->_breadCrumbs->addCrumb('members', 
            array('project_slug' => $this->_project->slug), 
            'project/members');
    }
    
    public function indexAction()
    {
        $params = array(
            'projectId' => $this->_project->id,
            'projectSlug' => $this->_project->slug
        );
        if ($this->_identity) {
            $params['userId'] = $this->_identity->id;
        }
        $membersGrid = new Grid_Project_Members(
            $params,
            'project_members'.$this->_project->slug
        );
        $membersGrid
            ->restore()
            ->import();
        $this->view->membersGrid = $membersGrid;
                
        $form = new Form_Project_Member($this->_project->id);
        $form->setAction($this->url(
            array('project_slug'  => $this->_project->slug),
            'project/members/add'));
        $this->view->form = $form;
        
        $this->view->nonMembersCount = $this->_project->getNonMembersCount();
    }
        
    public function addAction()
    {
        $userId = (int) $this->_request->getParam('user_id');

        if (Doctrine::getTable('Project_Member')
                ->memberExists($this->_project->id, $userId))
            throw new FreeCode_Exception_RecordAlreadyExists('Project_Member');
        
        $pm = new Project_Member;
        $pm->project_id = $this->_project->id;
        $pm->user_id = $userId;
        $pm->role = $this->_request->getPost('role');
        $pm->save();
        $this->_flashMessages->addSuccess("user_has_been_added_to_this_project");
        $this->goBack();
    }
    
    public function deleteAction()
    {
        $selected = $this->getRequest()->getParam('selected');
        if (!is_array($selected))
            $this->goBack();
            
        $table = Doctrine::getTable('Project_Member');
        foreach ($selected as $userId) {
            $table->deleteMember($this->_project->id, $userId);
        }
        
        $this->_flashMessages->addSuccess("user_has_been_removed_from_this_project");
        $this->goBack();
    }
    
    public function joinAction()
    {
        if (Doctrine::getTable('Project_Member')
                ->memberExists($this->_project->id, $this->_identity->id))
            throw new FreeCode_Exception_RecordAlreadyExists('Project_Member');
        
        $pm = new Project_Member;
        $pm->project_id = $this->_project->id;
        $pm->user_id = $this->_identity->id;
        $pm->role = Project_Member::ROLE_OBSERVER;
        $pm->save();
        $this->_flashMessages->addSuccess("you_have_joined_to_this_project");
        $this->goBack();
    }

    public function leaveAction()
    {
        if (!Doctrine::getTable('Project_Member')
                ->memberExists($this->_project->id, $this->_identity->id))
            throw new FreeCode_Exception_RecordNotFound('Project_Member');
        
        Doctrine::getTable('Project_Member')
            ->deleteMember($this->_project->id, $this->_identity->id);
        $this->_flashMessages->addSuccess("you_have_left_this_project");
        
        if ($this->_project->is_private)
            $this->goToAction(array(), 'projects');
        else
            $this->goBack();
    }
    
}
