<?php

/**
 * =============================================================================
 * @file        Form/Project/Milestone.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Milestone.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
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
