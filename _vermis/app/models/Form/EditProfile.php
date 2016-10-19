<?php

/**
 * =============================================================================
 * @file        Form/EditProfile.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: EditProfile.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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