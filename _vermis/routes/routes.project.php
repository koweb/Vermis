<?php

/**
 * =============================================================================
 * @file        routes.project.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: routes.project.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

return array(

    /*
     * Project_IndexController
     */

    'project' => new Zend_Controller_Router_Route(
        'project/:project_slug',
        array('module' => 'project', 'controller' => 'index', 'action' => 'index')
    ),

    'project/index/edit' => new Zend_Controller_Router_Route(
        'project/:project_slug/edit',
        array('module' => 'project', 'controller' => 'index', 'action' => 'edit')
    ),
    
    'project/index/delete' => new Zend_Controller_Router_Route(
        'project/:project_slug/delete',
        array('module' => 'project', 'controller' => 'index', 'action' => 'delete')
    ),
    
    'project/index/history' => new Zend_Controller_Router_Route(
        'project/:project_slug/history/:page',
        array('module' => 'project', 'controller' => 'index', 'action' => 'history', 'page' => 1)
    ),
    
    /*
     * Project_GridController
     */

    'project/grid' => new Zend_Controller_Router_Route(
        'project/:project_slug/grid',
        array('module' => 'project', 'controller' => 'grid', 'action' => 'ajax')
    ),
    
    'project/grid/export' => new Zend_Controller_Router_Route(
        'project/:project_slug/grid/export',
        array('module' => 'project', 'controller' => 'grid', 'action' => 'export')
    ),
    
    'project/grid_component' => new Zend_Controller_Router_Route(
        'project/:project_slug/grid/component/:component_slug',
        array('module' => 'project', 'controller' => 'grid', 'action' => 'ajax')
    ),
    
    'project/grid_component/export' => new Zend_Controller_Router_Route(
        'project/:project_slug/grid/component/export/:component_slug',
        array('module' => 'project', 'controller' => 'grid', 'action' => 'export')
    ),
    
    'project/grid_milestone' => new Zend_Controller_Router_Route(
        'project/:project_slug/grid/milestone/:milestone_slug',
        array('module' => 'project', 'controller' => 'grid', 'action' => 'ajax')
    ),
    
    'project/grid_milestone/export' => new Zend_Controller_Router_Route(
        'project/:project_slug/grid/milestone/export/:milestone_slug',
        array('module' => 'project', 'controller' => 'grid', 'action' => 'export')
    ),
    
    /*
     * Project_MilestonesController
     */

    'project/milestones' => new Zend_Controller_Router_Route(
        'project/:project_slug/milestones/:page',
        array('module' => 'project', 'controller' => 'milestones', 'action' => 'index', 'page' => 1)
    ),

    'project/milestones/new' => new Zend_Controller_Router_Route(
        'project/:project_slug/milestones/new',
        array('module' => 'project', 'controller' => 'milestones', 'action' => 'new')
    ),
    
    'project/milestones/show' => new Zend_Controller_Router_Route(
        'project/:project_slug/milestone/:milestone_slug/:page',
        array('module' => 'project', 'controller' => 'milestones', 'action' => 'show', 'page' => 1)
    ),

    'project/milestones/edit' => new Zend_Controller_Router_Route(
        'project/:project_slug/milestone/:milestone_slug/edit',
        array('module' => 'project', 'controller' => 'milestones', 'action' => 'edit')
    ),

     'project/milestones/delete' => new Zend_Controller_Router_Route(
        'project/:project_slug/milestone/:milestone_slug/delete',
        array('module' => 'project', 'controller' => 'milestones', 'action' => 'delete')
    ),

    'project/milestones/history' => new Zend_Controller_Router_Route(
        'project/:project_slug/milestone/:milestone_slug/history/:page',
        array('module' => 'project', 'controller' => 'milestones', 'action' => 'history', 'page' => 1)
    ),

    /*
     * Project_ComponentsController
     */

    'project/components' => new Zend_Controller_Router_Route(
        'project/:project_slug/components/:page',
        array('module' => 'project', 'controller' => 'components', 'action' => 'index', 'page' => 1)
    ),

    'project/components/new' => new Zend_Controller_Router_Route(
        'project/:project_slug/components/new',
        array('module' => 'project', 'controller' => 'components', 'action' => 'new')
    ),
    
    'project/components/show' => new Zend_Controller_Router_Route(
        'project/:project_slug/component/:component_slug/:page',
        array('module' => 'project', 'controller' => 'components', 'action' => 'show', 'page' => 1)
    ),

    'project/components/edit' => new Zend_Controller_Router_Route(
        'project/:project_slug/component/:component_slug/edit',
        array('module' => 'project', 'controller' => 'components', 'action' => 'edit')
    ),

     'project/components/delete' => new Zend_Controller_Router_Route(
        'project/:project_slug/component/:component_slug/delete',
        array('module' => 'project', 'controller' => 'components', 'action' => 'delete')
    ),

    'project/components/history' => new Zend_Controller_Router_Route(
        'project/:project_slug/component/:component_slug/history/:page',
        array('module' => 'project', 'controller' => 'components', 'action' => 'history', 'page' => 1)
    ),

    /*
     * Project_IssuesController
     */

    'project/issues' => new Zend_Controller_Router_Route(
        'project/:project_slug/issues',
        array('module' => 'project', 'controller' => 'issues', 'action' => 'index')
    ),

    'project/issues/new' => new Zend_Controller_Router_Route(
        'project/:project_slug/issues/new',
        array('module' => 'project', 'controller' => 'issues', 'action' => 'new')
    ),

    'project/issues/show' => new Zend_Controller_Router_Route(
        'project/:project_slug/issue/:issue_number/:issue_slug',
        array('module' => 'project', 'controller' => 'issues', 'action' => 'show')
    ),
    
    'project/issues/edit' => new Zend_Controller_Router_Route(
        'project/:project_slug/issue/:issue_number/:issue_slug/edit',
        array('module' => 'project', 'controller' => 'issues', 'action' => 'edit')
    ),
    
    'project/issues/delete' => new Zend_Controller_Router_Route(
        'project/:project_slug/issue/:issue_number/:issue_slug/delete',
        array('module' => 'project', 'controller' => 'issues', 'action' => 'delete')
    ),
    
    'project/issues/history' => new Zend_Controller_Router_Route(
        'project/:project_slug/issue/:issue_number/:issue_slug/history/:page',
        array('module' => 'project', 'controller' => 'issues', 'action' => 'history', 'page' => 1)
    ),
    
    /*
     * Project_Issues_CommentsController
     */

    'project/issues_comments/add' => new Zend_Controller_Router_Route(
        'project/:project_slug/issue/:issue_number/comments/add',
        array('module' => 'project', 'controller' => 'issues_comments', 'action' => 'add')
    ),

    'project/issues_comments/delete' => new Zend_Controller_Router_Route(
        'project/:project_slug/issue/:issue_number/comments/delete/:comment_id',
        array('module' => 'project', 'controller' => 'issues_comments', 'action' => 'delete')
    ),

    /*
     * Project_Issues_FilesController
     */

    'project/issues_files/upload' => new Zend_Controller_Router_Route(
        'project/:project_slug/issue/:issue_number/files/upload',
        array('module' => 'project', 'controller' => 'issues_files', 'action' => 'upload')
    ),

    'project/issues_files/download' => new Zend_Controller_Router_Route(
        'project/:project_slug/issue/:issue_number/files/download/:file_id',
        array('module' => 'project', 'controller' => 'issues_files', 'action' => 'download')
    ),

    'project/issues_files/delete' => new Zend_Controller_Router_Route(
        'project/:project_slug/issue/:issue_number/files/delete/:file_id',
        array('module' => 'project', 'controller' => 'issues_files', 'action' => 'delete')
    ),

    /*
     * Project_MembersController
     */

    'project/members' => new Zend_Controller_Router_Route(
        'project/:project_slug/members',
        array('module' => 'project', 'controller' => 'members', 'action' => 'index')
    ),

    'project/members/add' => new Zend_Controller_Router_Route(
        'project/:project_slug/members/add',
        array('module' => 'project', 'controller' => 'members', 'action' => 'add')
    ),
    
    'project/members/delete' => new Zend_Controller_Router_Route(
        'project/:project_slug/members/delete',
        array('module' => 'project', 'controller' => 'members', 'action' => 'delete')
    ),
    
    'project/members/join' => new Zend_Controller_Router_Route(
        'project/:project_slug/members/join',
        array('module' => 'project', 'controller' => 'members', 'action' => 'join')
    ),
    
    'project/members/leave' => new Zend_Controller_Router_Route(
        'project/:project_slug/members/leave',
        array('module' => 'project', 'controller' => 'members', 'action' => 'leave')
    ),
    
    /*
     * Project_ActivityController
     */

    'project/activity' => new Zend_Controller_Router_Route(
        'project/:project_slug/activity/:page',
        array('module' => 'project', 'controller' => 'activity', 'action' => 'index', 'page' => 0)
    ),

    /*
     * Project_NotesController
     */

    'project/notes' => new Zend_Controller_Router_Route(
        'project/:project_slug/notes/:page',
        array('module' => 'project', 'controller' => 'notes', 'action' => 'index', 'page' => 1)
    ),

    'project/notes/new' => new Zend_Controller_Router_Route(
        'project/:project_slug/notes/new',
        array('module' => 'project', 'controller' => 'notes', 'action' => 'new')
    ),
    
    'project/notes/show' => new Zend_Controller_Router_Route(
        'project/:project_slug/note/:note_slug',
        array('module' => 'project', 'controller' => 'notes', 'action' => 'show')
    ),

    'project/notes/edit' => new Zend_Controller_Router_Route(
        'project/:project_slug/note/:note_slug/edit',
        array('module' => 'project', 'controller' => 'notes', 'action' => 'edit')
    ),

     'project/notes/delete' => new Zend_Controller_Router_Route(
        'project/:project_slug/note/:note_slug/delete',
        array('module' => 'project', 'controller' => 'notes', 'action' => 'delete')
    ),

    'project/notes/history' => new Zend_Controller_Router_Route(
        'project/:project_slug/note/:note_slug/history/:page',
        array('module' => 'project', 'controller' => 'notes', 'action' => 'history', 'page' => 1)
    ),

);
