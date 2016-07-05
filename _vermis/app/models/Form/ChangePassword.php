<?php

/**
 * =============================================================================
 * @file        Form/ChangePassword.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: ChangePassword.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class Form_ChangePassword
 * @brief Change password.
 */
class Form_ChangePassword extends FreeCode_Form
{
    
    public function __construct($options = null)
    {
        parent::__construct($options);

        $oldPassword = new Zend_Form_Element_Password('old_password');
        $oldPassword
            ->setLabel('old_password')
            ->setRequired(true);
        
        $newPassword = new Zend_Form_Element_Password('new_password');
        $newPassword
            ->setLabel('new_password')
            ->setRequired(true);

        $passwordRepeat = new Zend_Form_Element_Password('password_repeat');
        $passwordRepeat
            ->setLabel('confirm_password')
            ->setRequired(true);
        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setLabel('submit');

        $this->addElements(array(
            $oldPassword,
            $newPassword,
            $passwordRepeat,
            $submit
        ));
    }

}