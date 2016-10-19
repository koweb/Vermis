<?php

/**
 * =============================================================================
 * @file        Form/Project/Milestone.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Milestone.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2012 HellWorx Software
 *              All rights reserved.
 *              www.hellworx.com
 * =============================================================================
 */

/**
 * @class   Form_Project_Milestone
 * @brief   Milestone form.
 */
class Form_Project_Milestone extends FreeCode_Form
{
    
    public function __construct($options = null)
    {
        parent::__construct($options);

        $name = new Zend_Form_Element_Text('name');
        $name
            ->setLabel('name')
            ->setRequired(true)
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(0, 64, 'UTF-8'));
            
        $description = new Zend_Form_Element_Textarea('description');
        $description
            ->setLabel('description');
            
        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setLabel('submit');

        $this->addElements(array(
            $name,
            $description,
            $submit
        ));

    }

}
