<?php

/**
 * =============================================================================
 * @file        IssuePriority.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssuePriority.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class View_Helper_IssuePriority
 * @brief Helper for issues.
 */
class View_Helper_IssuePriority
{

    protected $_view = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function issuePriority($priority)
    {
        $label = Project_Issue::getPriorityLabel($priority);
        switch ($priority) {
            case Project_Issue::PRIORITY_CRITICAL:
                return '<span class="issue-priority red strong">'.$label.'</span>';
            
            case Project_Issue::PRIORITY_HIGH:
                return '<span class="issue-priority red">'.$label.'</span>';
                
            default: 
                return '<span class="issue-priority black">'.$label.'</span>';            
        }
    }

}
