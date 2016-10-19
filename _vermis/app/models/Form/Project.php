<?php

/**
 * =============================================================================
 * @file        Form/Project.php
 * @author      Lukasz Cepowski <lukasz@cepowski.com>
 * @package     Vermis
 * @version     $Id: Project.php 1353 2012-12-26 20:46:41Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2010-2016 Cask Code, KOWeb
 *              All rights reserved.
 *              https://github.com/koweb/Vermis
 * =============================================================================
 */

/**
 * @class   Form_Project
 * @brief   Project form.
 */
class Form_Project extends FreeCode_Form
{
    
    const TYPE_NEW = 'new';
    const TYPE_EDIT = 'edit';
    
    public function __construct($type = self::TYPE_EDIT, $options = null)
    {
        parent::__construct($options);

        $elements = array();
        
        $name = new Zend_Form_Element_Text('name');
        $name
            ->setLabel('name')
            ->setRequired(true)
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(0, 64, 'UTF-8'));
        $elements[] = $name;
        
        $description = new Zend_Form_Element_Textarea('description');
        $description
            ->setLabel('description');
        $elements[] = $description;
            
        $isPrivate = new Zend_Form_Element_Checkbox('is_private');
        $isPrivate->setDescription('this_is_a_private_project');
        $elements[] = $isPrivate;
            
        if ($type == self::TYPE_NEW) {
            $joinProject = new Zend_Form_Element_Checkbox('join_project');
            $joinProject
                ->setDescription("join_me_to_this_project")
                ->setValue(true);
            $elements[] = $joinProject;
        }
            
        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setLabel('Submit');
        $elements[] = $submit;

        $this->addElements($elements);

    }

}
