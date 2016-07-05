<?php

/**
 * =============================================================================
 * @file        NoteLink.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: NoteLink.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class View_Helper_NoteLink
 * @brief Helper for link rendering.
 */
class View_Helper_NoteLink
{

    protected $_view = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function noteLink($projectSlug, $noteSlug, $title, $router = 'project/notes/show')
    {
        if (!isset($noteSlug))
            return 'None';
        $config = FreeCode_Config::getInstance();
        $url = $config->baseHost.$this->_view->url(
            array(
                'project_slug' => $projectSlug,
                'note_slug' => $noteSlug
            ), 
            $router
        );
        $title = $this->_view->escape($title);
        return '<a href="'.$url.'" title="'.$title.'">'.$title.'</a>';
    }

}
