<?php

/**
 * =============================================================================
 * @file        IssuesController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssuesController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   IssuesController
 * @brief   Issues controller.
 */
class IssuesController extends Default_Controller
{

    protected $_issuesNavigator = null;

    public function init()
    {
        parent::init();
        $this->view->activeMenuTab = 'issues';
        $this->view->headTitle()->prepend(_T('Issues'));
        $this->_breadCrumbs->addCrumb('Issues', array(), 'issues');
    }
    
    public function indexAction()
    {
        $params = array();
        if ($this->_identity) {
            $params['userId'] = $this->_identity->id;
            $params['userSlug'] = $this->_identity->slug;      
        }
        
        $issuesGrid = new Grid_Project_Issues_Navigator($params, 'issues_navigator_dashboard');
        $issuesGrid
            ->restore()
            ->import();
            
        $this->view->issuesGrid = $issuesGrid;
    }
    
    public function newAction()
    {
        $this->_breadCrumbs->addCrumb('create_a_new_issue');
        
        $form = new Form_Project_SimpleIssue($this->_identity->id);
        $this->view->form = $form;
        
        if ($this->isPostRequest()) {
            if ($data = $this->validateForm($form)) {
                
                $project = Doctrine::getTable('Project')->find((int) $data['project_id']);
                if (!$project)
                    throw new FreeCode_Exception_RecordNotFound('Project');
                    
                $isMember = $this->_identity->isMemberOf($project->id);
                if (!$isMember) {
                    if ($project->is_private)
                        throw new FreeCode_Exception_AccessDenied();
                        
                    // Join to the project.
                    $pm = new Project_Member;
                    $pm->user_id = $this->_identity->id;
                    $pm->project_id = $project->id;
                    $pm->role = Project_Member::ROLE_OBSERVER;
                    $pm->save();
                }
                    
                $issue = new Project_Issue;
                $issue->project_id = $project->id;
                $issue->slug = FreeCode_String::normalize($data['title']);
                $issue->number = $project->issue_counter + 1;
                $issue->reporter_id = $this->_identity->id;
                $issue->changer_id = $this->_identity->id;
                $issue->description = stripslashes($data['description']);
                $issue->title = stripslashes($data['title']);
                $issue->type = $data['type'];
                
                /// @TODO: doctrine bug?
                $project->issue_counter = $project->issue_counter + 1;                     
                $project->save();
                
                $issue->save();
            
                $this->view->success = true;
                $this->_flashMessages->addSuccess("issue_has_been_created");
                $this->goToAction(
                    array(
                        'project_slug' => $project->slug,
                        'issue_number' => $issue->number,
                        'issue_slug' => $issue->slug
                    ), 
                    'project/issues/show');
            } else {
                $this->view->success = false;
            }
        }
    }
    
}
