<?php

/**
 * =============================================================================
 * @file        Acl.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Acl.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Acl
 * @brief   Access Control List.
 */
class Acl extends Zend_Acl
{

    public function __construct()
    {
        $roleGuest     = new Zend_Acl_Role(User::ROLE_GUEST);
        $roleUser      = new Zend_Acl_Role(User::ROLE_USER);
        $roleAdmin     = new Zend_Acl_Role(User::ROLE_ADMIN);

        $this
            ->addRole($roleGuest)
            ->addRole($roleUser, array($roleGuest))
            ->addRole($roleAdmin, array($roleUser));

        $this
            ->add(new Zend_Acl_Resource('default'))
            ->add(new Zend_Acl_Resource('project'))
            ->add(new Zend_Acl_Resource('projects/new'))
            ->add(new Zend_Acl_Resource('issues'))
            ->add(new Zend_Acl_Resource('issues/new'))
            ->add(new Zend_Acl_Resource('users'))
            ->add(new Zend_Acl_Resource('users/new'))
            ->add(new Zend_Acl_Resource('users/edit'))
            ->add(new Zend_Acl_Resource('users/delete'))
            ->add(new Zend_Acl_Resource('users/register'))
            ->add(new Zend_Acl_Resource('users/activate'))
            ->add(new Zend_Acl_Resource('users/remind-password'))
            ->add(new Zend_Acl_Resource('users/generate-password'))
            ->add(new Zend_Acl_Resource('project/index/edit'))
            ->add(new Zend_Acl_Resource('project/index/delete'))
            ->add(new Zend_Acl_Resource('project/milestones/new'))
            ->add(new Zend_Acl_Resource('project/milestones/edit'))
            ->add(new Zend_Acl_Resource('project/milestones/delete'))
            ->add(new Zend_Acl_Resource('project/components/new'))
            ->add(new Zend_Acl_Resource('project/components/edit'))
            ->add(new Zend_Acl_Resource('project/components/delete'))
            ->add(new Zend_Acl_Resource('project/notes/new'))
            ->add(new Zend_Acl_Resource('project/notes/edit'))
            ->add(new Zend_Acl_Resource('project/notes/delete'))
            ->add(new Zend_Acl_Resource('project/members/add'))
            ->add(new Zend_Acl_Resource('project/members/delete'))
            ->add(new Zend_Acl_Resource('project/issues/new'))
            ->add(new Zend_Acl_Resource('project/issues/edit'))
            ->add(new Zend_Acl_Resource('project/issues/delete'))
            ->add(new Zend_Acl_Resource('project/issues_comments/add'))
            ->add(new Zend_Acl_Resource('project/issues_comments/delete'))
            ->add(new Zend_Acl_Resource('project/issues_files/upload'))
            ->add(new Zend_Acl_Resource('project/issues_files/delete'))
            ;
            

        $this
            ->allow($roleGuest, 'default')
            ->allow($roleGuest, 'project')
            ->allow($roleGuest, 'issues')
            ->allow($roleUser,  'issues/new')
            ->allow($roleUser,  'users')
            ->allow($roleAdmin, 'users/new')
            ->allow($roleAdmin, 'users/edit')
            ->allow($roleAdmin, 'users/delete')
            ->allow($roleGuest, 'users/register')
            ->allow($roleGuest, 'users/activate')
            ->allow($roleGuest, 'users/remind-password')
            ->allow($roleGuest, 'users/generate-password')
            ->allow($roleAdmin, 'projects/new')
            ->allow($roleUser,  'project/index/edit')
            ->allow($roleAdmin, 'project/index/delete')
            ->allow($roleUser,  'project/milestones/new')
            ->allow($roleUser,  'project/milestones/edit')
            ->allow($roleAdmin, 'project/milestones/delete')
            ->allow($roleUser,  'project/components/new')
            ->allow($roleUser,  'project/components/edit')
            ->allow($roleAdmin, 'project/components/delete')
            ->allow($roleUser,  'project/notes/new')
            ->allow($roleUser,  'project/notes/edit')
            ->allow($roleAdmin, 'project/notes/delete')
            ->allow($roleAdmin, 'project/members/add')
            ->allow($roleAdmin, 'project/members/delete')
            ->allow($roleUser,  'project/issues/new')
            ->allow($roleUser,  'project/issues/edit')
            ->allow($roleAdmin, 'project/issues/delete')
            ->allow($roleUser,  'project/issues_comments/add')
            ->allow($roleAdmin, 'project/issues_comments/delete')
            ->allow($roleUser,  'project/issues_files/upload')
            ->allow($roleAdmin, 'project/issues_files/delete')
            ;
    }
    
}
