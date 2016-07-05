<?php

/**
 * =============================================================================
 * @file        Form/Project/Note.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: Note.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Form_Project_Note
 * @brief   Note form.
 */
class Form_Project_Note extends FreeCode_Form
{
    
    public function __construct($options = null)
    {
        parent::__construct($options);

        $title = new Zend_Form_Element_Text('title');
        $title
            ->setLabel('title')
            ->setRequired(true)
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(0, 64, 'UTF-8'));
            
        $content = new Zend_Form_Element_Textarea('content');
        $content
            ->setLabel('content');
            
        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setLabel('submit');

        $this->addElements(array(
            $title,
            $content,
            $submit
        ));

    }

}
