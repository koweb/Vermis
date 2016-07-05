<?php

/**
 * =============================================================================
 * @file        Project/IssuesController.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: IssuesController.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_IssuesController
 * @brief   Issues controller.
 */
class Project_IssuesController extends Project_Controller
{

    protected $_issuesNavigator = null;

    public function init()
    {
        parent::init();
        $this->view->activeMenuTab = 'issues';
        $this->view->headTitle()->prepend(_T('Issues'));
        $this->_breadCrumbs->addCrumb('Issues', 
            array('project_slug' => $this->_project->slug), 
            'project/issues');
    }
    
    public function indexAction()
    {
        $params = array(
            'projectId' => $this->_project->id,
            'projectSlug' => $this->_project->slug
        );
        
        if ($this->_identity) {
            $params['userId'] = $this->_identity->id;
            $params['userSlug'] = $this->_identity->slug;      
        }
        
        $issuesGrid = new Grid_Project_Issues_Navigator(
            $params,
            'project_issues_navigator'.$this->_project->slug
        );
        $issuesGrid
            ->restore()
            ->import();
        
        $this->view->issuesGrid = $issuesGrid;
    }

    public function newAction()
    {
        $this->_breadCrumbs->addCrumb('create_a_new_issue');
        
        $form = new Form_Project_Issue($this->_project->id);
        $this->view->form = $form;
        
        if ($this->isPostRequest()) {
            if ($data = $this->validateForm($form)) {
                
                /**
                 * Vermis-130
                 */
                if (!$this->_identity->isMemberOf($this->_project->id)) {
                    $pm = new Project_Member;
                    $pm->user_id = $this->_identity->id;
                    $pm->project_id = $this->_project->id;
                    $pm->role = Project_Member::ROLE_OBSERVER;
                    $pm->save();
                }
                
                $issue = new Project_Issue;
                $issue->setArray($data);
                $issue->slug = FreeCode_String::normalize($data['title']);
                $issue->project_id = $this->_project->id;
                $issue->number = $this->_project->issue_counter + 1;
                $issue->reporter_id = $this->_identity->id;
                $issue->changer_id = $this->_identity->id;
                if ($data['assignee_id'] == 0)
                    $issue->assignee_id = null;
                if ($data['component_id'] == 0)
                    $issue->component_id = null;
                if ($data['milestone_id'] == 0)
                    $issue->milestone_id = null;
                $issue->description = stripslashes($data['description']);
                $issue->title = stripslashes($data['title']);
                
                /// @TODO: doctrine bug?
                $this->_project->issue_counter = $this->_project->issue_counter + 1;                     
                $this->_project->save();
                
                $issue->save();
            
                $this->view->success = true;
                $this->_flashMessages->addSuccess("issue_has_been_created");
                $this->goToAction(
                    array(
                        'project_slug' => $this->_project->slug,
                        'issue_number' => $issue->number,
                        'issue_slug' => $issue->slug
                    ), 
                    'project/issues/show');
            } else {
                $this->view->success = false;
            }
        }
    }
    
    public function showAction()
    {
        $issue = $this->fetchIssue();
        $this->view->issue = $issue;
        
        $this->_uploadSection($issue);
        
        $this->view->comments = $issue->getCommentsQuery()->execute(); 
        
        $commentForm = new Form_Comment;
        $commentForm->setAction($this->url(
            array(
                'project_slug' => $this->_project->slug,
                'issue_number' => $issue->number
            ),
            'project/issues_comments/add'
        ));
        $this->view->commentForm = $commentForm;        
    }
    
    public function editAction()
    {
        $this->_denyEditingForObservers();
        
        $issue = $this->fetchIssue();
        $this->view->issue = $issue;
        
        $this->_uploadSection($issue);
        
        $this->_breadCrumbs->addCrumb('edit');
        
        $form = new Form_Project_Issue($this->_project->id);
        $form->populate($issue->toArray());
        $this->view->form = $form;
        
        if ($this->isPostRequest()) {
            if ($data = $this->validateForm($form)) {
                $issue->setArray($data);
                $issue->slug = FreeCode_String::normalize($data['title']);
                if ($data['assignee_id'] == 0)
                    $issue->assignee_id = null;
                if ($data['component_id'] == 0)
                    $issue->component_id = null;
                if ($data['milestone_id'] == 0)
                    $issue->milestone_id = null;
                $issue->description = stripslashes($data['description']);
                $issue->title = stripslashes($data['title']);
                $issue->changer_id = $this->_identity->id;
                $issue->save();

                $this->view->success = true;
                $this->_flashMessages->addSuccess("changes_have_been_saved");
                $this->goToAction(
                    array(
                        'project_slug' => $this->_project->slug,
                        'issue_number' => $issue->number,
                        'issue_slug' => $issue->slug
                    ), 
                    'project/issues/show');
            } else {
                $this->view->success = false;
            }
        }
    }
    
    public function deleteAction()
    {
        $issue = $this->fetchIssue();
        $issue->delete();
        $this->_flashMessages->addSuccess("issue_has_been_deleted");
        $this->goToAction(array('project_slug' => $this->_project->slug),
            'project/issues');
    }
    
    public function historyAction()
    {
        $issue = $this->fetchIssue();
        $this->view->issue = $issue;
        
        $this->_uploadSection($issue);
        
        $this->_breadCrumbs->addCrumb('History');
        
        $versions = $issue->fetchVersions();
        $this->view->changes = ChangeProcessor::process($versions);
    }
    
    public function fetchIssue()
    {
        $issueNumber = (int) $this->_request->getParam('issue_number');
        $issue = Doctrine::getTable('Project_Issue')
            ->fetchIssue($this->_project->id, $issueNumber);
        if (!$issue)
            throw new FreeCode_Exception_RecordNotFound('Project_Issue');
        $this->_breadCrumbs->addCrumb($issue->title,
            array(
                'project_slug' => $this->_project->slug,
                'issue_number' => $issueNumber,
                'issue_slug' => $issue->slug),
            'project/issues/show');
        $this->view->headTitle()->prepend($this->_project->name.'-'.$issueNumber.' # '.$issue->title);
        return $issue;
    }
    
    protected function _uploadSection($issue)
    {
        $uploadForm = new Form_Upload();
        $uploadForm->setAction($this->url(
            array(
                'project_slug' => $this->_project->slug,
                'issue_number' => $issue->number
            ),
            'project/issues_files/upload'
        ));
        $this->view->uploadForm = $uploadForm;
        $this->view->files = $issue->getFilesQuery()->execute();
    }
    
    protected function _createPager($query)
    {
        $query = $this->bindSortParams($query, 'number', 'desc');
        $page = (int) $this->_request->getParam('page');
        $pager = new Doctrine_Pager($query, $page, 30);
        $this->view->pager = $pager;
        $this->view->issues = $pager->execute();
    }
    
}
