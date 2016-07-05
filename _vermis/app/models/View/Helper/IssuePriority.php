<?php

/**
 * =============================================================================
 * @file        IssuePriority.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: IssuePriority.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
