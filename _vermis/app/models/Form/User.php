<?php

/**
 * =============================================================================
 * @file        Form/User.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: User.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Form_User
 * @brief   User form.
 */
class Form_User extends FreeCode_Form
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
                        
        $role = new Zend_Form_Element_Select('role');
        $role   
            ->setLabel('role')
            ->setRequired(true)
            ->setMultiOptions(array(
                User::ROLE_USER => 'User',
                User::ROLE_ADMIN => 'Admin'
            ))
            ->setValue(User::ROLE_USER)
            ->addValidator(new Zend_Validate_Alnum());
            
        $password = new Zend_Form_Element_Password('password');
        $password
            ->setLabel('password')
            ->setRequired(true);

        $passwordRepeat = new Zend_Form_Element_Password('password_repeat');
        $passwordRepeat
            ->setLabel('confirm_password')
            ->setRequired(true);
            
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

        $status = new Zend_Form_Element_Select('status');
        $status
            ->setLabel('status')
            ->setRequired(true)
            ->setMultiOptions(array(
                User::STATUS_ACTIVE => 'active',
                User::STATUS_INACTIVE => 'inactive',
                User::STATUS_BANNED => 'banned'
            ))
            ->setValue(User::STATUS_ACTIVE);

        $emailNotify = new Zend_Form_Element_Checkbox('email_notify');
        $emailNotify
            ->setDescription('send_me_email_notifications')
            ->setValue(true);
        
        $captcha = new Zend_Form_Element_Captcha('captcha', array(
            'label' => 'captcha',
            'captcha' => new FreeCode_Captcha_Image()
        ));
            
        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setLabel('submit');

        $this->addElements(array(
            $login,
            $name,
            $email,
            $password,
            $passwordRepeat,
            $role,
            $status,
            $emailNotify
        ));
        
        if (isset($options['enableCaptcha']) && $options['enableCaptcha'])
            $this->addElement($captcha);
        
        $this->addElement($submit);

    }

}
