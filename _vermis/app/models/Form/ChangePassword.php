<?php

/**
 * =============================================================================
 * @file        Form/ChangePassword.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: ChangePassword.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
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