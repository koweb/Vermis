<?php

/**
 * =============================================================================
 * @file        SearchController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: SearchController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   SearchController
 * @brief   Search controller.
 */
class SearchController extends Default_Controller
{

    public function init()
    {
        parent::init();
        $this->view->activeMenuTab = 'index';
        $this->view->headTitle()->prepend(_T('search'));
        $this->_breadCrumbs->addCrumb('search', array(), 'search');
    }
    
    public function indexAction()
    {
        $searchQuery = $this->_request->getParam('query');
        $this->view->searchQuery = $searchQuery;

        if (preg_match('/^(.*)-([0-9]+)$/', $searchQuery, $matches)) {
            $projectSlug = FreeCode_String::normalize($matches[1]);
            $issueNumber = $matches[2];
            $this->_tryToGoToIssue($projectSlug, $issueNumber);
        }

        if (preg_match('/^(.*)\\s([0-9]+)$/', $searchQuery, $matches)) {
            $projectSlug = FreeCode_String::normalize($matches[1]);
            $issueNumber = $matches[2];
            $this->_tryToGoToIssue($projectSlug, $issueNumber);
        }

        if (!$this->_identity) {
            $searchGrid = new Grid_Project_Issues_Search(array(
                'publicOnly' => true
            ));
            
        } else if ($this->_identity->isAdmin()) {
            $searchGrid = new Grid_Project_Issues_Search(array());
            
        } else {
            $searchGrid = new Grid_Project_Issues_Search(array(
                'userId' => $this->_identity->id,
                'userSlug' => $this->_identity->slug
            ));
        }
        
        $title = 
            _T('search_for').
            ' <strong>'.$this->view->escape(stripcslashes($searchQuery)).'</strong> '.
            _T('in_issues');
            
        $searchGrid
            ->restore()
            ->import()
            ->getToolbar('top')
            ->getElement('title')
            ->setCaption($title);
        $this->view->searchGrid = $searchGrid;
    }
    
    protected function _tryToGoToIssue($projectSlug, $issueNumber)
    {
        $project = Doctrine::getTable('Project')->findOneBySlug($projectSlug);
        if ($project) {
            
            if ($project->is_private) {
                if (!$this->_identity || !$this->_identity->isMemberOf($project->id))
                    return;
            }
                
            $issue = Doctrine::getTable('Project_Issue')
                ->fetchIssue($project->id, $issueNumber);
            if ($issue) {
                /// @TODO: testing
                $this->view->redirection = true;
                $this->view->issue = $issue;
                
                $this->goToAction(
                    array(
                        'project_slug' => $projectSlug,
                        'issue_number' => $issue->number,
                        'issue_slug'   => $issue->slug
                    ), 
                    'project/issues/show');
            } else {
                $this->view->redirection = false;
            }
        }
    }
    
}
