<?php

/**
 * =============================================================================
 * @file        Form/Project/SimpleIssue.php
 * @author      Lukasz Cepowski <lukasz[at]cepowski.pl>
 * @package     Vermis
 * @version     $Id: SimpleIssue.php 109 2011-01-23 21:42:27Z cepa $
 * 
 * @copyright   Vermis :: The Issue Tracking System
 *              Copyright (C) 2011 Ognisco
 *              All rights reserved.
 *              www.ognisco.com
 * =============================================================================
 */

/**
 * @class   Form_Project_SimpleIssue
 * @brief   Issue form.
 */
class Form_Project_SimpleIssue extends FreeCode_Form
{
    
    protected $_userId = null;
    
    public function __construct($userId, $options = null)
    {
        parent::__construct($options);

        $this->_userId = $userId;
        
        $projectId = new Zend_Form_Element_Select('project_id');
        $projectId
            ->setLabel('project')
            ->setRequired(true)
            ->setMultiOptions($this->fetchProjectsAsOptions());
            
        $type = new Zend_Form_Element_Select('type');
        $type
            ->setLabel('type')
            ->setMultiOptions(Project_Issue::$typeLabels)
            ->setValue(Project_Issue::TYPE_TASK)
            ->setRequired(true);
        
        $title = new Zend_Form_Element_Text('title');
        $title
            ->setLabel('title')
            ->setRequired(true)
            ->addFilter(new Zend_Filter_StripTags())
            ->addValidator(new Zend_Validate_StringLength(0, 255, 'UTF-8'));
            
        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('description');
            
        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setLabel('submit');

        $this->addElements(array(
            $projectId,
            $type,
            $title,
            $description,
            $submit
        ));
    }
    
    public function fetchProjectsAsOptions()
    {
        $options = array();
        $records = Doctrine::getTable('Project')
            ->getAvailableProjectsQuery($this->_userId)
            ->select("p.id, p.name")
            ->execute();
        foreach ($records as $record)
            $options[$record['id']] = $record['name'];
        return $options;
    }
    
}
