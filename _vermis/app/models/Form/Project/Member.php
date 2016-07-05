<?php

/**
 * =============================================================================
 * @file        Form/Project/Member.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Member.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
