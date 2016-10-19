<?php

/**
 * =============================================================================
 * @file        ActivityController.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ActivityController.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   ActivityController
 * @brief   Activity controller.
 */
class ActivityController extends Default_Controller
{

    public function init()
    {
        parent::init();
        $this->view->activeMenuTab = 'activity';
        $this->view->headTitle()->prepend(_T('activity'));
        $this->_breadCrumbs->addCrumb('activity', array(), 'activity');
    }
    
    public function indexAction()
    {
        if ($this->_identity)
            $query = $this->_identity->getActivityQuery();
        else
            $query = Doctrine::getTable('Log')
                ->getLogQuery()
                ->addWhere("p.is_private = false");

        $page = (int) $this->_request->getParam('page');
        $pager = new Doctrine_Pager($query, $page, 30);
        $this->view->pager = $pager;
        
        $activity = $pager->execute();
        $this->view->activity = $activity;
    }
    
}
