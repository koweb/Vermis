<?php

/**
 * =============================================================================
 * @file        Form/Project/Member.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Member.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Form_Project_Member
 * @brief   Add member form.
 */
class Form_Project_Member extends FreeCode_Form
{
    
    public function __construct($projectId, $options = null)
    {
        parent::__construct($options);

        $users = Doctrine::getTable('Project_Member')
            ->getProjectNonMembersQuery($projectId)
            ->execute();
        $options = array();
        foreach ($users as $user)
            $options[$user['id']] = $user['name']; 
        
        $userId = new Zend_Form_Element_Select('user_id');
        $userId
            ->setLabel('user')
            ->setDescription('name_of_the_developer')
            ->setRequired(true)
            ->setMultiOptions($options);
            
        $role = new Zend_Form_Element_Select('role');
        $role
            ->setLabel('Role')
            ->setDescription('role_in_this_project')
            ->setRequired(true)
            ->setMultiOptions(Project_Member::$roleLabels)
            ->setValue(Project_Member::ROLE_DEVELOPER);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('add');

        $this->addElements(array(
            $userId,
            $role,
            $submit
        ));

    }

}
