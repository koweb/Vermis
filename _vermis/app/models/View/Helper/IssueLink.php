<?php

/**
 * =============================================================================
 * @file        IssueLink.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: IssueLink.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class View_Helper_IssueLink
 * @brief Helper for link rendering.
 */
class View_Helper_IssueLink
{

    protected $_view = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function issueLink(
        $projectSlug, 
        $issueNumber,
        $issueSlug, 
        $title, 
        $router = 'project/issues/show'
    )
    {
        if (!isset($issueSlug) || !isset($issueNumber))
            return 'None';
        $config = FreeCode_Config::getInstance();
        $url = $config->baseHost.$this->_view->url(
            array(
                'project_slug' => $projectSlug,
                'issue_number' => $issueNumber,
                'issue_slug'   => $issueSlug
            ), 
            $router
        );
        $title = $this->_view->escape($title);
        return '<a href="'.$url.'" title="'.$title.'">'.$title.'</a>';
    }

}
