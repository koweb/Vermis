<?php

/**
 * =============================================================================
 * @file        Form/EditProfile.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: EditProfile.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Form_EditProfile
 * @brief Edit profile.
 */
class Form_EditProfile extends FreeCode_Form
{
    
    public function __construct($options = null)
    {
        parent::__construct($options);

        $login = new Zend_Form_Element_Text('login');
        $login
            ->setLabel('username')
            ->setRequired(true)
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(0, 64, 'UTF-8'));
            
        $name = new Zend_Form_Element_Text('name');
        $name
            ->setLabel('display_name')
            ->setRequired(true)
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(0, 64, 'UTF-8'));
            
        $email = new Zend_Form_Element_Text('email');
        $email  
            ->setLabel('email')
            ->setRequired(true)
            ->addValidator(new Zend_Validate_EmailAddress());
            
        $emailNotify = new Zend_Form_Element_Checkbox('email_notify');
        $emailNotify->setDescription('send_me_email_notifications');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setLabel('submit');

        $this->addElements(array(
            $login,
            $name,
            $email,
            $emailNotify,
            $submit
        ));
    }

}