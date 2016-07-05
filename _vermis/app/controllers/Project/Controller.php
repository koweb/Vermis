<?php

/**
 * =============================================================================
 * @file        Project/Controller.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Controller.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_Controller
 * @brief   Base controller for project module.
 */
class Project_Controller extends Controller
{
    
    protected $_project = null;
    protected $_projectRole = null;
    
    public function init()
    {
        parent::init();
        
        $this->_project = $this->fetchProject();
        $this->view->project = $this->_project;

        // Disable access for users who are not assigned to the project.
        if ($this->_project->is_private) {
            if (!$this->_identity) {
                
                // Redirect to the login screen.
                $this->disableView();
                $this->_helper->actionStack('login', 'auth', 'default');
                
            } else if ( !$this->_identity->isAdmin() &&
                        !$this->_identity->isMemberOf($this->_project->id)) {
                throw new FreeCode_Exception_AccessDenied(
                    "you_are_not_allowed_to_access_this_project");
            }
        }
        
        if ($this->_identity) {
            $this->_projectRole = Doctrine::getTable('Project_Member')
                ->getRole($this->_project->id, $this->_identity->id);
            $this->view->projectRole = $this->_projectRole;
        }
        
        $this->_breadCrumbs->addCrumb('projects', array(), 'projects'); 
        $this->_breadCrumbs->addCrumb(
            $this->_project->name,
           array('project_slug' => $this->_project->slug), 'project');
           
        $this->view->headTitle()->prepend($this->_project->name);
        
        Zend_Registry::set('projectId', $this->_project->id);
    }
    
    /**
     * Fetch project by slug.
     * @return Project
     */
    public function fetchProject()
    {
        $slug = $this->_request->getParam('project_slug');
        $record = Doctrine::getTable('Project')->findOneBySlug($slug);
        if (!$record)
            throw new FreeCode_Exception_RecordNotFound('Project');
        return $record;
    }
    
    /**
     * Set project.
     * @param   Project $project
     * @param   Project_Controller
     */
    public function setProject(Project $project)
    {
        $this->_project = $project;
        return $this;
    }
    
    /**
     * Get project.
     * @return  Project
     */
    public function getProject()
    {
        return $this->_project;    
    }
    
    /**
     * Deny access to the page to all observers.
     * @throws FreeCode_Exception_AccessDenied
     */
    protected function _denyEditingForObservers()
    {
        if (    $this->_identity && 
                !$this->_identity->isAdmin() && 
                $this->_projectRole == Project_Member::ROLE_OBSERVER)
            throw new FreeCode_Exception_AccessDenied("you_dont_have_an_access_to_create_or_edit_this_item");
    }
    
}
