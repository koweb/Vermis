<?php

/**
 * =============================================================================
 * @file        ActivityController.php
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
