<?php

/**
 * =============================================================================
 * @file        Project/ActivityController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ActivityController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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
