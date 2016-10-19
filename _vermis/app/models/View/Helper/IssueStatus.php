<?php

/**
 * =============================================================================
 * @file        IssueStatus.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssueStatus.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class View_Helper_IssueStatus
 * @brief Helper for issues.
 */
class View_Helper_IssueStatus
{

    protected $_view = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function issueStatus($status)
    {
        $label = Project_Issue::getStatusLabel($status);
        switch ($status) {
            case Project_Issue::STATUS_OPENED:
                return '<span class="issue-status red">'.$label.'</span>';
            
            case Project_Issue::STATUS_IN_PROGRESS:
                return '<span class="issue-status orange">'.$label.'</span>';
                
            case Project_Issue::STATUS_RESOLVED:
                return '<span class="issue-status green">'.$label.'</span>';
                
            case Project_Issue::STATUS_CLOSED:
            default: 
                return '<span class="issue-status black">'.$label.'</span>';            
        }
    }

}
