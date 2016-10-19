<?php

/**
 * =============================================================================
 * @file        routes.default.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: routes.default.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

return array(

    /*
     * IndexController
     */

    'index' => new Zend_Controller_Router_Route(
        'index',
        array('module' => 'default', 'controller' => 'index', 'action' => 'index')
    ),

    /*
     * AuthController
     */

    'auth/login' => new Zend_Controller_Router_Route(
        'login',
        array('module' => 'default', 'controller' => 'auth', 'action' => 'login')
    ),

    'auth/logout' => new Zend_Controller_Router_Route(
        'logout',
        array('module' => 'default', 'controller' => 'auth', 'action' => 'logout')
    ),
    
    /*
     * GridController
     */

    'grid' => new Zend_Controller_Router_Route(
        'grid',
        array('module' => 'default', 'controller' => 'grid', 'action' => 'ajax')
    ),
    
    'grid/export' => new Zend_Controller_Router_Route(
        'grid/export',
        array('module' => 'default', 'controller' => 'grid', 'action' => 'export')
    ),
    
    'grid_user' => new Zend_Controller_Router_Route(
        'grid/user/:user_slug',
        array('module' => 'default', 'controller' => 'grid', 'action' => 'ajax')
    ),
    
    'grid_user/export' => new Zend_Controller_Router_Route(
        'grid/user/export/:user_slug',
        array('module' => 'default', 'controller' => 'grid', 'action' => 'export')
    ),
    
    /*
     * IssuesController
     */

    'issues' => new Zend_Controller_Router_Route(
        'issues',
        array('module' => 'default', 'controller' => 'issues', 'action' => 'index')
    ),
        
    'issues/new' => new Zend_Controller_Router_Route(
        'issues/new',
        array('module' => 'default', 'controller' => 'issues', 'action' => 'new')
    ),

    /*
     * ProjectsController
     */

    'projects' => new Zend_Controller_Router_Route(
        'projects',
        array('module' => 'default', 'controller' => 'projects', 'action' => 'index')
    ),
        
    'projects/new' => new Zend_Controller_Router_Route(
        'projects/new',
        array('module' => 'default', 'controller' => 'projects', 'action' => 'new')
    ),
    
    /*
     * UsersController
     */

    'users' => new Zend_Controller_Router_Route(
        'users',
        array('module' => 'default', 'controller' => 'users', 'action' => 'index')
    ),
    
    'users/new' => new Zend_Controller_Router_Route(
        'users/new',
        array('module' => 'default', 'controller' => 'users', 'action' => 'new')
    ),
    
    'users/show' => new Zend_Controller_Router_Route(
        'user/:user_slug',
        array('module' => 'default', 'controller' => 'users', 'action' => 'show')
    ),
    
    'users/reported-issues' => new Zend_Controller_Router_Route(
        'user/:user_slug/reported',
        array('module' => 'default', 'controller' => 'users', 'action' => 'reported-issues')
    ),
    
    'users/edit' => new Zend_Controller_Router_Route(
        'user/:user_slug/edit',
        array('module' => 'default', 'controller' => 'users', 'action' => 'edit')
    ),
    
    'users/delete' => new Zend_Controller_Router_Route(
        'user/:user_slug/delete',
        array('module' => 'default', 'controller' => 'users', 'action' => 'delete')
    ),
    
    'users/edit-profile' => new Zend_Controller_Router_Route(
        'user/:user_slug/edit-profile',
        array('module' => 'default', 'controller' => 'users', 'action' => 'edit-profile')
    ),

    'users/change-password' => new Zend_Controller_Router_Route(
        'user/:user_slug/change-password',
        array('module' => 'default', 'controller' => 'users', 'action' => 'change-password')
    ),

    'users/register' => new Zend_Controller_Router_Route(
        'users/register',
        array('module' => 'default', 'controller' => 'users', 'action' => 'register')
    ),
    
    'users/activate' => new Zend_Controller_Router_Route(
        'users/activate/:user_slug/:hash',
        array('module' => 'default', 'controller' => 'users', 'action' => 'activate')
    ),
    
    'users/remind-password' => new Zend_Controller_Router_Route(
        'users/remind-password',
        array('module' => 'default', 'controller' => 'users', 'action' => 'remind-password')
    ),
    
    'users/generate-password' => new Zend_Controller_Router_Route(
        'users/generate-password/:user_slug/:hash',
        array('module' => 'default', 'controller' => 'users', 'action' => 'generate-password')
    ),
    
    /*
     * ActivityController
     */

    'activity' => new Zend_Controller_Router_Route(
        'activity/:page',
        array('module' => 'default', 'controller' => 'activity', 'action' => 'index', 'page' => 1)
    ),
    
    /*
     * SearchController
     */

    'search' => new Zend_Controller_Router_Route(
        'search',
        array('module' => 'default', 'controller' => 'search', 'action' => 'index')
    )
    
    );
