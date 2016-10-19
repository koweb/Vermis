<?php

/**
 * =============================================================================
 * @file        Form/Login.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Login.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Form_Login
 * @brief   Login form.
 */
class Form_Login extends FreeCode_Form
{
    
    public function __construct($options = null)
    {
        parent::__construct($options);

        $login = new Zend_Form_Element_Text('login');
        $login
            ->setLabel('username')
            ->setRequired(true);

        $password = new Zend_Form_Element_Password('password');
        $password
            ->setLabel('password')
            ->setRequired(true);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setLabel('enter');

        $this->addElements(array(
            $login,
            $password,
            $submit
        ));

    }

}
