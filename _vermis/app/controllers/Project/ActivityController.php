<?php

/**
 * =============================================================================
 * @file        Project/ActivityController.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ActivityController.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Project_ActivityController
 * @brief   Activity controller.
 */
class Project_ActivityController extends Project_Controller
{

    public function init()
    {
        parent::init();
        $this->view->activeMenuTab = 'activity';
        $this->view->headTitle()->prepend(_T('activity'));
        $this->_breadCrumbs->addCrumb('activity', 
            array('project_slug' => $this->_project->slug), 
            'project/activity');
    }
    
    public function indexAction()
    {
        $query = $this->_project->getActivityQuery();

        $page = (int) $this->_request->getParam('page');
        $pager = new Doctrine_Pager($query, $page, 30);
        $this->view->pager = $pager;
        
        $activity = $pager->execute();
        $this->view->activity = $activity;
    }
        
}
