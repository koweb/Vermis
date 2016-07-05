<?php

/**
 * =============================================================================
 * @file        IndexController.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: IndexController.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   IndexController
 * @brief   Index controller.
 */
class IndexController extends Default_Controller
{

    public function init()
    {
        parent::init();
        $this->view->activeMenuTab = 'index';
    }
    
    public function indexAction()
    {
        if ($this->_identity)
            $this->_dashboardAction();
        else
            $this->_homeAction();
    }
    
    protected function _homeAction()
    {
        $this->view->headTitle()->prepend(_T('home'));
        $this->_breadCrumbs->addCrumb('home', array(), 'index');
        
        $latestGrid = new Grid_Project_Issues_Latest(array(), 'issues_latest_dashboard');
        $latestGrid->restore();
        $latestGrid->setSortColumn('update_time')->setSortOrder('desc');
        $latestGrid->import();
        $this->view->latestGrid = $latestGrid;
                
        $this->view->activity = Doctrine::getTable('Log')
            ->getLogQuery()
            ->addWhere("p.is_private = false")
            ->limit(10)
            ->execute();
    }
    
    protected function _dashboardAction()
    {
        $this->view->headTitle()->prepend(_T('Dashboard'));
        $this->_breadCrumbs->addCrumb('Dashboard', array(), 'index');
        
        $gridParams = array(
            'userId' => $this->_identity->id,
            'userSlug' => $this->_identity->slug
        );
        
        $latestGrid = new Grid_Project_Issues_Latest($gridParams, 'issues_latest_dashboard');
        $latestGrid->restore();
        $latestGrid->setSortColumn('update_time')->setSortOrder('desc');
        $latestGrid->import();
        $this->view->latestGrid = $latestGrid;
                
        $myGrid = new Grid_Project_Issues_My($gridParams, 'issues_my_dashboard');
        $myGrid
            ->restore()
            ->import();
        $this->view->myGrid = $myGrid;
        
        $this->view->activity = $this->_identity
            ->getActivityQuery()
            ->limit(10)
            ->execute();
    }
    
}
