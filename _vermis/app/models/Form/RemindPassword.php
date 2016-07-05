<?php

/**
 * =============================================================================
 * @file        Form/RemindPassword.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: RemindPassword.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Form_RemindPassword
 * @brief   Remind password form.
 */
class Form_RemindPassword extends FreeCode_Form
{
    
    public function __construct($options = null)
    {
        parent::__construct($options);

        $email = new Zend_Form_Element_Text('email');
        $email
            ->setLabel('email_or_username')
            ->setRequired(true);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setLabel('submit');

        $this->addElements(array(
            $email,
            $submit
        ));

    }

}
