<?php

/**
 * =============================================================================
 * @file        Form/Login.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Login.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
