<?php

/**
 * =============================================================================
 * @file        Form/RemindPassword.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: RemindPassword.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
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
